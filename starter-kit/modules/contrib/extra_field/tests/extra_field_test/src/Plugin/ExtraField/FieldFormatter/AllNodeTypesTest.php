<?php

namespace Drupal\extra_field_test\Plugin\ExtraField\FieldFormatter;

use Drupal\Core\Entity\Display\EntityViewDisplayInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\extra_field\Plugin\ExtraFieldFormatterBase;

/**
 * Extra field formatter for all node types.
 *
 * @ExtraFieldFormatter(
 *   id = "all_node_types_test",
 *   label = @Translation("Extra field for all node types"),
 *   bundles = {
 *     "node.*",
 *   },
 *   weight = 7,
 *   visible = true
 * )
 */
class AllNodeTypesTest extends ExtraFieldFormatterBase {

  /**
   * {@inheritdoc}
   */
  public function view(EntityInterface $entity, EntityViewDisplayInterface $display, $view_mode) {

    $elements = ['#markup' => 'Output from AllNodeTypesTest'];

    return $elements;
  }

}
