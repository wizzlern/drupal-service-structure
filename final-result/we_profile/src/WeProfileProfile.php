<?php

namespace Drupal\we_profile;

use Drupal\Core\Entity\EntityFieldManagerInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Routing\CurrentRouteMatch;

/**
 * Provides services for the User Profile.
 */
class WeProfileProfile implements WeProfileProfileInterface {

  /**
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * @var \Drupal\Core\Routing\CurrentRouteMatch
   */
  protected $routeMatch;

  /**
   * @var \Drupal\Core\Entity\EntityFieldManagerInterface
   */
  protected $entityFieldManager;

  /**
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   * @param \Drupal\Core\Routing\CurrentRouteMatch $routeMatch
   * @param \Drupal\Core\Entity\EntityFieldManagerInterface $entity_field_manager
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager, CurrentRouteMatch $routeMatch, EntityFieldManagerInterface $entity_field_manager) {
    $this->entityTypeManager = $entity_type_manager;
    $this->routeMatch = $routeMatch;
    $this->entityFieldManager = $entity_field_manager;
  }

  /**
   * {@inheritdoc}
   */
  public function allGrades() {

    /** @var EntityFieldManagerInterface $entityFieldManager */
    $grades = $this->entityFieldManager
      ->getFieldStorageDefinitions('node')['field_editor_grade']
      ->getSetting('allowed_values');

    return $grades;
  }

  /**
   * {@inheritdoc}
   */
  public function allEditors() {

    $query = $this->entityTypeManager->getStorage('node')->getQuery()
      ->condition('type', 'editor')
      ->condition('status', 1)
      ->sort('field_editor_grade', 'DESC')
      ->sort('field_user_name', 'ASC');
    $nids = $query->execute();

    $nodes = [];
    if ($nids) {
      $nodes = $this->entityTypeManager->getStorage('node')->loadMultiple($nids);
    }

    return $nodes;
  }

  /**
   * {@inheritdoc}
   */
  public function editorsByGrade($grade) {

    $query = $this->entityTypeManager->getStorage('node')->getQuery()
      ->condition('type', 'editor')
      ->condition('status', 1)
      ->condition('field_editor_grade', $grade)
      ->sort('title', 'ASC');
    $nids = $query->execute();

    $nodes = [];
    if ($nids) {
      $nodes = $this->entityTypeManager->getStorage('node')->loadMultiple($nids);
    }

    return $nodes;
  }

  /**
   * {@inheritdoc}
   */
  public function nodeEditor($entity) {

    $editor = NULL;

    if ($entity->hasField('field_news_editor')) {
      $field = $entity->get('field_news_editor');
      if (!$field->isEmpty()) {
        $editor = $field->entity;
      }
    }

    return $editor;
  }

}
