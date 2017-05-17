<?php

namespace Drupal\we_profile\Plugin\Block;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Block\BlockBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides an 'Editors by grade' block.
 *
 * @Block(
 *   id = "we_profile_editor_grade",
 *   admin_label = @Translation("Editors by grade"),
 *   category = @Translation("Editors")
 * )
 */
class WeProfileEditorsByGrade extends BlockBase implements ContainerFactoryPluginInterface {

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

    return new static($configuration, $plugin_id, $plugin_definition,
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {

    return [
      'grade' => '',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {

    $config = $this->configuration;
    $options = ['1' => 'TODO 1', '2' => 'TODO 2'];

    $form['grade'] = [
      '#type' => 'select',
      '#title' => $this->t('Editor grade'),
      '#default_value' => $config['grade'],
      '#options' => $options,
      '#description' => $this->t('Editors of this grade will be displayed.'),
      '#required' => TRUE,
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['grade'] = $form_state->getValue('grade');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {

    $grade = $this->configuration['grade'];

    $build = ['#markup' => 'TODO Editors by grade'];

    return $build;
  }

}
