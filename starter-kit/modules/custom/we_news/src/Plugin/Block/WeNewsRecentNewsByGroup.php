<?php

namespace Drupal\we_news\Plugin\Block;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Block\BlockBase;
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
      'group' => '',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {

    $config = $this->configuration;
    $options = ['popular' => 'TODO 1', 'tech' => 'TODO 2'];

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

    $build = ['#markup' => 'TODO News by category group'];

    return $build;
  }

}
