<?php

namespace Drupal\we_news;

/**
 * Interface for NewsCategory.
 */
interface NewsCategoryInterface {

  /**
   * News category vocabulary machine name.
   */
  const CATEGORY_VOCABULARY = 'news_category';

  /**
   * News categories Taxonomy terms.
   */
  const CATEGORY_SPORTS = 1;
  const CATEGORY_SHOWBIZ = 2;
  const CATEGORY_SCIENCE = 3;
  const CATEGORY_INTERNET = 4;
  const CATEGORY_GENERAL = 5;
  const CATEGORY_FASION = 6;
  const CATEGORY_FOOD = 7;
  const CATEGORY_ARTS = 8;

  /**
   * @var integer[]
   */
  const CATEGORY_GROUP_TECH = [self::CATEGORY_INTERNET, self::CATEGORY_SCIENCE];

  /**
   * @var integer[]
   */
  const CATEGORY_GROUP_POPULAR = [self::CATEGORY_GENERAL, self::CATEGORY_SHOWBIZ, self::CATEGORY_SPORTS];

  /**
   * Returns all news categories;
   *
   * @return string[]
   *   News category names keyed by the term ID.
   */
  public function categoryNames();

  /**
   * Returns the available groups.
   *
   * @return \Drupal\Core\StringTranslation\TranslatableMarkup[]
   *   Group names keyed by their group machine name.
   */
  public function categoryGroups();

  /**
   * Returns the news categories that belong to a group.
   *
   * @param string $group_name
   *   Group name.
   *
   * @return \Drupal\taxonomy\Entity\Term[]
   *   News category objects keyed by their term ID.
   *
   * @throws \RuntimeException
   *   When the specified $group_name is unknown.
   */
  public function categoriesByGroup($group_name);

}
