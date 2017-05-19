<?php

namespace Drupal\we_news\Plugin\ExtraField\FieldFormatter;

use Drupal\Core\Entity\Display\EntityViewDisplayInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\extra_field\Plugin\ExtraFieldFormatterBase;
use Drupal\we_news\NewsContentInterface;
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
   * @var \Drupal\we_news\NewsContentInterface
   */
  protected $newsContent;

  /**
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   * @param \Drupal\we_news\NewsContentInterface $news_content
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityTypeManagerInterface $entity_type_manager, NewsContentInterface $news_content) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);

    $this->entityTypeManager = $entity_type_manager;
    $this->newsContent = $news_content;
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
      $container->get('we_news.content')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function view(EntityInterface $entity, EntityViewDisplayInterface $display, $view_mode) {

    $build = [];
    /** @var \Drupal\Core\Entity\ContentEntityInterface $entity */
    $category = $this->newsContent->getCategory($entity);

    if ($category) {
      $news = $this->newsContent->newsByCategory($category->id(), 2);

      $items = [];
      foreach ($news as $node) {
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

    return $build;
  }

}
