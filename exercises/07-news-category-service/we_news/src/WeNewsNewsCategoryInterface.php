<?php

namespace Drupal\we_news;

/**
 * Interface for WeNewsNewsCategory.
 */
interface WeNewsNewsCategoryInterface {

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

}
