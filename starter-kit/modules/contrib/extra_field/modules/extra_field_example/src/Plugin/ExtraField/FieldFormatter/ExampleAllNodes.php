<?php

namespace Drupal\extra_field_example\Plugin\ExtraField\FieldFormatter;

use Drupal\Core\Entity\Display\EntityViewDisplayInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\extra_field\Plugin\ExtraFieldFormatterBase;

/**
 * Example Extra field formatter.
 *
 * @ExtraFieldFormatter(
 *   id = "all_nodes",
 *   label = @Translation("For all nodes"),
 *   bundles = {
 *     "node.*"
 *   },
 *   weight = -30,
 *   visible = true
 * )
 */
class ExampleAllNodes extends ExtraFieldFormatterBase {

  /**
   * {@inheritdoc}
   */
  public function view(EntityInterface $entity, EntityViewDisplayInterface $display, $view_mode) {

    $elements = ['#markup' => 'This is output from ExampleAllNodes'];

    return $elements;
  }

}
