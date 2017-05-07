<?php

namespace Drupal\extra_field_example\Plugin\ExtraField\FieldFormatter;

use Drupal\Core\Entity\Display\EntityViewDisplayInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\extra_field\Plugin\ExtraFieldFormatterBase;

/**
 * Example Extra field formatter.
 *
 * @ExtraFieldFormatter(
 *   id = "article_only",
 *   label = @Translation("Only for articles"),
 *   bundles = {
 *     "node.article",
 *   }
 * )
 */
class ExampleArticle extends ExtraFieldFormatterBase {

  /**
   * {@inheritdoc}
   */
  public function view(EntityInterface $entity, EntityViewDisplayInterface $display, $view_mode) {

    $elements = ['#markup' => 'This is output from ExampleArticle'];

    return $elements;
  }

}
