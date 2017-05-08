<?php

/**
 * @file
 * Collection of code snippets for exercises.
 */

use Drupal\node\NodeInterface;

/*
 * Query for data.
 */

// Query 5 recent news articles.
$query = $this->entityTypeManager->getStorage('node')->getQuery()
  ->condition('status', NodeInterface::PUBLISHED)
  ->condition('type', 'news')
  ->sort('created', 'DESC')
  ->range(0, 5);
$nids = $query->execute();

// Query 5 recent news articles that match any of the $categories (array of IDs).
$query = $this->entityTypeManager->getStorage('node')->getQuery()
  ->condition('status', NodeInterface::PUBLISHED)
  ->condition('type', 'news')
  ->condition('field_news_category', $categories, 'IN')
  ->sort('created', 'DESC')
  ->range(0, 5);
$nids = $query->execute();

// Get all editor profile nodes sorted by grade and name.
$query = $this->entityTypeManager->getStorage('node')->getQuery()
  ->condition('type', 'editor')
  ->condition('status', NodeInterface::PUBLISHED)
  ->sort('field_editor_grade', 'DESC')
  ->sort('field_user_name', 'ASC');
$nids = $query->execute();

// A condition to filter editor profiles by $grade.
$query->condition('field_editor_grade', $grade);

// Get news articles that are not yet archived after 1 year.
$threshold = strtotime('-1 year', $_SERVER['REQUEST_TIME']);
$query = $this->entityTypeManager->getStorage('node')->getQuery()
  ->condition('type', 'news')
  ->condition('field_news_archive', 0)
  ->condition('created', $threshold, '<');
$nids = $query->execute();

/*
 * Load data from storage.
 */

// Load Node objects.
$nodes = $this->entityTypeManager->getStorage('node')->loadMultiple($nids);

// Get the node object of the current page.
$node = $this->routeMatch->getParameter('node');

// Get the News category ($category) that is used by a News article ($entity).
if ($entity->hasField('field_news_category')) {
  $field = $entity->get('field_news_category');
  if (!$field->isEmpty()) {
    $category = $field->entity;
  }
}

// Get the Editor node ($editor) that is referenced by a News article ($entity).
if ($entity->hasField('field_news_editor')) {
  $field = $entity->get('field_news_editor');
  if (!$field->isEmpty()) {
    $editor = $field->entity;
  }
}

// Get all terms from the vocabulary using its ID $vocabulary_id (string).
$terms = $this->entityTypeManager
  ->getStorage('taxonomy_term')
  ->loadTree($vocabulary_id);

// Get a set of taxonomy terms using term IDs.
$terms = $this->entityTypeManager->getStorage('taxonomy_term')->loadMultiple($tids);

/*
 * Miscellaneous.
 */

// Get a list of term names keyed by the term ID.
foreach ($terms as $term) {
  $categories[$term->id()] = $term->label();
}

// Get allowed field values of field_editor_grade.
$grades = $this->entityFieldManager
  ->getFieldStorageDefinitions('node')['field_editor_grade']
  ->getSetting('allowed_values');

// Mark news articles as archived.
foreach ($nids as $nid) {
  /** @var \Drupal\node\Entity\Node $node */
  $node = $this->entityTypeManager->getStorage('node')->load($nid);
  $node->set('field_news_archive', 1);
  $node->save();
}

/*
 * Building the output.
 */

// Build a list of renderable arrays ($items) for Teaser view mode of $nodes.
foreach ($nodes as $node) {
  $items[] = $this->entityTypeManager
    ->getViewBuilder('node')
    ->view($node, 'teaser');
}

// Theme renderable arrays ($items) as an HTML list.
$build = [
  '#theme' => 'item_list',
  '#items' => $items,
  // @todo Add cache tag to invalidate when an item is added.
  '#cache' => ['max-age' => 0],
];

/*
 * Load services.
 */

// We use the procedural \Drupal::service to simplify the exercises. You are
// encouraged to use proper dependency injection to allow unit testing.

// @todo Replace this by proper dependency injection.
$newsService = \Drupal::service('we_news.news');

// @todo Replace this by proper dependency injection.
$newsCategoryService = \Drupal::service('we_news.news_category');

// @todo Replace this by proper dependency injection.
$profileService = \Drupal::service('we_profile.profile');
