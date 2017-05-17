<?php

namespace Drupal\extra_field_test\Plugin\ExtraField\FieldFormatter;

use Drupal\Core\Entity\Display\EntityViewDisplayInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\extra_field\Plugin\ExtraFieldFormatterBase;

/**
 * Extra field formatter for one node type.
 *
 * @ExtraFieldFormatter(
 *   id = "one_node_type_test",
 *   label = @Translation("Extra field for first node type"),
 *   bundles = {
 *     "node.first_node_type",
 *   }
 * )
 */
class OneNodeTypeTest extends ExtraFieldFormatterBase {

  /**
   * {@inheritdoc}
   */
  public function view(EntityInterface $entity, EntityViewDisplayInterface $display, $view_mode) {

    $elements = ['#markup' => 'Output from OneNodeTypeTest'];

    return $elements;
  }

}
