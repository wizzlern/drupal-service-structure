# Create a cron job that archives old news articles.
Flag news articles (field_news_archive) that are created more than one year ago.

TIP: Use code from code_snippets.php.

- Work with we_news_cron() at modules/custom/we_news/we_news.module
- The cron code should do the following:
  - Determine the threshold timestamp.
  - Query news that is older than 1 year and not yet archived.
  - Load news nodes
  - Set the field_news_archive flag and save the node.
