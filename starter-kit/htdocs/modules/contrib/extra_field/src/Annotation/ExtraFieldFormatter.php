<?php

namespace Drupal\extra_field\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines a ExtraFieldFormatter item annotation object.
 *
 * @see \Drupal\extra_field\Plugin\ExtraFieldFormatterManager
 *
 * @Annotation
 */
class ExtraFieldFormatter extends Plugin {

  /**
   * The plugin ID.
   *
   * @var string
   */
  public $id;

  /**
   * The label of the plugin.
   *
   * @ingroup plugin_translatable
   *
   * @var \Drupal\Core\Annotation\Translation
   */
  public $label;

  /**
   * The entity + bundle combination(s) the plugin supports.
   *
   * Format: [entity].[bundle] for specific entity-bundle combinations or
   * [entity].* for all bundles of the entity.
   *
   * @var string[]
   */
  public $bundles = [];

  /**
   * The default weight of the field.
   *
   * @var integer
   */
  public $weight = 0;

  /**
   * Whether the field is visible by default.
   *
   * @var boolean
   */
  public $visible = FALSE;

}
