<?php

namespace Drupal\extra_field\Plugin;

use Drupal\Component\Plugin\PluginInspectionInterface;
use Drupal\Core\Entity\Display\EntityViewDisplayInterface;
use Drupal\Core\Entity\EntityInterface;

/**
 * Defines an interface for Extra Field Formatter plugins.
 */
interface ExtraFieldFormatterInterface extends PluginInspectionInterface {

  /**
   * Builds a renderable array for the field.
   *
   * @param \Drupal\Core\Entity\EntityInterface $entity
   *   The entity object.
   * @param \Drupal\Core\Entity\Display\EntityViewDisplayInterface $display
   *   The entity view display holding the display options configured for the
   *   entity components.
   * @param $view_mode
   *   The view mode the entity is rendered in.
   *
   * @return array
   *   Renderable array.
   */
  public function view(EntityInterface $entity, EntityViewDisplayInterface $display, $view_mode);

}
