<?php

namespace Drupal\we_news;

use Drupal\Core\Entity\ContentEntityInterface;

/**
 * Interface for NewsBuild.
 */
interface NewsBuildInterface {

  /**
   * Builds related news.
   *
   * @param \Drupal\Core\Entity\ContentEntityInterface $entity
   *   The entity for which to build the related news.
   * @param integer $max
   *   Maximum number of news items to return.
   *
   * @return array
   *   Renderable array with related news items.
   */
  public function relatedNews(ContentEntityInterface $entity, $max = 10);

}
