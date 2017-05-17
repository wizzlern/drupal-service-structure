# Create an extra field that shows related news.
A list of recently added news article that have the same category as the current page (node).

Copy PHP code from code_snippets.php to complete this exercise.

- Work with we_news_entity_extra_field_info() and we_news_node_view() at modules/custom/we_news/we_news.module
- Replace the mock output in the we_news_node_view().
- The code should do the following:
  - Determine the category of the current page node.
  - Query latest news of this category (2 items)
  - Load news nodes
  - Build node teasers
  - Format the teasers as an HTML list.
