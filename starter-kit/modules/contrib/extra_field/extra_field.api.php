<?php

/**
 * @file
 * Extra Field API documentation.
 */

/**
 * @addtogroup hooks
 * @{
 */

/**
 * Define Extra Field Formatter types.
 *
 * Extra Field API formatters allow developers to add display-only fields to
 * entities. The entities and entity bundle(s) for which the plugin is available
 * is determined with the the 'bundles' key.
 * Site builders can use extra fields as normal field on an entity display page.
 *
 * Extra Field Formatters are Plugins managed by the
 * \Drupal\extra_field\Plugin\ExtraFieldFormatterManager class. A formatter is
 * a plugin annotated with class
 * \Drupal\extra_field\Annotation\ExtraFieldFormatter that implements
 * \Drupal\extra_field\Plugin\ExtraFieldFormatterInterface (in most cases, by
 * subclassing one of the base classes). Extra Field Formatter plugins need to
 * be in the namespace \Drupal\{your_module}\Plugin\ExtraField\FieldFormatter.
 *
 * @see plugin_api
 */

/**
 * Perform alterations on Extra Field Formatters.
 *
 * @param array $info
 *   An array of information on existing Extra Field Formatters, as collected by
 *   the annotation discovery mechanism.
 */
function hook_extra_field_formatter_info_alter(array &$info) {
  // Let a plugin also be used for all taxonomy terms.
  $info['all_nodes']['bundles'][] = 'taxonomy_term.*';
}

/**
 * @} End of "addtogroup hooks".
 */
