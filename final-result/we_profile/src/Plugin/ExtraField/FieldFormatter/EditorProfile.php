<?php

namespace Drupal\we_profile\Plugin\ExtraField\FieldFormatter;

use Drupal\Core\Entity\Display\EntityViewDisplayInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\extra_field\Plugin\ExtraFieldFormatterBase;
use Drupal\we_profile\WeProfileProfileInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Extra field for Editor Profile.
 *
 * @ExtraFieldFormatter(
 *   id = "editor_profile",
 *   label = @Translation("Editor profile"),
 *   bundles = {
 *     "node.news",
 *   }
 * )
 */
class EditorProfile extends ExtraFieldFormatterBase implements ContainerFactoryPluginInterface {

  /**
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * @var \Drupal\we_profile\WeProfileProfileInterface
   */
  protected $profile;

  /**
   * Constructs a Drupal\Component\Plugin\PluginBase object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   * @param \Drupal\we_profile\WeProfileProfileInterface $profile
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityTypeManagerInterface $entity_type_manager, WeProfileProfileInterface $profile) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);

    $this->entityTypeManager = $entity_type_manager;
    $this->profile = $profile;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_type.manager'),
      $container->get('we_profile.profile')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function view(EntityInterface $entity, EntityViewDisplayInterface $display, $view_mode) {

    $profile = $this->profile->currentPageEditor();
    $build = [];

    if ($profile) {
      $build = $this->entityTypeManager
        ->getViewBuilder('node')
        ->view($profile, 'teaser');
    }

    return $build;
  }

}
