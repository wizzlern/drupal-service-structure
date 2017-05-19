<?php

/**
 * @file
 * Collection of code snippets for exercises.
 */

/*
 * Load services.
 */

// We use the procedural \Drupal::service to simplify the exercises. You are
// encouraged to use dependency injection to allow unit testing.

// @todo Replace this by dependency injection.
$newsContent = \Drupal::service('we_news.content');

// @todo Replace this by dependency injection.
$newsCategory = \Drupal::service('we_news.category');

// @todo Replace this by dependency injection.
$newsArchive = \Drupal::service('we_news.archive');
