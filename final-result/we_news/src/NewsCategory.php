<?php

namespace Drupal\we_news;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Language\LanguageManagerInterface;
use Drupal\Core\Routing\CurrentRouteMatch;
use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * Provides services for the News Category taxonomy terms.
 */
class NewsCategory implements NewsCategoryInterface {

  use StringTranslationTrait;

  /**
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * @var string
   */
  protected $currentLanguageCode;

  /**
   * @var \Drupal\Core\Routing\CurrentRouteMatch
   */
  protected $routeMatch;

  /**
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   * @param \Drupal\Core\Language\LanguageManagerInterface $languageManager
   * @param \Drupal\Core\Routing\CurrentRouteMatch $routeMatch
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager, LanguageManagerInterface $languageManager, CurrentRouteMatch $routeMatch) {
    $this->entityTypeManager = $entity_type_manager;
    $this->currentLanguageCode = $languageManager->getCurrentLanguage()->getId();
    $this->routeMatch = $routeMatch;
  }

  /**
   * {@inheritdoc}
   */
  public function categoryNames() {

    $categories = [];
    /** @var \Drupal\taxonomy\Entity\Term $terms */
    $terms = $this->entityTypeManager
      ->getStorage('taxonomy_term')
      ->loadTree(self::CATEGORY_VOCABULARY);

    foreach ($terms as $term) {
      $categories[$term->id()] = $term->label();
    }

    return $categories;
  }

  /**
   * {@inheritdoc}
   */
  public function categoryGroups() {

    $groups = [
      'tech' => $this->t('Technology'),
      'popular' => $this->t('Popular'),
    ];

    return $groups;
  }

  /**
   * Returns the news categories that belong to a group.
   *
   * @param string $group_name
   *   Group name.
   *
   * @return string[]
   *   News category names keyed by their term ID.
   */
  public function categoryNamesByGroup($group_name) {

    switch ($group_name) {
      case 'tech':
        $tids = self::CATEGORY_GROUP_TECH;
        break;

      case 'popular':
        $tids = self::CATEGORY_GROUP_POPULAR;
        break;

      default:
        $tids = [];
        break;
    }

    $terms = $this->entityTypeManager->getStorage('taxonomy_term')->loadMultiple($tids);
    $categories = [];
    foreach ($terms as $term) {
      $categories[$term->id()] = $term->label();
    }

    return $categories;
  }

  /**
   * {@inheritdoc}
   */
  public function currentPageCategory() {

    $category = NULL;
    $node = $this->routeMatch->getParameter('node');
    if ($node) {
      $category = $this->entityCategory($node);
    }

    return $category;
  }

  /**
   * {@inheritdoc}
   */
  public function entityCategory(ContentEntityInterface $entity) {

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
