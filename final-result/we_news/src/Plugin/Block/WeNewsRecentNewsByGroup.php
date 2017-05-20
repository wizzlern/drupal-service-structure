<?php

namespace Drupal\we_news\Plugin\Block;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Block\BlockBase;
use Drupal\we_news\NewsCategoryInterface;
use Drupal\we_news\NewsContentInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'News by category' block.
 *
 * @Block(
 *   id = "we_news_news_group",
 *   admin_label = @Translation("News by category group"),
 *   category = @Translation("News")
 * )
 */
class WeNewsRecentNewsByGroup extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * @var \Drupal\we_news\NewsContentInterface
   */
  protected $newsContent;

  /**
   * @var \Drupal\we_news\NewsCategoryInterface
   */
  protected $newsCategory;

  /**
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   * @param \Drupal\we_news\NewsContentInterface $news_content
   * @param \Drupal\we_news\NewsCategoryInterface $news_category
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityTypeManagerInterface $entity_type_manager, NewsContentInterface $news_content, NewsCategoryInterface $news_category) {

    parent::__construct($configuration, $plugin_id, $plugin_definition);

    $this->entityTypeManager = $entity_type_manager;
    $this->newsContent = $news_content;
    $this->newsCategory = $news_category;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {

    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_type.manager'),
      $container->get('we_news.content'),
      $container->get('we_news.category')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {

    return [
      'group' => '',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {

    $config = $this->configuration;
    $options = $this->newsCategory->getCategoryGroups();

    $form['group'] = [
      '#type' => 'radios',
      '#title' => $this->t('News category'),
      '#default_value' => $config['group'],
      '#options' => $options,
      '#description' => $this->t('The category of news to display.'),
      '#required' => TRUE,
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['group'] = $form_state->getValue('group');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {

    $items = [];
    $group = $this->configuration['group'];
    $categories = $this->newsCategory->getCategoriesByGroup($group);
    $nodes = $this->newsContent->getNewsByCategory(array_keys($categories), 2);

    foreach ($nodes as $node) {
      $items[] = $this->entityTypeManager
        ->getViewBuilder('node')
        ->view($node, 'teaser');
    }

    $build = [
      '#theme' => 'item_list',
      '#items' => $items,
      // @todo Add cache tag to invalidate when news is added.
      '#cache' => ['max-age' => 0],
    ];

    return $build;
  }

}
