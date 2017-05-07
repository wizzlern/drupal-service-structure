<?php

namespace Drupal\we_news\Plugin\Block;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Block\BlockBase;
use Drupal\we_news\NewsCategoryInterface;
use Drupal\we_news\NewsContentInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'News by category' block.
 *
 * @Block(
 *   id = "we_news_related",
 *   admin_label = @Translation("Related news by category"),
 *   category = @Translation("News")
 * )
 */
class WeNewsRelatedNews extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * @var \Drupal\we_news\NewsContentInterface
   */
  protected $newsContent;

  /**
   * @var \Drupal\we_news\NewsCategoryInterface
   */
  protected $newsCategory;

  /**
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   * @param \Drupal\we_news\NewsContentInterface $news_content
   * @param \Drupal\we_news\NewsCategoryInterface $news_category
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityTypeManagerInterface $entity_type_manager, NewsContentInterface $news_content, NewsCategoryInterface $news_category) {

    parent::__construct($configuration, $plugin_id, $plugin_definition);

    $this->entityTypeManager = $entity_type_manager;
    $this->newsContent = $news_content;
    $this->newsCategory = $news_category;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {

    return new static($configuration, $plugin_id, $plugin_definition, $container->get('entity_type.manager'), $container->get('we_news.content'), $container->get('we_news.category'));
  }

  /**
   * {@inheritdoc}
   */
  public function build() {

    $items = [];
    $category = $this->newsCategory->currentPageCategory();
    $news = $this->newsContent->newsByCategory($category->id());

    foreach ($news as $node) {
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
