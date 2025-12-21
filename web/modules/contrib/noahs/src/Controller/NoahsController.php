<?php

namespace Drupal\noahs_page_builder\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\File\FileSystemInterface;
use Drupal\Core\Language\LanguageManagerInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Url;
use Drupal\editor\Entity\Editor;
use Drupal\noahs_page_builder\ControlsManager;
use Drupal\noahs_page_builder\ModalForm;
use Drupal\noahs_page_builder\Service\WidgetServices;
use Drupal\noahs_page_builder_pro\Controller\NoahsWidgetSaveAsDefaultProController;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\Database\Connection;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Extension\ModuleExtensionList;
use Drupal\editor\Plugin\EditorManager;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Access\CsrfTokenGenerator;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\Core\DependencyInjection\ClassResolverInterface;

/**
 * Provides route responses for Noah's Builder.
 */
class NoahsController extends ControllerBase {

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
   * The entity type manager service.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * The module handler service.
   *
   * @var \Drupal\Core\Extension\ModuleHandlerInterface
   */
  protected $moduleHandler;
  /**
   * The class resolver service.
   *
   * @var \Drupal\Core\DependencyInjection\ClassResolverInterface
   */
  protected $classResolver;

  /**
   * The CSRF token generator.
   *
   * @var \Drupal\Core\Csrf\CsrfTokenGenerator
   */
  protected $csrfToken;

  /**
   * The file system service.
   *
   * @var \Drupal\Core\File\FileSystemInterface
   */
  protected $fileSystem;

  /**
   * The messenger service.
   *
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;

  /**
   * The controls manager service.
   *
   * @var \Drupal\noahs_page_builder\ControlsManager
   */
  protected $controlsManager;

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
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager service.
   * @param \Drupal\Core\Access\CsrfTokenGenerator $csrf_token
   *   The csrf token service.
   * @param \Drupal\Core\File\FileSystemInterface $file_system
   *   The file system service.
   * @param \Drupal\Core\Messenger\MessengerInterface $messenger
   *   The messenger service.
   * @param \Drupal\Core\DependencyInjection\ClassResolverInterface $class_resolver
   *   The class resolver service.
   * @param \Drupal\noahs_page_builder\ControlsManager $controls_manager
   *   The control manager service.
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
    EntityTypeManagerInterface $entity_type_manager,
    CsrfTokenGenerator $csrf_token,
    FileSystemInterface $file_system,
    MessengerInterface $messenger,
    ClassResolverInterface $class_resolver,
    ControlsManager $controls_manager,
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
    $this->entityTypeManager = $entity_type_manager;
    $this->csrfToken = $csrf_token;
    $this->fileSystem = $file_system;
    $this->messenger = $messenger;
    $this->classResolver = $class_resolver;
    $this->controlsManager = $controls_manager;
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
      $container->get('entity_type.manager'),
      $container->get('csrf_token'),
      $container->get('file_system'),
      $container->get('messenger'),
      $container->get('class_resolver'),
      $container->get('noahs_page_builder.controls_manager'),
      $container->get('noahs_page_builder.modal_form'),
    );
  }

  /**
   * Editor builder.
   *
   * @param string $entity_type
   *   The entity type.
   * @param \Drupal\Core\Entity\EntityInterface $entity
   *   The entity.
   *
   * @return array
   *   The page.
   */
  public function editor($entity_type, $entity): array {

    $request = \Drupal::request();
    $host = $request->getSchemeAndHttpHost();
    $drupal_languages = $this->languageManager->getLanguages();
    $langcode = $this->languageManager->getCurrentLanguage()->getId();
    $default_languagecode = $this->languageManager->getDefaultLanguage()->getId();
    $widgets = $this->widgetService->getWidgetsList();
    $all_widgets = $this->widgetService->getAllWidgetsList();
    $globlal_widgets = [];
    $defaults_widgets = [];
    $eid = $entity->id();
    $noahs_id = $eid;
    $save_page_url = Url::fromRoute('noahs_page_builder.save_page', [], ['absolute' => TRUE])->toString();
    $data = noahs_page_builder_load($langcode, $noahs_id, $entity_type) ?? FALSE;
    $page_settings = array('page_settings' => []);

    if (!empty($data->page_settings)) {
      $page_settings = !empty($data->page_settings) ? json_decode($data->page_settings, true) : $page_settings;
    }   
    $form = $this->pageSettingsForm();

    if ($langcode === $default_languagecode) {
      $iframe_url = $host . "/noahs_edit/preview/{$entity_type}/{$eid}";
    }
    else {
      $iframe_url = $host . "/{$langcode}/noahs_edit/preview/{$entity_type}/{$eid}";
    }

    $languages = [];
    $languages['current'] = $langcode;
    foreach ($drupal_languages as $code => $item) {
      $languages['available'][$code] = $item->getName();
    }

    if (is_module_installed('noahs_page_builder_pro')) {
      $globlal_widgets = noahs_page_builder_pro_load_widgets();
      $defaults_widgets = noahs_page_builder_pro_load_defaults_widgets();
    }

    $fields = [];
    foreach ($all_widgets as $k => $el) {
      $fields[$k] = $this->widgetService->getWidgetFields($k);
    }

    $page['#attached']['drupalSettings']['noahs_items_fields'] = $fields;
    $page['#attached']['drupalSettings']['savePage'] = $save_page_url;
    $page['#attached']['drupalSettings']['entity_id'] = $noahs_id;
    $page['#attached']['drupalSettings']['noahs_id'] = $noahs_id;
    $page['#attached']['drupalSettings']['entity_type'] = $entity_type;
    $page['#attached']['drupalSettings']['uid'] = $this->currentUser->id();
    $page['#attached']['drupalSettings']['all_widgets'] = $all_widgets;
    $page['#attached']['drupalSettings']['langcode'] = $langcode;
    $page['#attached']['drupalSettings']['languages'] = $languages;
    $page['#attached']['drupalSettings']['noahs_page_fields'] = $form;

    $token = $this->csrfToken->get('');
    $page['#attached']['drupalSettings']['csrfToken'] = $token;
    $page['#attached']['library'][] = 'noahs_page_builder/noahs_page_builder.assets.preview';
    $page['#attached']['library'][] = 'noahs_page_builder/noahs_page_builder.media_library_modal';
    $page['#attached']['library'][] = 'noahs_page_builder/noahs_page_builder.media_library_form_element';

    // CKEditor Drupal settings.
    $noahs_page_builder_config = $this->config('noahs_page_builder.settings');

    if (!empty($noahs_page_builder_config->get('use_editor'))) {
      $editor = Editor::load($noahs_page_builder_config->get('use_editor'));
      $plugin = $this->editorPluginManager->createInstance($editor->getEditor());
      $settings = $plugin->getJSSettings($editor);

      $page['#attached']['library'] = array_merge($page['#attached']['library'], $plugin->getLibraries($editor));
      $page['#attached']['drupalSettings']['noahs_page_builder']['ckeditor_settings'] = $settings;
    }

    $renderForm = $this->modalForm->renderForm($form, $page_settings['page_settings'] ?? [], null, '', ['section_extras']);

    $page['noahs-admin-form'] = [
      '#theme' => 'noahs-admin-form',
      '#url' => $entity->toUrl()->toString(),
      '#content' => '',
      '#noahs_id' => $eid,
      '#entity_type' => $entity_type,
      '#langcode' => $langcode,
      '#widgets' => $widgets,
      '#globlal_widgets' => $globlal_widgets,
      '#defaults_widgets' => $defaults_widgets,
      '#render_form' => $renderForm,
      '#iframe_url' => $iframe_url,
      '#noahs_pro' => is_module_installed('noahs_page_builder_pro'),
      '#noahs_ai' => is_module_installed('noahs_ai'),
    ];

    return $page;
  }

  /**
   * Preview (iframe) builder.
   *
   * @param string $entity_type
   *   The entity type.
   * @param \Drupal\Core\Entity\EntityInterface $entity
   *   The entity.
   *
   * @return array
   *   The page.
   */
  public function preview($entity_type, $entity) {

    $eid = $entity->id();
    $classes = [];
    $data_attributes = [];
    $noahs_id = $eid;
    $langcode = $this->languageManager->getCurrentLanguage()->getId();
    $widgets = $this->widgetService->getWidgetsList();
    $data = noahs_page_builder_load($langcode, $noahs_id, $entity_type) ?? FALSE;
    $page_settings = !empty($data->page_settings) ? json_decode($data->page_settings, TRUE) : [];
    $classes[] = $this->getClasses($data, 'class');
    $data_attributes[] = $this->getClasses($data, 'attributes');
    $sections = noahs_page_builder_get_sections($data->settings);
    $getPageUrl = Url::fromRoute('noahs_page_builder.save_page', [], ['absolute' => TRUE])->toString();
    $module_url = '/' . $this->extensionList->getPath('noahs_page_builder');
    $html = noahs_page_builder_html_generated($sections);

    $page['#attached']['drupalSettings']['savePage'] = $getPageUrl;
    $page['#attached']['drupalSettings']['noahs_page_builder']['base_path'] = base_path();
    $page['#attached']['drupalSettings']['noahs_page_builder']['classes'][] = $classes;
    $page['#attached']['drupalSettings']['noahs_page_builder']['attributes'][] = $data_attributes;
    $page['#attached']['drupalSettings']['module_url'] = $module_url;
    $page['#attached']['drupalSettings']['entity_id'] = $noahs_id;
    $page['#attached']['drupalSettings']['entity_type'] = $entity_type;
    $page['#attached']['drupalSettings']['noahs_id'] = $noahs_id;
    $page['#attached']['drupalSettings']['uid'] = $this->currentUser->id();
    $page['#attached']['drupalSettings']['langcode'] = $langcode;

    $page['#attached']['library'][] = 'noahs_page_builder/noahs_page_builder.assets.admin';
    $page['#attached']['library'][] = 'noahs_page_builder/noahs_page_builder.assets.init_front';
    $page['#attached']['library'][] = 'noahs_page_builder/noahs_page_builder.assets.frontend';

    $page['noahs-admin-preview'] = [
      '#content' => '',
      '#theme' => 'noahs-admin-preview',
      '#page_settings' => $page_settings,
      '#entity_type' => $entity_type,
      '#langcode' => $langcode,
      '#widgets' => $widgets,
      '#noahs_pro' => is_module_installed('noahs_page_builder_pro'),
      '#noahs_ai' => is_module_installed('noahs_ai'),
      '#generated_html' => $html,
    ];

    return $page;
  }

  /**
   * Get Widgets ids.
   *
   * @param array $array
   *   The array.
   * @param array $ids
   *   The ids.
   *
   * @return array
   *   The ids.
   */
  protected function getAllIds(array $array, array &$ids): array {

    foreach ($array as $key => $value) {
      if ($key === 'id') {
        $entry = ['id' => $value];
        if (isset($array['type'])) {
          $entry['type'] = $array['type'];
        }
        $ids[] = $entry;
      }
      elseif (is_array($value)) {
        $this->getAllIds($value, $ids);
      }
    }
    return $ids;
  }

  /**
   * Clone Page Function.
   *
   * @param string $noahs_id
   *   The noahs id.
   * @param string $new_noahs_id
   *   The new noahs id.
   * @param string $original_langcode
   *   The original langcode.
   * @param string $new_langcode
   *   The new langcode.
   * @param string $entity_type
   *   The entity type.
   *
   * @return string
   *   The result.
   */
  public function clonePage($noahs_id, $new_noahs_id, $original_langcode, $new_langcode, $entity_type): string {

    $result = '';
    $original = $this->database->select('noahs_page_builder_page', 'd')
      ->fields('d')
      ->condition('noahs_id', $noahs_id)
      ->condition('entity_type', $entity_type)
      ->condition('langcode', $original_langcode)
      ->execute()
      ->fetchAssoc();

    if ($original != NULL) {
      if ($new_noahs_id != NULL) {
        $this->database->insert("noahs_page_builder_page")
          ->fields([
            'noahs_id' => $new_noahs_id,
            'uid' => $original['uid'],
            'entity_id' => $new_noahs_id,
            'langcode' => $new_langcode,
            'settings' => $original['settings'],
            'page_settings' => $original['page_settings'],
            'entity_type' => $entity_type,
          ])
          ->execute();
        $result = 'Página clonada correctamente';
      }
    }

    // Ruta del archivo original (en el sistema de archivos de Drupal)
    $old_css_file_name = 'noahs_' . $noahs_id . '_' . $original_langcode . '.css';
    if (file_exists('public://noahs/' . $entity_type . '/' . $old_css_file_name)) {
      $original_uri = 'public://noahs/' . $entity_type . '/' . $old_css_file_name;
      $new_css_file_name = 'noahs_' . $new_noahs_id . '_' . $new_langcode . '.css';
      $new_uri = 'public://noahs/' . $entity_type . '/' . $new_css_file_name;

      if ($this->fileSystem->copy($original_uri, $new_uri, FileSystemInterface::EXISTS_RENAME)) {

        $new_file = $this->entityTypeManager->getStorage('file')->create([
          'uri' => $new_uri,
        ]);
        $new_file->save();

        $this->messenger()->addMessage('Archivo clonado correctamente.');
      }
    }
    return $result;
  }

  /**
   * Save Page Function.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The request.
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   The json response.
   */
  public function savePage(Request $request): JsonResponse {

    $data = json_decode($request->getContent(), TRUE);
    $uid = $data['uid'] ?? $this->currentUser->id();
    $noahs_id = $data['noahs_id'];
    $entity_id = $data['entity_id'];
    $entity_type = $data['entity_type'];
    $settings = $data['settings'] ?? NULL;
    $page_settings = $data['page_settings'] ?? NULL;
    $css = $data['css'] ?? '';

    if (!empty($data['language'])) {
      $langcode = ($data['language'] === 'no_language') ? 'no_language' : $data['language'];
    }
    else {
      $langcode = $this->languageManager->getCurrentLanguage()->getId();
    }

    $builder = $this->database->select('noahs_page_builder_page', 'd')
      ->fields('d', ['noahs_id'])
      ->condition('noahs_id', $noahs_id)
      ->condition('entity_type', $entity_type)
      ->condition('langcode', $langcode)
      ->execute()
      ->fetchAssoc();

    if ($builder != NULL) {
      $this->database->update("noahs_page_builder_page")
        ->fields([
          'settings' => $settings,
          'page_settings' => $page_settings,
          'entity_type' => $entity_type,
          'modified_date' => time(),
        ])
        ->condition('noahs_id', $noahs_id)
        ->condition('langcode', $langcode)
        ->execute();

      if (is_module_installed('noahs_page_builder_pro')) {
        $revisions = $this->database->select('noahs_page_builder_revisions', 'd')
          ->fields('d', ['page_id'])
          ->condition('noahs_id', $noahs_id)
          ->condition('entity_type', $entity_type)
          ->condition('langcode', $langcode)
          ->orderBy('modified_date', 'ASC')
          ->execute()
          ->fetchAllAssoc('page_id');

        if (count($revisions) >= 8) {
          $revisions_to_delete = array_slice($revisions, 0, count($revisions) - 7);
          $ids_to_delete = array_column($revisions_to_delete, 'page_id');

          if (!empty($ids_to_delete)) {
            $this->database->delete('noahs_page_builder_revisions')
              ->condition('page_id', $ids_to_delete, 'IN')
              ->execute();
          }
        }

        $this->database->insert('noahs_page_builder_revisions')
          ->fields([
            'noahs_id' => $noahs_id,
            'uid' => $uid,
            'entity_id' => $entity_id,
            'entity_type' => $entity_type,
            'langcode' => $langcode,
            'settings' => $settings,
            'page_settings' => $page_settings,
            'modified_date' => time(),
          ])
          ->execute();
      }

    }
    else {

      $builder = $this->database->insert("noahs_page_builder_page")
        ->fields([
          'noahs_id' => $noahs_id,
          'uid' => $uid,
          'entity_id' => $entity_id,
          'entity_type' => $entity_type,
          'langcode' => $langcode,
          'settings' => $settings,
          'page_settings' => $page_settings,
          'modified_date' => time(),
        ])
        ->execute();

    }
    $css = $this->saveCss($entity_type, $entity_id, $langcode, $css);
    if (is_module_installed('noahs_page_builder_pro')) {
      $proClass = $this->classResolver->getInstanceFromDefinition(NoahsWidgetSaveAsDefaultProController::class);
      $proClass->saveDefaultWidgetCss();
    }
    return new JsonResponse(['noahs_id' => $noahs_id]);
  }

  /**
   * Save CSS.
   *
   * @param string $entity_type
   *   The entity type.
   * @param string $entity_id
   *   The entity id.
   * @param string $langcode
   *   The langcode.
   * @param string $css
   *   The css.
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   The json response.
   */
  public function saveCss($entity_type, $entity_id, $langcode, $css): JsonResponse {

    $directory = 'public://noahs/' . $entity_type;
    $this->fileSystem->prepareDirectory($directory, FileSystemInterface::CREATE_DIRECTORY | FileSystemInterface::MODIFY_PERMISSIONS | FileSystemInterface::EXISTS_REPLACE);

    // Nombre original del archivo.
    $prefix_filename = 'noahs_';
    if ($entity_type === 'noahs_settings') {
      $prefix_filename = '';

      if ($entity_id === 'noahs_general_settings') {
        $entity_id = 'general_settings';
      }
      else {
        $entity_id = 'settings';
      }
    }

    if ($langcode && $langcode != 'no_language') {
      $filename = $prefix_filename . $entity_id . '_' . $langcode . '.css';
    }
    else {
      $filename = $prefix_filename . $entity_id . '.css';
    }

    $this->fileSystem->saveData($css, $directory . '/' . $filename, FileSystemInterface::EXISTS_REPLACE);

    return new JsonResponse(['message' => 'CSS saved!', 'styles' => $css]);

  }

  /**
   * Save JS.
   *
   * @param string $js
   *   The js.
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   The json response.
   */
  public function saveJs($js) {

    $directory = 'public://noahs/js';
    $filename = 'noahs_custom.js';
    $this->fileSystem->prepareDirectory($directory, FileSystemInterface::CREATE_DIRECTORY | FileSystemInterface::MODIFY_PERMISSIONS | FileSystemInterface::EXISTS_REPLACE);
    $this->fileSystem->saveData($js, $directory . '/' . $filename, FileSystemInterface::EXISTS_REPLACE);
  }

  /**
   * Get widget form.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The request.
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   The json response.
   */
  public function getWidgetForm(Request $request): JsonResponse {

    $data = json_decode($request->getContent(), TRUE);
    $fields = $this->widgetService->getWidgetFields($data['widget_id']);
    $form = $this->modalForm->renderForm($fields, $data);
    return new JsonResponse(['html' => '<form>' . $form[0] . '</form>']);
  }

  /**
   * Get rendered widget.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The request.
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   The json response.
   */
  public function renderWidget(Request $request): JsonResponse {
    $data = json_decode($request->getContent(), TRUE);
    // Crear settings base.
    $settings = [
      "type" => $data['widget_id'],
      "wid" => uniqid(),
      "noahs_id" => $data['entity_id'],
      "settings" => [
        "element" => $data['form_data']['element'],
      ],
    ];

    $column_size = !empty($data['extra_data']['width']) ? $data['extra_data']['width'] : FALSE;

    if ($column_size === 'two_columns') {
      return new JsonResponse(['html' => $this->getDinamicColumns(['50', '50'], $data)]);
    }
    elseif ($column_size === 'three_columns') {
      return new JsonResponse(['html' => $this->getDinamicColumns(['33', '33', '33'], $data)]);
    }
    elseif ($column_size === 'four_columns') {
      return new JsonResponse(['html' => $this->getDinamicColumns(['25', '25', '25', '25'], $data)]);
    }
    elseif ($column_size === 'columns_60_40') {
      return new JsonResponse(['html' => $this->getDinamicColumns(['60', '40'], $data)]);
    }
    elseif ($column_size === 'columns_40_60') {
      return new JsonResponse(['html' => $this->getDinamicColumns(['40', '60'], $data)]);
    }
    elseif ($column_size === 'columns_70_30') {
      return new JsonResponse(['html' => $this->getDinamicColumns(['70', '30'], $data)]);
    }
    elseif ($column_size === 'columns_30_70') {
      return new JsonResponse(['html' => $this->getDinamicColumns(['30', '70'], $data)]);
    }
    else {
      // Modificar settings si es "noahs_column".
      if ($data['widget_id'] === 'noahs_column') {
        $settings['settings']['element'] = [
          "css" => [
            "desktop" => [
              "default" => ["column_width" => $column_size],
            ],
            "mobile" => [
              "default" => ["column_width" => "100%"],
            ],
          ],
        ];
      }

      // Convertir todo el array en objeto recursivamente.
      $settings = json_decode(json_encode($settings), FALSE);

      $widget = noahs_page_builder_render_element($settings, NULL);
      return new JsonResponse(['html' => $widget, 'obj' => $settings]);
    }
  }

  /**
   * Get Dinamic Columns.
   *
   * @param string $num_columns
   *   The num columns.
   * @param array $data
   *   The data.
   *
   * @return string
   *   The rendered columns.
   */
  public function getDinamicColumns($num_columns, $data): string {
    $rendered_columns = [];

      foreach ($num_columns as $width) {

      if ($data['widget_id'] === 'noahs_column') {
        $settings = [
          "type" => $data['widget_id'],
          "wid" => uniqid(),
          "noahs_id" => $data['nid'],
          "settings" => [
            "element" => [
              "css" => [
                'desktop' => ['default' => ['column_width' => $width . '%']],
                'tablet'  => ['default' => ['column_width' => '50%']],
                'mobile'  => ['default' => ['column_width' => '100%']],
              ],
            ],
          ],
        ];
      }

      $settings = json_decode(json_encode($settings), FALSE);
      $widget = noahs_page_builder_render_element($settings, NULL);
      $rendered_columns[] = $widget;
    }

    return implode('', $rendered_columns);
  }

  /**
   * Regenerate widget.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The request.
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   The json response.
   */
  public function regenerateWidget(Request $request): JsonResponse {

    $data = json_decode($request->getContent());
    $obj = new \stdClass();
    $obj->type = $data->settings->type;
    $obj->wid = $data->widget_id;
    $obj->noahs_id = $data->settings->noahs_id;
    $obj->settings = $data->settings;

    $widget = noahs_page_builder_render_element($obj, NULL);

    return new JsonResponse(['html' => $widget]);
  }

  /**
   * Get default data widget.
   *
   * @param string $type
   *   The type.
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   The json response.
   */
  public function renderDefaultTemplateWidget($type): JsonResponse {

    $widget = noahs_page_builder_render_default_template($type);

    return new JsonResponse(['html' => $widget]);
  }

  /**
   * Get Css Classes.
   *
   * @param string $data
   *   The data.
   * @param string $type
   *   The type.
   *
   * @return array
   *   The classes.
   */
  public function getClasses($data, $type): array {
    $settings = !empty($data->settings) ? json_decode($data->settings, TRUE) : [];

    $classes = [];
    if (!empty($data->page_settings)) {
      $theme_settings = json_decode($data->page_settings, TRUE);
      if (!empty($theme_settings['page_settings']['element']['class']) && $type === 'class') {
        $classes[] = $this->getPageClasses($theme_settings, $type);
      }

      if (!empty($theme_settings['page_settings']['element']['attribute']) && $type === 'attributes') {
        $classes[] = $this->getPageAttributes($theme_settings, $type);
      }

    }

    foreach ($settings as $item) {
      $classes = array_merge($classes, $this->extractClasses($item, $type));
    }

    return $classes;
  }

  /**
   * Manual get page classes.
   *
   * @param array $data
   *   The data.
   * @param array $type
   *   The type.
   *
   * @return array|null
   *   The classes.
   */
  public function getPageClasses($data, $type): ?array {
    $classes = NULL;
    $obj_class = $this->controlsManager;
    $page_settings = $data['page_settings'];
    $page_fields = $data['page_fields'];

    if (!empty($page_settings['element']['class'])) {
      $classes = $obj_class->getClasses($page_fields, $page_settings['element']['class'], $page_settings['wid']);
    }

    return $classes;
  }

  /**
   * Manual get page attributes.
   *
   * @param string $data
   *   The data.
   * @param string $type
   *   The type.
   *
   * @return string|null
   *   The attributes.
   */
  public function getPageAttributes($data, $type): ?string {
    $classes = NULL;
    $obj_class = $this->controlsManager;
    $page_settings = $data['page_settings'];
    $page_fields = $data['page_fields'];

    if (!empty($page_settings['element']['attribute'])) {
      $classes = $obj_class->getClasses($page_fields, $page_settings['element']['attribute'], $page_settings['wid']);
    }
    return $classes;
  }

  /**
   * Get Extra classes.
   *
   * @param string $item
   *   The item.
   * @param string $type
   *   The type.
   *
   * @return array
   *   The classes.
   */
  private function extractClasses($item, $type): array {
    $classes = [];
    $obj_class = $this->controlsManager;
    if (!empty($item['settings'])) {
      $widget_settings = $item['settings'];
      $fields = $this->widgetService->getWidgetFields($item['type']);

      if ($type === 'class' && !empty($widget_settings['element']['class'])) {
        $data_classes = $obj_class->getClasses($fields, $widget_settings['element']['class'], $item['wid']);
        $classes[] = $data_classes;
      }
      if ($type === 'attributes' && !empty($widget_settings['element']['attribute'])) {
        $data_attributes = $obj_class->getAttributes($fields, $widget_settings['element']['attribute'], $item['wid']);
        if ($data_attributes) {
          $classes[] = $data_attributes;
        }
      }
      if (!empty($item['columns'])) {
        foreach ($item['columns'] as $element) {
          $classes = array_merge($classes, $this->extractClasses($element, $type));
        }
      }

      if (!empty($item['elements'])) {
        foreach ($item['elements'] as $element) {
          $classes = array_merge($classes, $this->extractClasses($element, $type));
        }
      }
    }

    return $classes;
  }

  private function pageSettingsForm() {

    $form = [];
    // Section Content.
    $form['page_section_content'] = [
      'type' => 'tab',
      'title' => t('Content'),
    ];

    $form['page_width'] = [
      'type'    => 'noahs_width',
      'title'   => t('Width'),
      'style_type' => 'style',
      'style_selector' => '.noahs-theme-content-wrapper',
      'style_css' => 'max-width',
      'tab' => 'page_section_content',
      'responsive' => TRUE,
      'placeholder' => 'use as 10%, 100px, 100vw...',
      'wrapper' => FALSE,
      'open' => TRUE,
      'slide' => TRUE,
      'units' => []
    ];

    $form['page_height'] = [
      'type'    => 'text',
      'title'   => t('Height'),
      'tab' => 'page_section_content',
      'placeholder'     => t('Height'),
      'style_type' => 'style',
      'style_selector' => '.noahs-theme-content-wrapper',
      'style_css' => 'min-height',
    ];
    
    $form['page_max_height'] = [
      'type'    => 'text',
      'title'   => t('Max Height'),
      'tab' => 'page_section_content',
      'placeholder'     => t('Max Height'),
      'style_type' => 'style',
      'style_selector' => '.noahs-theme-content-wrapper',
      'style_css' => 'max-height',
    ];

    // Styles.
    $form['page_section_styles'] = [
      'type' => 'tab',
      'title' => t('Styles'),
    ];
    
    $form['bg_color'] = [
      'type'     => 'noahs_color',
      'title'    => ('Background Color'),
      'tab'     => 'page_section_styles',
      'style_type' => 'style',
      'style_css' => 'background-color',
      'style_selector' => '.noahs-theme-content-wrapper',
    ];

    $form['page_border'] = [
      'type' => 'noahs_border',
      'title' => t('Border'),
      'tab' => 'page_section_styles',
      'style_type' => 'style',
      'style_selector' => '.noahs-theme-content-wrapper',
      'style_css' => 'border',
      'responsive' => TRUE,
    ];

    $form['page_margin'] = [
      'type' => 'noahs_margin',
      'title' => t('Margin'),
      'tab' => 'page_section_styles',
      'style_type' => 'style',
      'style_selector' => '.noahs-theme-content-wrapper',
      'style_css' => 'margin',
      'default_value' => [
        'margin_left' => 'auto',
        'margin_right' => 'auto',
        'margin_top' => '0px',
        'margin_bottom' => '0px',
      ],
      'responsive' => TRUE,
    ];

    $form['page_padding'] = [
      'type' => 'noahs_padding',
      'title' => t('Padding'),
      'tab' => 'page_section_styles',
      'style_type' => 'style',
      'style_selector' => '.noahs-theme-content-wrapper',
      'style_css' => 'padding',
      'responsive' => TRUE,
    ];

    $form['page_shadows'] = [
      'type'    => 'noahs_shadows',
      'title'   => t('Image Shadow'),
      'tab' => 'page_section_styles',
      'style_type' => 'style',
      'style_selector' => '.noahs-theme-content-wrapper',
      'responsive' => TRUE,
    ];

    $form['page_radius'] = [
      'type'    => 'noahs_radius',
      'title'   => t('Border Radius'),
      'tab' => 'page_section_styles',
      'style_type' => 'style',
      'style_selector' => '.noahs-theme-content-wrapper',
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];

    $form['page_bg_image'] = [
      'type'     => 'noahs_background_image',
      'title'    => ('Background Image'),
      'tab'     => 'page_section_styles',
      'style_type' => 'style',
      'style_selector' => '.noahs-theme-content-wrapper',
      'style_hover' => TRUE,
      'responsive' => TRUE,
    ];

    $form['page_bg_gradient'] = [
      'type'     => 'noahs_background_gradient',
      'title'    => ('Background Gradient'),
      'tab'     => 'page_section_styles',
      'style_type' => 'style',
      'style_selector' => '.noahs-theme-content-wrapper',
      'responsive' => TRUE,
    ];

    return $form;
  }



}
