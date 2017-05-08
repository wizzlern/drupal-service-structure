<?php

namespace Drupal\we_news;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\node\NodeInterface;

/**
 * Provides services for the News content type.
 */
class NewsArchive implements NewsArchiveInterface {

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
   * Performs cron tasks for news content.
   */
  public function onCron() {

    // Get news articles that are not yet archived after 1 year.
    $threshold = strtotime('-1 year', $_SERVER['REQUEST_TIME']);
    $query = $this->entityTypeManager->getStorage('node')->getQuery()
      ->condition('type', 'news')
      ->condition('field_news_archive', 0)
      ->condition('created', $threshold, '<');
    $nids = $query->execute();

    // Mark news articles as archived.
    if ($nids) {
      foreach ($nids as $nid) {
        /** @var \Drupal\node\Entity\Node $node */
        $node = $this->entityTypeManager->getStorage('node')->load($nid);
        $node->set('field_news_archive', 1);
        $node->save();
      }
    }

  }
}

