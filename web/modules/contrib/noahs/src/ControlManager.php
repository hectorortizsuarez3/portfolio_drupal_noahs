<?php

namespace Drupal\noahs_page_builder;

use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;

/**
 * Control manager.
 */
class ControlManager extends DefaultPluginManager {

  /**
   * Constructor.
   *
   * @param \Traversable $namespaces
   *   The namespaces.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   The cache backend.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler.
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {
    // Passing plugin details to parent class.
    parent::__construct('Plugin/Control', $namespaces, $module_handler, 'Drupal\noahs_page_builder\Plugin\Control\ControlInterface', 'Drupal\noahs_page_builder\Annotation\ControlPlugin');
  }

}
