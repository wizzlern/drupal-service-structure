# Create an Extra field that shows the editor of the news.
The teaser view of the news editor. With Extra Field module developers can create an extra (or pseudo) field for entities wtih a simple plugin class.

TIP: Use code from code_snippets.php.

- Work in the block class file at: modules/custom/we_profile/src/Plugin/ExtraField/FieldFormatter/EditorProfile.php
- Replace the mock output in the EditorProfile::view to contain:
  - The teaser view of the node editor.
