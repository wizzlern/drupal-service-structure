<?php

namespace Drupal\we_news\Plugin\Block;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Block\BlockBase;
use Drupal\we_news\WeNewsNewsInterface;
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
   * @var \Drupal\we_news\WeNewsNewsInterface
   */
  protected $news;

  /**
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   * @param \Drupal\we_news\WeNewsNewsInterface $news_manager
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityTypeManagerInterface $entity_type_manager, WeNewsNewsInterface $news_manager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);

    $this->entityTypeManager = $entity_type_manager;
    $this->news = $news_manager;
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
      $container->get('we_news.news')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {

    $items = [];
    $nodes = $this->news->latestNews(5);

    foreach ($nodes as $node) {
      $items[] = $this->entityTypeManager
        ->getViewBuilder('node')
        ->view($node, 'teaser');
    }

    $build = [
      '#theme' => 'item_list',
      '#items' => $items,
      // @todo Add cache tag to invalidate when news is added.
      '#cache' => ['max-age' => 0],
    ];

    return $build;
  }

}
