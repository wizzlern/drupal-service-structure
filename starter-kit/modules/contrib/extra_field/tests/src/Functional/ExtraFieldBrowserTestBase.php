<?php

namespace Drupal\Tests\extra_field\Functional;

use Drupal\Component\Render\FormattableMarkup;
use Drupal\Core\Entity\Entity\EntityViewDisplay;
use Drupal\Tests\BrowserTestBase;

/**
 * Base class for Extra Field browser tests.
 */
class ExtraFieldBrowserTestBase extends BrowserTestBase {

  /**
   * Setup the node type with view display.
   *
   * @param $contentType
   *   Name of node bundle to be generated.
   *
   * @return \Drupal\Core\Entity\EntityInterface
   */
  public function setupContentEntityDisplay($contentType) {

    $this->contentTypeName = $contentType;
    $this->createContentType(['type' => $contentType]);

    $entityDisplay = EntityViewDisplay::create(array(
      'targetEntityType' => 'node',
      'bundle' => $contentType,
      'mode' => 'default',
      'status' => TRUE,
    ));

    return $entityDisplay;
  }

  /**
   * Creates a node.
   *
   * @param $contentType
   *
   * @return \Drupal\Core\Entity\EntityInterface
   */
  public function createContent($contentType) {

    $this->createContentType(['type' => $contentType]);
    $node = \Drupal::entityTypeManager()->getStorage('node')->create([
        'type' => $contentType,
        'title' => $this->randomString(),
      ]);
    $node->save();

    return $node;
  }

  /**
   * Enables the extra field test module.
   *
   * The extra_field_test module must be enabled _after_ entity types are
   * created. Enabling it earlier will lead to a situation where
   * ExtraFieldFormatterManager::allEntityBundles caches only the first node
   * type that was created. It is expected that this situation will not occur
   * outside of tests.
   */
  public function setupEnableExtraFieldTestModule() {

    $modules = ['extra_field_test'];
    $success = $this->container->get('module_installer')->install($modules, TRUE);
    $this->assertTrue($success, new FormattableMarkup('Enabled modules: %modules', ['%modules' => implode(', ', $modules)]));
  }
}
