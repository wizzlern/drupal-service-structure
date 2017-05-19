# Refactor the related news blocks to use a service.

The News Category block displays a list recent news articles of news category 
groups. Each group, Popular and Tech, contains of a number of news categories 
(taxonomy terms).

Organize business logic related to News Category taxonomy terms into a service.

- Copy the files included in this exercise folder to your module. Note: Carefully merge files / directories that already exist.
- Study the files you just copied.
- Create a service for business logic related to the News Categories.
  - Create methods in the service to encapsulate business logic from the block.
  - Create an interface for these methods.
- Replace the business logic in the block class by service call(s).



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
