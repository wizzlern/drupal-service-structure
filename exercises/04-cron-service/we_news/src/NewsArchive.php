<?php

namespace Drupal\we_news;

use Drupal\Core\Entity\EntityTypeManagerInterface;

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

  // @todo Create a method to be used on cron.

}

