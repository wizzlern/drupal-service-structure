# Refactor the RelatedNews extra field to use a service.

Using the Extra field module, we have created a (pseudo) field that is included
in the News default view mode. It displays related news articles below the news
article body.

- Study the code in \Drupal\we_news\Plugin\ExtraField\FieldFormatter\RelatedNews
- Refactor the code in ::view() to use one or more services. Re-use existing services if possible.
