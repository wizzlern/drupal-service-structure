<?php

namespace Drupal\we_news;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Language\LanguageManagerInterface;
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
   * @var string
   */
  protected $currentLanguageCode;

  /**
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entityTypeManager
   */
  public function __construct(EntityTypeManagerInterface $entityTypeManager, LanguageManagerInterface $languageManager) {
    $this->entityTypeManager = $entityTypeManager;
    $this->currentLanguageCode = $languageManager->getCurrentLanguage()->getId();
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

    foreach ($nodes as $key => $node) {
      if ($node->hasTranslation($this->currentLanguageCode)) {
        $nodes[$key] = $node->getTranslation($this->currentLanguageCode);
      }
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

    foreach ($nodes as $key => $node) {
      if ($node->hasTranslation($this->currentLanguageCode)) {
        $nodes[$key] = $node->getTranslation($this->currentLanguageCode);
      }
    }

    return $nodes;
  }

}
