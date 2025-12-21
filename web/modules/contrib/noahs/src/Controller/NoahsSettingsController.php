<?php

namespace Drupal\noahs_page_builder\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Language\LanguageManagerInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Url;
use Drupal\noahs_page_builder\ModalForm;
use Drupal\noahs_page_builder\Service\WidgetServices;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Database\Connection;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Extension\ModuleExtensionList;
use Drupal\editor\Plugin\EditorManager;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Access\CsrfTokenGenerator;

/**
 * Noahs settings controller.
 */
class NoahsSettingsController extends ControllerBase {

  /**
   * The widget services.
   *
   * @var \Drupal\noahs_page_builder\Service\WidgetServices
   */
  protected $widgetService;

  /**
   * The language manager service.
   *
   * @var \Drupal\Core\Language\LanguageManagerInterface
   */
  protected $languageManager;

  /**
   * The route match service.
   *
   * @var \Drupal\Core\Routing\RouteMatchInterface
   */
  protected $routeMatch;

  /**
   * The database connection.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $database;

  /**
   * Plugin Manager.
   *
   * @var \Drupal\editor\Plugin\EditorManager
   */
  protected $editorPluginManager;

  /**
   * The extension list module service.
   *
   * @var \Drupal\Core\Extension\ModuleExtensionList
   */
  protected $extensionList;

  /**
   * The current user service.
   *
   * @var \Drupal\Core\Session\AccountInterface
   */
  protected $currentUser;

  /**
   * The configuration factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * The configuration object for noahs_page_builder.settings.
   *
   * @var \Drupal\Core\Config\Config
   */
  protected $config;

  /**
   * The CSRF token generator.
   *
   * @var \Drupal\Core\Access\CsrfTokenGenerator
   */
  protected $csrfToken;

  /**
   * The controls model form service.
   *
   * @var \Drupal\noahs_page_builder\ModalForm
   */
  protected $modalForm;

  /**
   * NoahsController constructor.
   *
   * @param \Drupal\noahs_page_builder\Service\WidgetServices $widget_service
   *   The widget services.
   * @param \Drupal\Core\Language\LanguageManagerInterface $language_manager
   *   The language manager service.
   * @param \Drupal\Core\Routing\RouteMatchInterface $route_match
   *   The route match service.
   * @param \Drupal\Core\Database\Connection $database
   *   The database connection.
   * @param \Drupal\editor\Plugin\EditorManager $editor_plugin_manager
   *   The editor plugin manager.
   * @param \Drupal\Core\Extension\ModuleExtensionList $extension_list
   *   The extension list service.
   * @param \Drupal\Core\Session\AccountInterface $current_user
   *   The current user service.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The configuration factory.
   * @param \Drupal\Core\Access\CsrfTokenGenerator $csrf_token
   *   The csrf token service.
   * @param \Drupal\noahs_page_builder\ModalForm $modal_form
   *   The control manager service.
   */
  public function __construct(
    WidgetServices $widget_service,
    LanguageManagerInterface $language_manager,
    RouteMatchInterface $route_match,
    Connection $database,
    EditorManager $editor_plugin_manager,
    ModuleExtensionList $extension_list,
    AccountInterface $current_user,
    ConfigFactoryInterface $config_factory,
    CsrfTokenGenerator $csrf_token,
    ModalForm $modal_form
  ) {
    $this->widgetService = $widget_service;
    $this->languageManager = $language_manager;
    $this->routeMatch = $route_match;
    $this->database = $database;
    $this->editorPluginManager = $editor_plugin_manager;
    $this->extensionList = $extension_list;
    $this->currentUser = $current_user;
    $this->configFactory = $config_factory;
    $this->config = $this->configFactory->get('noahs_page_builder.settings');
    $this->csrfToken = $csrf_token;
    $this->modalForm = $modal_form;
  }

  /**
   * Creates an instance of the controller.
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *   The service container.
   *
   * @return static
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('noahs_page_builder.widget_service'),
      $container->get('language_manager'),
      $container->get('current_route_match'),
      $container->get('database'),
      $container->get('plugin.manager.editor'),
      $container->get('extension.list.module'),
      $container->get('current_user'),
      $container->get('config.factory'),
      $container->get('csrf_token'),
      $container->get('noahs_page_builder.modal_form'),
    );
  }

  /**
   * Editor builder.
   *
   * @return array
   *   The page.
   */
  public function editor(): array {

    $widget = 'noahs_settings';
    $fields = [
      'noahs_settings' => $this->widgetService->getWidgetFields($widget),
    ];

    $data = noahs_page_builder_load('no_language', 'noahs_settings', 'noahs_settings');
    $save_page_url = Url::fromRoute('noahs_page_builder.save_page', [], ['absolute' => TRUE])->toString();
    $iframe_url = Url::fromRoute('noahs_page_builder.noahs_settings_iframe', [], ['absolute' => TRUE])->toString();

    $page['#attached']['library'][] = 'noahs_page_builder/noahs_page_builder.assets.preview';
    $page['#attached']['drupalSettings']['uid'] = $this->currentUser->id();
    $token = $this->csrfToken->get('');
    $page['#attached']['drupalSettings']['csrfToken'] = $token;

    if (empty($data->settings)) {
      $default_settings = '{"wid":"no_id","noahs_id":"noahs_settings","type":"noahs_settings","element":{"css":{"desktop":{"default":{"font_h1":{"font_size":"60px"},"font_h2":{"font_size":"50px"},"font_h3":{"font_size":"40px"},"font_h4":{"font_size":"30px"}}},"tablet":{"default":{"font_h1":{"font_size":"50px"},"font_h2":{"font_size":"40px"},"font_h3":{"font_size":"35px"},"font_h4":{"font_size":"25px"}}},"mobile":{"default":{"font_h1":{"font_size":"40px"},"font_h2":{"font_size":"35px"},"font_h3":{"font_size":"30px"},"font_h4":{"font_size":"22px"},"body":{"color":"#4a4a4a"}}}},"button_style":"default","attribute":{"parallax_when":"view"}}}';
      $form_settings = json_decode($default_settings, TRUE);
    }
    else {
      $form_settings = json_decode($data->settings, TRUE);
    }

    $widget_details = $this->widgetService->loadWidgetById($widget);

    $form = $this->modalForm->renderForm($fields[$widget], $form_settings);

    $output = '<div class="noahs_page_builder-modal noahs-settings">';
    $output .= '<div class="noahs_page_builder-modal_container">';
    $output .= '<div class="noahs-widget-title">';
    $output .= t('Edit') . ': ' . $widget_details->getPluginDefinition()['label']->__toString();
    $output .= '</div>';
    $output .= '<form class="form-widget" id="noahs_settings_form">';
    $output .= '<input type="hidden" name="wid" value="no_id">';
    $output .= '<input type="hidden" name="noahs_id" value="noahs_settings">';
    $output .= '<input type="hidden" name="type" value="' . $widget . '">';
    $output .= '<div class="form-wrapper">';

    foreach ($form as $item) {
      $output .= $item;
    }
    $output .= '</div>';
    $output .= '<div class="w-100 d-flex justify-content-between noahs-settings-styles-actions">';
    $output .= '<a class="btn btn-outline-dark btn-sm btn-admin me-4" href="/admin/structure/noahs" target="_blank">' . $this->t('Noahs page') . '</a>';
    $output .= '<a class="btn btn-outline-dark btn-sm btn-admin me-auto" href="/" target="_blank">' . $this->t('Home page') . '</a>';
    $output .= '<button type="submit" class="btn btn-success btn-sm save-widget btn-admin px-4"></span>' . $this->t('Save') . '</button>';
    $output .= '</div>';
    $output .= '</form>';
    $output .= '</div>';
    $output .= '</div>';

    $page['#attached']['drupalSettings']['noahs_items_fields'] = $fields;
    $page['#attached']['drupalSettings']['savePage'] = $save_page_url;
    $page['noahs-settings-form'] = [
      '#theme' => 'noahs-settings-form',
      '#content' => $output,
      '#iframe_url' => $iframe_url,
    ];

    return $page;
  }

  /**
   * Editor iframe.
   *
   * @return array
   *   The page.
   */
  public function iframe(): array {

    $widget = 'noahs_settings';
    $fields = [
      'noahs_settings' => $this->widgetService->getWidgetFields($widget),
    ];

    $default_settings = '{
      "wid":"no_id",
      "type":"noahs_settings",
      "noahs_id":"",
      "widget_type":"element",
      "settings":{
        "element": [],
        "wid": "no_id",
        "noahs_id": null,
        "type": "noahs_settings"
      }
    }';

    $data = noahs_page_builder_load('no_language', 'noahs_settings', $widget);

    if (empty($data->settings)) {
      $data = json_decode($default_settings);
    }
    else {
      $data->wid = 'no_id';
      $data->type = $widget;
      $data->settings = json_decode($data->settings);
    }

    $widget_details = $this->widgetService->loadWidgetById($widget);
    $render_widget = $widget_details->renderContent($data);

    $page['#attached']['library'][] = 'noahs_page_builder/noahs_page_builder.assets.admin';
    $page['#attached']['library'][] = 'noahs_page_builder/noahs_page_builder.assets.init_front';
    $page['#attached']['library'][] = 'noahs_page_builder/noahs_page_builder.assets.frontend';
    $page['noahs-settings-iframe'] = [
      '#theme' => 'noahs-settings-iframe',
      '#widget' => $render_widget,
    ];

    return $page;
  }

}
