<?php

namespace Drupal\extra_field\Plugin;

use Drupal\Core\Entity\Display\EntityViewDisplayInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;

class ExtraFieldFormatterManager extends DefaultPluginManager implements ExtraFieldFormatterManagerInterface {

  /**
   * Caches bundles per entity type.
   *
   * @var array
   */
  protected $entityBundles;

  /**
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructor for ExtraFieldFormatterManager objects.
   *
   * @param \Traversable $namespaces
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler, EntityTypeManagerInterface $entity_type_manager) {

    parent::__construct('Plugin/ExtraField/FieldFormatter', $namespaces, $module_handler, 'Drupal\extra_field\Plugin\ExtraFieldFormatterInterface', 'Drupal\extra_field\Annotation\ExtraFieldFormatter');

    $this->alterInfo('extra_field_formatter_info');
    $this->setCacheBackend($cache_backend, 'extra_field_formatter_plugins');
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public function fieldInfo() {

    $info = [];
    $definitions = $this->getDefinitions();

    foreach ($definitions as $key => $definition) {
      $entityBundles = $this->supportedEntityBundles($definition['bundles']);

      foreach ($entityBundles as $entityBundle) {
        $entityType = $entityBundle['entity'];
        $bundle = $entityBundle['bundle'];
        $fieldName = $this->fieldName($key);
        $info[$entityType][$bundle]['display'][$fieldName] = [
          'label' => $definition['label'],
          'weight' => $definition['weight'],
          'visible' => $definition['visible'],
        ];
      }
    }

    return $info;
  }

  /**
   * {@inheritdoc}
   */
  public function entityView(array &$build, EntityInterface $entity, EntityViewDisplayInterface $display, $view_mode) {

    $definitions = $this->getDefinitions();
    $entityBundleKey = $this->entityBundleKey($entity->getEntityTypeId(), $entity->bundle());
    foreach ($definitions as $definition) {
      if ($this->matchEntityBundleKey($definition['bundles'], $entityBundleKey)) {

        $factory = $this->getFactory();
        $pluginId = $definition['id'];
        if ($display->getComponent($this->fieldName($pluginId))) {

          $plugin = $factory->createInstance($pluginId);
          $fieldName = $this->fieldName($pluginId);
          $build[$fieldName] = $plugin->view($entity, $display, $view_mode);
        }
      }
    }
  }

  /**
   * Checks if the plugin bundle definition matches the entity bundle key.
   *
   * @param string[] $pluginBundles
   *   Defines which entity-bundle pair the plugin can be used for.
   *   Format: [entity type].[bundle] or [entity type].*
   * @param $entityBundleKey
   *   The entity-bundle string of a content entity.
   *   Format: [entity type].[bundle]
   *
   * @return boolean
   */
  protected function matchEntityBundleKey($pluginBundles, $entityBundleKey) {

    $match = FALSE;
    foreach ($pluginBundles as $pluginBundle) {
      if (strpos($pluginBundle, '.*')) {
        $match = explode('.', $pluginBundle)[0] == explode('.', $entityBundleKey)[0];
      }
      else {
        $match = $pluginBundle == $entityBundleKey;
      }

      if ($match) {
        break;
      }
    }

    return $match;
  }

  /**
   * Returns entity-bundle combinations this plugin supports.
   *
   * If a wildcard bundle is set, all bundles of the entity will be included.
   *
   * @param string[] $entityBundleKeys
   *   Array of entity-bundle strings that define the bundles for which the
   *   plugin can be used. Format: [entity].[bundle]
   *   '*' can be used as bundle wildcard.
   *
   * @return array
   *   Array of entity and bundle names. Keyed by the [entity].[bundle] key.
   */
  protected function supportedEntityBundles($entityBundleKeys) {

    $result = [];
    foreach ($entityBundleKeys as $entityBundleKey) {
      if (strpos($entityBundleKey, '.')) {
        list($entityType, $bundle) = explode('.', $entityBundleKey);
        if ($bundle == '*') {
          foreach($this->allEntityBundles($entityType) as $bundle) {
            $key = $this->entityBundleKey($entityType, $bundle);
            $result[$key] = [
              'entity' => $entityType,
              'bundle' => $bundle,
            ];
          }
        }
        else {
          $result[$entityBundleKey] = [
            'entity' => $entityType,
            'bundle' => $bundle,
          ];
        }
      }
    }

    return $result;
  }

  /**
   * Returns the bundles that are defined for an entity type.
   *
   * @param string $entityType
   *   The entity type to get the bundles for.
   *
   * @return string[]
   *   Array of bundle names.
   */
  protected function allEntityBundles($entityType) {

    if (!isset($this->entityBundles[$entityType])) {
      $bundleType = $this->entityTypeManager
        ->getDefinition($entityType)
        ->getBundleEntityType();

      if ($bundleType) {
        $bundles = $this->entityTypeManager
          ->getStorage($bundleType)
          ->getQuery()
          ->execute();
      }
      else {
        $bundles = [$entityType => $entityType];
      }
      $this->entityBundles[$entityType] = $bundles;
    }

    return $this->entityBundles[$entityType];
  }

  /**
   * Build the field name string.
   *
   * @param string $pluginId
   *   Plugin ID
   *
   * @return string
   *   Field name.
   */
  protected function fieldName($pluginId) {

    return 'extra_field_' . $pluginId;
  }

  /**
   * Creates a key string with entity type and bundle.
   *
   * @param string $entityType
   *   The entity type.
   * @param string $bundle
   *   The bundle.
   *
   * @return string
   *   Formatted string.
   */
  protected function entityBundleKey($entityType, $bundle) {

    return "$entityType.$bundle";
  }

}
