<?php

namespace Drupal\noahs_page_builder\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\Entity\EntityTypeManagerInterface;

/**
 * Provides a service for managing widget and control plugins.
 */
class WidgetServices {

  /**
   * The widget plugin manager.
   *
   * @var \Drupal\Core\Plugin\DefaultPluginManager
   */
  protected $widgetManager;

  /**
   * The control plugin manager.
   *
   * @var \Drupal\Core\Plugin\DefaultPluginManager
   */
  protected $controlManager;

  /**
   * The entity type manager service.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a new WidgetServices object.
   *
   * @param \Drupal\Core\Plugin\DefaultPluginManager $widget_manager
   *   The widget plugin manager service.
   * @param \Drupal\Core\Plugin\DefaultPluginManager $control_manager
   *   The control plugin manager service.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager service.
   */
  public function __construct(DefaultPluginManager $widget_manager, $control_manager, EntityTypeManagerInterface $entity_type_manager) {
    $this->widgetManager = $widget_manager;
    $this->controlManager = $control_manager;
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * Creates a new instance of the service.
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *   The service container.
   *
   * @return static
   *   A new instance of the WidgetServices service.
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('plugin.manager.widget'),
      $container->get('plugin.manager.control'),
      $container->get('entity_type.manager')
    );
  }

  /**
   * Get all widget list.
   */
  public function getAllWidgetsList() {
    $data = [];
    $widgets = [];

    foreach ($this->widgetManager->getDefinitions() as $plugin_id => $plugin_definition) {
      $widget = $this->widgetManager->createInstance($plugin_id);
      $widget_data = $widget->data();
      $data[$plugin_id] = $widget->data();
    }

    return $data;
  }

  /**
   * Get widget list.
   *
   * @return array
   *   The widgets list.
   */
  public function getWidgetsList(): array {
    $data = [];
    $widgets = [];

    foreach ($this->widgetManager->getDefinitions() as $plugin_id => $plugin_definition) {
      $widget = $this->widgetManager->createInstance($plugin_id);
      $widget_data = $widget->data();
      if ($plugin_id !== 'noahs_column' && $plugin_id !== 'noahs_settings') {
        $data[$plugin_id] = $widget->data();
      }
    }

    $groupedArray = [];

    foreach ($data as $key => $value) {
      $group = $value['group'] ?? 'default';
      $groupedArray[$group][$key] = $value;
    }

    // Orden personalizado de grupos: primary, secondary, luego el resto
    $orderedGroups = [];
    $customOrder = ['primary', 'secondary'];
    foreach ($customOrder as $groupName) {
      if (isset($groupedArray[$groupName])) {
        // Traducción del nombre del grupo, convertido a string
        if ($groupName === 'primary') {
          $translated = (string) t('Most used');
        } elseif ($groupName === 'secondary') {
          $translated = (string) t('Second most used');
        } else {
          $translated = $groupName;
        }
        $orderedGroups[$translated] = $groupedArray[$groupName];
        unset($groupedArray[$groupName]);
      }
    }
    // Añadir el resto de grupos (ordenados alfabéticamente)
    if (!empty($groupedArray)) {
      ksort($groupedArray);
      foreach ($groupedArray as $groupName => $widgets) {
        $orderedGroups[$groupName] = $widgets;
      }
    }

    // Ordenar los widgets por título dentro de cada grupo
    foreach ($orderedGroups as &$group) {
      uasort($group, function ($a, $b) {
        return strcmp($a['title'] ?? '', $b['title'] ?? '');
      });
    }
    unset($group); // Romper la referencia

    return $orderedGroups;
  }

  /**
   * Get widget.
   *
   * @param string $widget_id
   *   The widget id.
   *
   * @return \Drupal\Core\Plugin\DefaultPluginManager
   *   The widget.
   */
  public function loadWidgetById($widget_id): ?object {
    if ($this->widgetManager->hasDefinition($widget_id)) {
      $widget = $this->widgetManager->createInstance($widget_id);
      return $widget;
    }

    return NULL;
  }

  /**
   * Get widgets fields.
   */
  public function getWidgetFields($widgetId) {
    $el_fields = [];

    $default_fields = $this->controlManager->defaultFields();

    $widget = $this->loadWidgetById($widgetId);
    if ($widget) {
      // Aquí está la llamada correcta
      $el_fields = $widget->renderForm();

      $el_fields = array_merge($el_fields, $default_fields);

      return $el_fields;
    }
  }


  /**
   * Get widgets data.
   */
  public function getWidgetData($widgetId) {
    if ($this->widgetManager->hasDefinition($widgetId)) {
      $widget = $this->widgetManager->createInstance($widgetId);
      return $widget->data();
    }
  }

  /**
   * Custom Image Style.
   *
   * @return array
   *   The image styles.
   */
  public function getImageStyle(): array {
    $miObjeto = ['original' => 'Original'];
    $image_styles = $this->entityTypeManager->getStorage('image_style')->loadMultiple();
    $array_image_styles = [];

    foreach ($image_styles as $k => $style) {
      $array_image_styles[$k] = $style->getName();
    }
    return $miObjeto + $array_image_styles;
  }

}
