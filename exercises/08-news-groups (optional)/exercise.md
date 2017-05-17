*** OPTIONAL EXERCISE ***

# Create a block with news per category group.
A list of recent news articles that share a number of categories.

TIP: Use code from code_snippets.php.

- Work in the block class file at modules/custom/we_news/src/Plugin/Block/WeNewsRecentNewsByGroup.php
- Replace the mock output in the WeNewsRecentNewsByGroup::build.
- The code should contain the following:
  - Use the group name from the block configuration.
  - Determine the categories that match this group.
  - Query latest news of these categories (2 items)
  - Load news nodes
  - Build node teasers
  - Format the teasers as an HTML list.
