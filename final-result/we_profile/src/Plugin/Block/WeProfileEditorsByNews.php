<?php

namespace Drupal\we_profile\Plugin\Block;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Block\BlockBase;
use Drupal\we_profile\WeProfileProfileInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides an 'Editor of this news' block.
 *
 * @Block(
 *   id = "we_profile_editor_news",
 *   admin_label = @Translation("Editor of this news"),
 *   category = @Translation("Editors")
 * )
 */
class WeProfileEditorsByNews extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * @var \Drupal\we_profile\WeProfileProfileInterface
   */
  protected $profile;

  /**
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   * @param \Drupal\we_profile\WeProfileProfileInterface $profile
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityTypeManagerInterface $entity_type_manager, WeProfileProfileInterface $profile) {

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
      $container->get('we_profile.profile')
    );
  }

   /**
   * {@inheritdoc}
   */
  public function build() {

    $profile = $this->profile->currentPageEditor();
    $build = [];

    if ($profile) {
      $build = $this->entityTypeManager
        ->getViewBuilder('node')
        ->view($profile, 'teaser');
    }

    return $build;
  }

}
