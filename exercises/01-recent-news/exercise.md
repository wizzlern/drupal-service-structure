# Refactor the latest news block to use a service.

Organize business logic related to the news content type into a service to keep
your code maintainable.

- Study the code in Drupal\we_news\Plugin\Block\WeNewsRecentNews
- Copy the files included in this exercise folder to your module.
- Study the files you just copied.
- Create a service for business logic related to the News content type.
  - Create methods in the service to encapsulate business logic from the recent news block.
  - Create an interface for these methods.
- Replace the business logic in the block class by service call(s).
