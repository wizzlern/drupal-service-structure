# Refactor the related news blocks to use a service.

The /News by category group/ block displays a list recent news articles of news
category groups. Each group, Popular and Tech, contains of a number of news 
categories (taxonomy terms).

Organize business logic related to News Category vocabulary into a service.

- Copy the files included in this exercise folder to your module.
  Note: Carefully merge files / directories that already exist.
- Study the files you just copied.
- Which code can be moved to a service? How should these service(s) be called?
- Create a service for business logic related to the News Categories.
  - Create methods in the service to encapsulate business logic from the block.
  - Create an interface for these methods.
- Replace the business logic in the block class by service call(s).
