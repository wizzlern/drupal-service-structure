<?php

namespace Drupal\we_news\Plugin\ExtraField\FieldFormatter;

use Drupal\Core\Entity\Display\EntityViewDisplayInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\extra_field\Plugin\ExtraFieldFormatterBase;
use Drupal\node\NodeInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Extra field for Editor Profile.
 *
 * @ExtraFieldFormatter(
 *   id = "related_news",
 *   label = @Translation("Related news"),
 *   bundles = {
 *     "node.news",
 *   }
 * )
 */
class RelatedNews extends ExtraFieldFormatterBase implements ContainerFactoryPluginInterface {

  /**
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityTypeManagerInterface $entity_type_manager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);

    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function view(EntityInterface $entity, EntityViewDisplayInterface $display, $view_mode) {

    $build = [];

    /** @var \Drupal\Core\Entity\ContentEntityInterface $entity */
    if ($entity->hasField('field_news_category')) {
      $category = NULL;
      $field = $entity->get('field_news_category');
      if (!$field->isEmpty()) {
        $category = $field->entity;
      }

      if ($category) {
        $query = $this->entityTypeManager->getStorage('node')->getQuery()
          ->condition('status', NodeInterface::PUBLISHED)
          ->condition('type', 'news')
          ->condition('field_news_category', $category->id())
          ->sort('created', 'DESC')
          ->range(0, 2);
        $nids = $query->execute();

        $nodes = [];
        if ($nids) {
          $nodes = $this->entityTypeManager->getStorage('node')
            ->loadMultiple($nids);
        }

        $items = [];
        foreach ($nodes as $node) {
          $items[] = $this->entityTypeManager->getViewBuilder('node')
            ->view($node, 'teaser');
        }

        $build = [
          '#theme' => 'item_list',
          '#items' => $items,
          // @todo Add cache tag to invalidate when news is added.
          '#cache' => ['max-age' => 0],
        ];
      }
    }

    return $build;
  }

}
