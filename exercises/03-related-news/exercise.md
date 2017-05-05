# Create a block that shows related news.
A list of recently added news article that have the same category as the current page (node).

TIP: Use code from code_snippets.php.

- Work in the block class file at: modules/custom/we_news/src/Plugin/Block/WeNewsRelatedNews.php
- Replace the mock output in the WeNewsRelatedNews::build.
- The code should contain the following:
  - Determine the category of the current page node.
  - Query latest news of this category (2 items)
  - Load news nodes
  - Build node teasers
  - Format the teasers as an HTML list.
