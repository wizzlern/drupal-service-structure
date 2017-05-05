<?php

namespace Drupal\we_news;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Routing\CurrentRouteMatch;
use Drupal\node\NodeInterface;

/**
 * Provides services for the News content type.
 */
class WeNewsNews implements WeNewsNewsInterface {

  /**
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * @var \Drupal\Core\Routing\CurrentRouteMatch
   */
  protected $routeMatch;

  /**
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entityTypeManager
   */
  public function __construct(EntityTypeManagerInterface $entityTypeManager, CurrentRouteMatch $routeMatch) {
    $this->entityTypeManager = $entityTypeManager;
    $this->routeMatch = $routeMatch;
  }

  /**
   * {@inheritdoc}
   */
  public function latestNews($limit = 10) {

    $query = $this->entityTypeManager->getStorage('node')->getQuery()
      ->condition('status', NodeInterface::PUBLISHED)
      ->condition('type', 'news')
      ->sort('created', 'DESC');
    if ($limit) {
      $query->range(0, $limit);
    }
    $nids = $query->execute();

    $nodes = [];
    if ($nids) {
      $nodes = $this->entityTypeManager->getStorage('node')->loadMultiple($nids);
    }

    return $nodes;
  }

  /**
   * {@inheritdoc}
   */
  public function newsByCategory($categories, $limit = 10) {

    $categories = is_array($categories) ? $categories : [$categories];

    $query = $this->entityTypeManager->getStorage('node')->getQuery()
      ->condition('status', NodeInterface::PUBLISHED)
      ->condition('type', 'news')
      ->condition('field_news_category', $categories, 'IN')
      ->sort('created', 'DESC');
    if ($limit) {
      $query->range(0, $limit);
    }
    $nids = $query->execute();

    $nodes = [];
    if ($nids) {
      $nodes = $this->entityTypeManager->getStorage('node')->loadMultiple($nids);
    }

    return $nodes;
  }

  /**
   * {@inheritdoc}
   */
  public function currentPageNewsCategory() {

    $category = NULL;
    // Load the node, if we have a {node} in the URL.
    /** @var \Drupal\node\Entity\Node $node */
    $node = $this->routeMatch->getParameter('node');

    if ($node && $node->hasField('field_news_category')) {
      $field = $node->get('field_news_category');
      if (!$field->isEmpty()) {
        $category = $field->entity;
      }
    }

    return $category;
  }

}
