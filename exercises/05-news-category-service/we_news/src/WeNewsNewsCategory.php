<?php

namespace Drupal\we_news;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Routing\CurrentRouteMatch;
use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * Provides services for the News Category taxonomy terms.
 */
class WeNewsNewsCategory implements WeNewsNewsCategoryInterface {

  use StringTranslationTrait;

  /**
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * @var \Drupal\Core\Routing\CurrentRouteMatch
   */
  protected $routeMatch;

  /**
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   * @param \Drupal\Core\Routing\CurrentRouteMatch $routeMatch
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager, CurrentRouteMatch $routeMatch) {
    $this->entityTypeManager = $entity_type_manager;
    $this->routeMatch = $routeMatch;
  }

}
