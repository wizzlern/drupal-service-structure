<?php

namespace Drupal\we_profile\Plugin\Block;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Block\BlockBase;
use Drupal\we_profile\weProfileContentInterface;
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
   * @var \Drupal\we_profile\weProfileContentInterface
   */
  protected $profile;

  /**
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   * @param \Drupal\we_profile\weProfileContentInterface $profile
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityTypeManagerInterface $entity_type_manager, weProfileContentInterface $profile) {

    parent::__construct($configuration, $plugin_id, $plugin_definition);

    $this->entityTypeManager = $entity_type_manager;
    $this->profile = $profile;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {

    return new static($configuration, $plugin_id, $plugin_definition,
      $container->get('entity_type.manager'),
      $container->get('we_profile.content')
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
    $options = $this->profile->allGrades();

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

    $items = [];
    $profiles = $this->profile->editorsByGrade($this->configuration['grade']);

    foreach ($profiles as $profile) {
      $items[] = $this->entityTypeManager
        ->getViewBuilder('node')
        ->view($profile, 'teaser');
    }

    $build = [
      '#theme' => 'item_list',
      '#items' => $items,
      // @todo Add cache tag to invalidate cache when editor is added.
      '#cache' => ['max-age' => 0],
    ];

    return $build;
  }

}
