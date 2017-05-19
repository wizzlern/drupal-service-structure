<?php

namespace Drupal\we_news\Plugin\Block;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Block\BlockBase;
use Drupal\node\NodeInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'Recent News' block.
 *
 * @Block(
 *   id = "we_news_news",
 *   admin_label = @Translation("Recent news"),
 *   category = @Translation("News")
 * )
 */
class WeNewsRecentNews extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
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
  public function build() {

    // Query 5 recent news articles.
    $query = $this->entityTypeManager->getStorage('node')->getQuery()
      ->condition('status', NodeInterface::PUBLISHED)
      ->condition('type', 'news')
      ->sort('created', 'DESC')
      ->range(0, 5);
    $nids = $query->execute();

    // Load Node objects.
    $nodes = $this->entityTypeManager->getStorage('node')
      ->loadMultiple($nids);

    // Build node Teaser view mode.
    $items = [];
    foreach ($nodes as $node) {
      $items[] = $this->entityTypeManager->getViewBuilder('node')
        ->view($node, 'teaser');
    }

    // Build an HTML list for display.
    $build = [
      '#theme' => 'item_list',
      '#items' => $items,
      // @todo Add cache tag to invalidate when an item is added.
      '#cache' => ['max-age' => 0],
    ];

    return $build;
  }

}
