<?php
/**
 * Created by PhpStorm.
 * User: erikstielstra
 * Date: 30/04/2017
 * Time: 15:09
 */

namespace Drupal\extra_field\Plugin;

use Drupal\Core\Entity\Display\EntityViewDisplayInterface;
use Drupal\Core\Entity\EntityInterface;

/**
 * Provides the Extra field formatter plugin manager.
 */
interface ExtraFieldFormatterManagerInterface {

  /**
   * Exposes the ExtraFieldFormatter plugins to hook_entity_extra_field_info().
   *
   * @return array
   *   The array structure is identical to that of the return value of
   *   \Drupal\Core\Entity\EntityFieldManagerInterface::getExtraFields().
   *
   * @see hook_entity_extra_field_info()
   */
  public function fieldInfo();

  /**
   * Appends the renderable data from ExtraField plugins to hook_entity_view().
   *
   * @param &$build
   *   A renderable array representing the entity content. The module may add
   *   elements to $build prior to rendering. The structure of $build is a
   *   renderable array as expected by drupal_render().
   * @param \Drupal\Core\Entity\EntityInterface $entity
   *   The entity object.
   * @param \Drupal\Core\Entity\Display\EntityViewDisplayInterface $display
   *   The entity view display holding the display options configured for the
   *   entity components.
   * @param $view_mode
   *   The view mode the entity is rendered in.
   */
  public function entityView(array &$build, EntityInterface $entity, EntityViewDisplayInterface $display, $view_mode);

}
