<?php

namespace Drupal\we_news;

use Drupal\Core\Entity\EntityTypeManagerInterface;
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
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
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
   * {@inheritdoc}
   */
  public function categoriesByGroup($group_name) {

    switch ($group_name) {
      case 'tech':
        $tids = self::CATEGORY_GROUP_TECH;
        break;

      case 'popular':
        $tids = self::CATEGORY_GROUP_POPULAR;
        break;

      default:
        throw new \RuntimeException('Unknown group name');
        break;
    }

    /** @var \Drupal\taxonomy\Entity\Term[] $categories */
    $categories = $this->entityTypeManager->getStorage('taxonomy_term')->loadMultiple($tids);

    return $categories;
  }

}
