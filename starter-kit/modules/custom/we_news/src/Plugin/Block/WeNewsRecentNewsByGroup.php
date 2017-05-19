<?php

namespace Drupal\we_news\Plugin\Block;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Block\BlockBase;
use Drupal\node\NodeInterface;
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
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityTypeManagerInterface $entity_type_manager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);

    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {

    return [
      'group' => 'popular',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {

    $config = $this->configuration;
    $options = [
      'tech' => $this->t('Tech news'),
      'popular' => $this->t('Popular news'),
    ];

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

    $group = $this->configuration['group'];
    $categories = [];

    // Get the news category term IDs of the news group.
    switch ($group) {
      case 'tech':
        // Term ID's: 3 = Internet; 4 = Science.
        $categories = [3, 4];
        break;

      case 'popular':
        // Term ID's: 1 = Sports; 2 = Showbizz; 5 = General.
        $categories = [1, 2, 5];
        break;
    }

    // Query 3 recent news articles that match any of the $categories (array of IDs).
    $query = $this->entityTypeManager->getStorage('node')->getQuery()
      ->condition('status', NodeInterface::PUBLISHED)
      ->condition('type', 'news')
      ->condition('field_news_category', $categories, 'IN')
      ->sort('created', 'DESC')
      ->range(0, 3);
    $nids = $query->execute();

    // Load Node objects.
    $nodes = $this->entityTypeManager->getStorage('node')->loadMultiple($nids);

    // Build node Teaser view mode.
    foreach ($nodes as $node) {
      $items[] = $this->entityTypeManager
        ->getViewBuilder('node')
        ->view($node, 'teaser');
    }

    // Build an HTML list for display.
    $build = [
      '#theme' => 'item_list',
      '#items' => $items,
      // @todo Add cache tag to invalidate when an item is added.
      '#cache' => ['max-age' => 0],
    ];

    return $build;
  }

}
