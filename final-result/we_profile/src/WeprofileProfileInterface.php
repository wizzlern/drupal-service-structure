<?php

namespace Drupal\we_profile;

/**
 * Interface for WeProfileProfile.
 */
interface WeProfileProfileInterface {

  /**
   * Returns all editor grades.
   *
   * @return array
   *   Editor grades keyed by their machine name.
   */
  public function allGrades();

  /**
   * Returns all editors sorted by grade.
   *
   * @return \Drupal\node\NodeInterface[]
   *   Editor node objects.
   */
  public function allEditors();

  /**
   * Returns the editors by their grade.
   *
   * @param string $grade
   *   Editor grade.
   *
   * @return \Drupal\node\NodeInterface[]
   *   Editor node objects.
   */
  public function editorsByGrade($grade);

  /**
   * Returns the editor of the entity.
   *
   * @param \Drupal\Core\Entity\ContentEntityInterface $entity
   *
   * @return \Drupal\Core\Entity\ContentEntityInterface|null Editor node.
   *   Editor node.
   */
  public function nodeEditor($entity);

}
