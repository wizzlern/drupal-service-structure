<?php

namespace Drupal\we_news;

use Drupal\Core\Entity\ContentEntityInterface;

/**
 * Interface for NewsContent.
 */
interface NewsContentInterface {

  /**
   * Returns the latest news nodes.
   *
   * @param integer $limit
   *   Maximum number of items to return.
   *
   * @return \Drupal\node\NodeInterface[]
   *   News nodes.
   */
  public function latestNews($limit = 10);

  /**
   * Returns the latest news by news categories.
   *
   * @param integer|integer[] $categories
   *   News categories (Term ID), or array of.
   * @param integer $limit
   *   Maximum number of items to return.
   *
   * @return \Drupal\node\NodeInterface[]
   *   News nodes.
   */
  public function newsByCategory($categories, $limit = 10);

  /**
   * Returns the news category of a node.
   *
   * @param \Drupal\Core\Entity\ContentEntityInterface $entity
   *
   * @return \Drupal\taxonomy\Entity\Term|null News category term.
   *   News category term.
   */
  public function getCategory(ContentEntityInterface $entity);
}
