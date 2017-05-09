<?php

namespace Drupal\we_news;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;

/**
 * Provides services for the News content type.
 */
class NewsBuild implements NewsBuildInterface {

  /**
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * @var \Drupal\we_news\NewsContent
   */
  protected $newsContent;

  /**
   * @var \Drupal\we_news\NewsCategory
   */
  protected $newsCategory;

  /**
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entityTypeManager
   * @param \Drupal\we_news\NewsContent $newsContent
   * @param \Drupal\we_news\NewsCategory $newsCategory
   */
  public function __construct(EntityTypeManagerInterface $entityTypeManager, NewsContent $newsContent, NewsCategory $newsCategory) {
    $this->entityTypeManager = $entityTypeManager;
    $this->newsContent = $newsContent;
    $this->newsCategory = $newsCategory;
  }

  /**
   * {@inheritdoc}
   */
  public function relatedNews(ContentEntityInterface $entity, $max = 10) {

    $build = ['#markup' => 'TODO relatedNews output'];

    return $build;
  }

}
