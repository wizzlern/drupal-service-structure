# Refactor the entity view hook to use a service.
Move business logic from we_news_node_view() into a service.

- Copy the files included in this exercise folder to your module. Note: Carefully merge files / directories that already exist.
- Study the files you just copied.
- Create a service for business logic that builds renderable news data.
  - Create method(s) in the service to encapsulate business logic from the hook.
  - Create an interface for the method(s).
- Replace the business logic in we_news_node_view by service call(s).
