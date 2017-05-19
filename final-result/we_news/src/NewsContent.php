<?php

namespace Drupal\we_news;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\node\NodeInterface;

/**
 * Provides services for the News content type.
 */
class NewsContent implements NewsContentInterface {

  /**
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entityTypeManager
   */
  public function __construct(EntityTypeManagerInterface $entityTypeManager) {
    $this->entityTypeManager = $entityTypeManager;
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
  public function getCategory(ContentEntityInterface $entity) {

    $category = NULL;
    if ($entity->hasField('field_news_category')) {
      $field = $entity->get('field_news_category');
      if (!$field->isEmpty()) {
        $category = $field->entity;
      }
    }

    return $category;
  }
}
