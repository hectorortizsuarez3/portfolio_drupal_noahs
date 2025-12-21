<?php

namespace Drupal\noahs_page_builder;

use Drupal\noahs_page_builder\Annotation\WidgetPlugin;
use Drupal\noahs_page_builder\Plugin\Widget\WidgetInterface;
use Drupal\Component\Plugin\Exception\PluginException;
use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;

/**
 * Manages widgets plugins.
 */
class WidgetManager extends DefaultPluginManager {

  /**
   * Default values for each widget plugin.
   *
   * @var array
   */
  protected $defaults = [
    'id' => '',
    'label' => '',
  ];

  /**
   * Constructs a new WidgetManager object.
   *
   * @param \Traversable $namespaces
   *   An object that implements \Traversable which contains the root paths
   *   keyed by the corresponding namespace to look for plugin implementations.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   Cache backend instance to use.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler.
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {
    parent::__construct('Plugin/Widget', $namespaces, $module_handler, WidgetInterface::class, WidgetPlugin::class);

    $this->alterInfo('noahs_page_builder_widget_info');
    $this->setCacheBackend($cache_backend, 'noahs_page_builder_widget_plugins');
  }

  /**
   * {@inheritdoc}
   */
  public function processDefinition(&$definition, $plugin_id) {
    parent::processDefinition($definition, $plugin_id);

    foreach (['id', 'label'] as $required_property) {
      if (empty($definition[$required_property])) {
        throw new PluginException(sprintf('The widget "%s" must define the "%s" property.', $plugin_id, $required_property));
      }
    }
  }

}
