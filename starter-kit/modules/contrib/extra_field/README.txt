Extra Field module
------------------
Provides a plugin type for extra fields in content entity view.

This module allows developers to add custom fields by simply providing a plugin.
Site builders can use these fields in entity view modes as normally. Extra
fields do not store data and do not have a field widget. Extra fields typically
combine existing entity data and format it for display.

API
---
Extra fields uses hook_entity_extra_field_info() to declare fields per entity
type and bundle. Plugins can be configured (with annotation) per entity type and
per bundle.

The object of the entity being viewed is available to the extra field plugin.
The plugin returns a renderable array which is added back in to the entity view
in hook_entity_view().

Plugins
-------
Plugins of type "ExtraFieldFormatter" can be used to provide extra field
formatters. Plugin examples can be found in the extra_field_example module (see
extra_field/src/tests/modules).

ExtraFieldFormatter annotation should at least contain:
```
 * @ExtraFieldFormatter(
 *   id = "plugin_id",
 *   label = @Translation("Field name"),
 *   bundles = {
 *     "entity_type.bundle_name"
 *   }
 * )
```

To define a plugin for all bundles of a given entity type, use the '*' wildcard:
```
 *   bundles = {
 *     "entity_type.*"
 *   }
```

Other annotation options:
```
 *   weight = 10,
 *   visible = true
```

Plugin base classes
-------------------
Different bases classes are provided each containing different tools. The extra
field plugin must at least extend the ExtraFieldFormatterInterface.

ExtraFieldFormatterBase
  When using this base class, all output formatting has to take place in the
  plugin. No HTML wrappers are provided around the plugin output.
