<?php

namespace Drupal\we_news;

/**
 * Interface for NewsArchive.
 */
interface NewsArchiveInterface {

  /**
   * Performs cron tasks for archiving news content.
   */
  public function archiveNews();

}
