<?php

namespace Drupal\noahs_page_builder\Plugin\Widget;

use Drupal\Component\Plugin\PluginBase;
use Drupal\Core\Url;
use Twig\Environment;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Render\RendererInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\File\FileUrlGeneratorInterface;
use Drupal\noahs_page_builder\Service\WidgetServices;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\path_alias\AliasManagerInterface;
use Drupal\Core\Utility\Token;
use Drupal\Core\Block\BlockManagerInterface;
use Drupal\Core\Controller\TitleResolverInterface;

/**
 * Base class for Widget plugins.
 */
abstract class WidgetBase extends PluginBase implements WidgetInterface, ContainerFactoryPluginInterface {
  /**
   * The Twig service for rendering templates.
   *
   * @var \Twig\Environment
   */
  protected $twig;

  /**
   * The widget service for accessing widget-related logic.
   *
   * @var \Drupal\noahs_page_builder\Service\WidgetServices
   */
  protected $widgetService;

  /**
   * The renderer service for rendering render arrays.
   *
   * @var \Drupal\Core\Render\RendererInterface
   */
  protected $renderer;

  /**
   * The current user.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;

  /**
   * The config factory service.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * The entity type manager service.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * The file URL generator service.
   *
   * @var \Drupal\Core\File\FileUrlGeneratorInterface
   */
  protected $fileUrlGenerator;

  /**
   * The route match service for getting the current route information.
   *
   * @var \Drupal\Core\Routing\RouteMatchInterface
   */
  protected $routeMatch;

  /**
   * The request stack service.
   *
   * @var \Symfony\Component\HttpFoundation\RequestStack
   */
  protected $requestStack;

  /**
   * The path alias manager service.
   *
   * @var \Drupal\path_alias\AliasManagerInterface
   */
  protected AliasManagerInterface $aliasManager;

  /**
   * Constructs a WidgetNoahsButton object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin ID for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\path_alias\AliasManagerInterface $alias_manager
   *   The path alias manager service.
   */
  /**
   * The token service.
   *
   * @var \Drupal\Core\Utility\Token
   */
  protected Token $token;

  /**
   * The block plugin manager.
   *
   * @var \Drupal\Core\Block\BlockManagerInterface
   */
  protected BlockManagerInterface $blockManager;

  /**
   * The title resolver service.
   *
   * @var Drupal\Core\Controller\TitleResolverInterface
   */
  protected TitleResolverInterface $titleResolver;

  /**
   * Constructs a new WidgetBase object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   Plugin configuration.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Twig\Environment $twig
   *   The Twig service.
   * @param \Drupal\noahs_page_builder\Service\WidgetServices $widget_service
   *   The widget service.
   * @param \Drupal\Core\Render\RendererInterface $renderer
   *   The renderer service.
   * @param \Drupal\Core\Session\AccountProxyInterface $current_user
   *   The current user.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory service.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager service.
   * @param \Drupal\Core\File\FileUrlGeneratorInterface $file_url_generator
   *   The file URL generator service.
   * @param \Drupal\Core\Routing\RouteMatchInterface $route_match
   *   The route match service.
   * @param \Symfony\Component\HttpFoundation\RequestStack $request_stack
   *   The request stack service.
   * @param \Drupal\path_alias\AliasManagerInterface $alias_manager
   *   The route match service.
   * @param \Drupal\Core\Utility\Token $token
   *   The request stack service.
   * @param \Drupal\Core\Block\BlockManagerInterface $block_manager
   *   The request stack service.
   * @param \Drupal\Core\Controller\TitleResolverInterface $title_resolver
   *   The request stack service.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    Environment $twig,
    WidgetServices $widget_service,
    RendererInterface $renderer,
    AccountProxyInterface $current_user,
    ConfigFactoryInterface $config_factory,
    EntityTypeManagerInterface $entity_type_manager,
    FileUrlGeneratorInterface $file_url_generator,
    RouteMatchInterface $route_match,
    RequestStack $request_stack,
    AliasManagerInterface $alias_manager,
    Token $token,
    BlockManagerInterface $block_manager,
    TitleResolverInterface $title_resolver
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->twig = $twig;
    $this->widgetService = $widget_service;
    $this->renderer = $renderer;
    $this->currentUser = $current_user;
    $this->configFactory = $config_factory;
    $this->entityTypeManager = $entity_type_manager;
    $this->fileUrlGenerator = $file_url_generator;
    $this->routeMatch = $route_match;
    $this->requestStack = $request_stack;
    $this->aliasManager = $alias_manager;
    $this->token = $token;
    $this->blockManager = $block_manager;
    $this->titleResolver = $title_resolver;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('twig'),
      $container->get('noahs_page_builder.widget_service'),
      $container->get('renderer'),
      $container->get('current_user'),
      $container->get('config.factory'),
      $container->get('entity_type.manager'),
      $container->get('file_url_generator'),
      $container->get('current_route_match'),
      $container->get('request_stack'),
      $container->get('path_alias.manager'),
      $container->get('token'),
      $container->get('plugin.manager.block'),
      $container->get('title_resolver')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function twig() {
    return $this->twig;
  }

  /**
   * {@inheritdoc}
   */
  public function getImageStyles() {
    $widgetServices = $this->widgetService;
    return $widgetServices->getImageStyle();
  }

  /**
   * {@inheritdoc}
   */
  public function renderForm() {
    $form = [];

    // Cada widget define su propio form inicial en buildWidgetForm()
    $form = $this->buildWidgetForm($form);

    // Alter global para todos los widgets
    \Drupal::moduleHandler()->alter('noahs_widget_form', $form, $this);

    // Alter específico por plugin_id
    \Drupal::moduleHandler()->alter("noahs_widget_form_{$this->getPluginId()}", $form, $this);

    return $form;
  }
  
  /**
   * {@inheritdoc}
   */
  public function wrapper($data, $content) {

    $widgetService = $this->widgetService;
    $config = $this->configFactory->get('noahs_page_builder.settings');

    $divider_declaration = '';

    $settings = !empty($data->settings->element) ? $data->settings->element : NULL;

    if (!empty($settings->css->desktop->default->bg_divider)) {
      $dividers = $settings->css->desktop->default->bg_divider;

      foreach ($dividers as $k => $divider) {

        if (!empty($divider->divider)) {
          if ($k === 'bottom') {
            $divider_declaration .= '<div class="noahs-divider-svg bottom">';
          }
          if ($k === 'top') {
            $divider_declaration .= '<div class="noahs-divider-svg top">';

          }
          $divider_declaration .= file_get_contents($divider->divider);
          $divider_declaration .= '</div>';
        }
      }

    }

    $element = 'div';
    $class = [
      'noahs_page_builder-widget',
      'widget-' . str_replace('_', '-', $data->type),
    ];
    $subclass = ['widget-wrapper', 'element-transition'];
    $widget_default = 'element';
    $column_size = NULL;
    $obj = new \stdClass();
    $obj->settings = new \stdClass();
    $video_data = NULL;
    $video_overlay = NULL;
    $global_class = !empty($data->settings->global) ? 'widget-global' : '';
    $tabs = "<ul class='noahs_page_builder-widget-action-tabs tab-{$data->type} $global_class'>";
    $id = !empty($data->wid) ? $data->wid : uniqid();
    $uid = $this->currentUser->id();

    $fields = $widgetService->getWidgetFields($data->type);
    $widgetData = $widgetService->getWidgetData($data->type);

    $widget_title = $widgetData['title'];

    $tabs .= "<li class='widget_type'><span>$widget_title</span></li>";
    $tabs .= "<li><div class='area_tooltip noahs_page_builder-edit-widget' title='" . t('Edit') . "' data-widget-id='$id'><i class='fa-solid fa-pen-to-square'></i></div></li>";
    $column_size = $data->column_size ?? NULL;

    if ($data->type === 'noahs_row') {
      $element = 'section';
      $widget_default = 'section';
      $tabs .= "<li><div class='noahs-add-column-section'>
      <div class='area_tooltip noahs-tool-add-section before' title='" . t('Add Section bebore') . "' data-widget-id='$id'><i class='fa-solid fa-plus'></i></div>
      <div class='noahs-tool-add-column' data-bs-toggle='tooltip' data-bs-placement='right' title='" . t('Add Column') . "' data-widget-id='$id'><i class='fa-solid fa-plus'></i></div>
      <div class='noahs-tool-add-section after 'data-bs-toggle='tooltip' data-bs-placement='bottom' title='" . t('Add Section after') . "' data-widget-id='$id'><i class='fa-solid fa-plus'></i></div>
      </div></li>";
      $tabs .= "<li><div class='area_tooltip noahs_page_builder-move-section' title='" . t('Move') . "' data-widget-id='$id'><i class='fa-solid fa-up-down-left-right'></i></div></li>";
    }
    elseif ($data->type === 'noahs_column') {
      $widget_default = 'column';
      $tabs .= "<li><div class='area_tooltip noahs_page_builder-add-element-widget' title='" . t('Add Widget') . "' data-widget-id='$id'><i class='fa-solid fa-plus'></i></div></li>";
      $tabs .= "<li><div class='area_tooltip noahs_page_builder-move-column' title='" . t('Move') . "' data-widget-id='$id'><i class='fa-solid fa-up-down-left-right'></i></div></li>";
    }
    else {
      $class[] = 'element-widget';
      $tabs .= "<li><div class='area_tooltip noahs_page_builder-move-widget' title='" . t('Move') . "' data-widget-id='$id'><i class='fa-solid fa-up-down-left-right'></i></div></li>";
    }

    $class[] = 'scrollme';

    $tabs .= "<li><div class='area_tooltip noahs_page_builder-remove-widget' title='" . t('Remove') . "' data-widget-id='$id'><i class='fa-solid fa-trash'></i></div></li>";
    $tabs .= "<li><div class='area_tooltip noahs_page_builder-up-widget' title='" . t('Up') . "' data-widget-id='$id'><i class='fa-solid fa-arrow-up'></i></div></li>";
    $tabs .= "<li><div class='area_tooltip noahs_page_builder-down-widget' title='" . t('Down') . "' data-widget-id='$id'><i class='fa-solid fa-arrow-down'></i></div></li>";
    if (empty($global_class)) {
      $tabs .= "<li><div class='area_tooltip noahs_page_builder-clone-widget' title='" . t('Clone') . "' data-widget-id='$id'><i class='fa-solid fa-clone'></i></div></li>";
    }

    $tabs .= '<li>
    <div class="dropdown">
      <div class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fa-solid fa-ellipsis-vertical"></i>
      </div>';

    $tabs .= '<ul class="dropdown-menu p-0" aria-labelledby="navbarDropdown">';

    if (empty($global_class)) {
      $tabs .= '<li class="d-block"><div class="dropdown-item d-block noahs_copy_element">' . t('Copy') . '</div></li>';
    }

    if (is_module_installed('noahs_page_builder_pro')) {
      if ($data->type != 'noahs_row' && $data->type != 'noahs_column' && empty($global_class)) {
        $tabs .= '<li class="d-block"><div class="dropdown-item d-block noahs_save_as_global">' . t('Save as Global') . '</div></li>';
        $tabs .= '<li class="d-block"><div class="dropdown-item d-block noahs_save_as_default">' . t('Save/update as Default') . '</div></li>';
        $tabs .= '<li class="d-block"><div class="dropdown-item d-block noahs_copy_style_element">' . t('Copy Styles') . '</div></li>';
        $tabs .= '<li class="d-block"><div class="dropdown-item d-block noahs_paste_style_element">' . t('Paste Styles') . '</div></li>';
      }
      if (!empty($global_class)) {
        $tabs .= '<li class="d-block"><div class="dropdown-item d-block noahs_remove_as_global">' . t('Detach as Global') . '</div></li>';
      }
      if ($data->type === 'noahs_row') {
        $tabs .= '<li class="d-block"><div class="dropdown-item d-block noahs_save_as_theme">' . t('Save as Theme') . '</div></li>';
      }
    }

    if ($data->type === 'noahs_column' || $data->type === 'noahs_row') {
      $tabs .= '<li class="d-block"><div class="dropdown-item d-block noahs_paste_element">' . t('Paste') . '</div></li>';
    }

    if ($data->type === 'noahs_row') {
      $tabs .= '<li class="d-block"><div class="dropdown-item d-block noahs_paste_section" data-type="before">' . t('Paste before') . '</div></li>';
      $tabs .= '<li class="d-block"><div class="dropdown-item d-block noahs_paste_section" data-type="after">' . t('Paste after') . '</div></li>';
    }

    if (!empty($settings->css->desktop->default->video_background->url)) {
      $video_data = 'data-vide-bg="' . $settings->css->desktop->default->video_background->url . '" data-vide-options="loop: true, muted: true, position: 0% 0%"';
      if (!empty($settings->css->desktop->default->video_background->video_background_overlay)) {
        $video_overlay .= '<div class="noahs-video-overlay"></div>';
      }
    }

    $tabs .= '</ul>';
    $tabs .= '</div>';
    $tabs .= '</li>';
    $tabs .= '</ul>';
    $widget_class = '';

    $subclass = implode(' ', $subclass);
    $route = $this->routeMatch->getRouteName();

    // Default object when add new widget.
    if (empty($data->settings->wid)) {
      $data->settings->wid = !empty($data->wid) ? $data->wid : uniqid();
      $data->settings->noahs_id = $data->noahs_id;
      $data->settings->type = $data->type;
    }

    $obj->settings->element = !empty($data->settings->element) ? $data->settings->element : [];

    $html_tabs = '';
    $data_setting = '';
    $widget_title_data = '';
    $widgetStyles = '';
    $data_global = !empty($data->settings->global) ? 'data-widget-global="true"' : NULL;

    $allowed = [];

    \Drupal::moduleHandler()->alter('noahs_widgetbase_allowed_routes', $allowed);

    if (in_array($route, $allowed)) {
      $data_setting = !empty($data->settings) ? $data->settings : $obj;
      $data_setting = ' data-settings="' . htmlspecialchars(json_encode($data_setting), ENT_QUOTES, 'UTF-8') . '"';
      $widget_title_data = ' data-widget-title="' . htmlspecialchars($widget_title, ENT_QUOTES, 'UTF-8') . '"';
      if (!empty($data->settings->element->cookie_control->text)) {
        $cookie = $data->settings->element->cookie_control->text;
        if (empty($_COOKIE[$cookie])) {
          $class[] = 'widget-with-cookie';
        }
      }
    }
    else {
      $tabs = '';
      $cookie = NULL;
      $current_request = $this->requestStack->getCurrentRequest();

      if (!empty($data->settings->element->cookie_control->text)) {
        $cookie = $data->settings->element->cookie_control->text;

        if (empty($_COOKIE[$cookie])) {
          return '';
        }
      }
      if (!empty($data->settings->element->param_controls) && !empty($data->settings->element->param_controls_value)) {

        $param = $data->settings->element->param_controls->text;
        $expected_value = $data->settings->element->param_controls_value->text;
        $query_param_value = $current_request->query->get($param);

        if ($query_param_value != $expected_value) {
          return;
        }
      }

      if (!empty($data->settings->element->param_controls_default)) {
        if ($current_request->query->has($data->settings->element->param_controls_default->text)) {

          return;
        }
      }
    }

    if ($route === 'noahs_page_builder.noahs_settings_iframe') {
      $tabs = '';
    }

    // If (!empty($data->settings->element->if_token)) {
    //   $controlService = \Drupal::service('noahs_page_builder.control_service');
    //   $inlineCSS = new NoahsSaveStylesController($controlService);
    //   $efw = !empty($data->settings) ? json_decode(json_encode($data->settings), TRUE) : json_decode(json_encode($obj), TRUE);
    //   $widgetStyles = '<style id="w_style_' . $data->wid . '">' . $inlineCSS->generateWidgetStyles($efw) . '</style>';
    // }.
    $class = implode(' ', $class);

    return '
          <' . $element . '
          class="' . $class . '"
          data-widget-type="' . $widget_default . '"
          id="widget-id-' . $id . '"
          data-widget-id="' . $id . '"
          data-widget-selector="' . 'widget-' . str_replace('_', '-', $data->type) . '"
          ' . ($column_size ? 'data-column-size="' . $column_size . '"' : '') . '
          data-type="' . $data->type . '"
          ' . $widget_title_data . '
          ' . $data_setting . '
          ' . $data_global . '
          ' . $video_data . '
          >
          ' . $tabs . '
          ' . $divider_declaration . '
          ' . $video_overlay . '
          <div class="' . $subclass . '">
                  ' . $content . '
          </div>
          </' . $element . '>
      ';
  }

  /**
   * Render Image.
   * */
  public function getMediaImage($mid, $style = NULL, $default_image = NULL, $alt = NULL, $title = NULL, $url = NULL) {
    $style = $style ?? 'original';
    $site_name = $this->configFactory->get('system.site')->get('name');
    if ($default_image) {
      $image = $default_image;
    } else {
      $image = '/' . NOAHS_PAGE_BUILDER_PATH . '/assets/img/widget-image.jpg';
    }

    $html = '';
    $current_user = $this->currentUser;
    $has_permission = $current_user->hasPermission('administer noahs_page_builder');

    if ($mid) {
      $media = $this->entityTypeManager->getStorage('media')->load($mid);
      if ($media) {
        // Aceptar ambos bundles y priorizar el preferido.
        $bundle = $media->bundle();
        $allowed_bundles = ['image', 'noahs_image'];
        $preferred = $this->resolveImageMediaBundle();
        if (!in_array($bundle, $allowed_bundles, TRUE)) {
          // No es una media de imagen compatible.
        } else {
          $media_field_name = 'field_media_image';
          if ($media->hasField($media_field_name) && !$media->get($media_field_name)->isEmpty()) {
            $file = $media->get($media_field_name)->entity;
            if ($file) {
              $file_uri = $file->getFileUri();
              $image = ($style === 'original')
                ? $this->fileUrlGenerator->generateString($file_uri)
                : $this->entityTypeManager->getStorage('image_style')->load($style)->buildUrl($file_uri);
              $alt = $media->get($media_field_name)->alt ?? $alt;
              $title = $media->get($media_field_name)->title ?? $title;
            }
          }
        }
      }
    }

    $image_render = [
      '#theme' => 'image',
      '#uri' => $image,
      '#alt' => $alt,
      '#title' => $title,
      '#attributes' => [
        'class' => ['widget-image-src', 'img-fluid'],
      ],
    ];

    if ($url) {
      $render = [
        '#markup' => '<a href="' . $url . '">' . $this->renderer->render($image_render) . '</a>',
      ];
    }
    else {
      $render = $image_render;
    }

    if ($has_permission && isset($media)) {
      $url_edit = Url::fromRoute('entity.media.edit_form', ['media' => $mid]);
      $render['#prefix'] = t('<a href="@link" class="noahs-contextual--link" title="@title" target="_blank"><i class="fas fa-edit"></i></a>', ['@link' => $url_edit->toString(), '@title' => t('Edit media')]);
    }

    $html .= $this->renderer->render($render);
    return $html;
  }

  /**
   * {@inheritdoc}
   */
  public function getEntityUrl($data) {

    $url = NULL;
    $entity_type = !empty($data->entity_type) ? $settings->entity_type : 'node';
    $entity = $this->entityTypeManager->getStorage('node')->load($entity_id);

    if ($entity) {
      $url = $entity->toUrl('canonical', ['relative' => TRUE])->toString();
    }

    return $url;
  }

  /**
   * Resolve preferred image media bundle.
   * - If both exist: use 'noahs_image'.
   * - If only 'image' exists: use 'image'.
   * - If 'image' doesn't exist: use 'noahs_image'.
   */
  protected function resolveImageMediaBundle(): string {
    $storage = $this->entityTypeManager->getStorage('media_type');
    $hasImage = (bool) $storage->load('image');
    $hasNoahs = (bool) $storage->load('noahs_image');

    if ($hasImage && $hasNoahs) {
      return 'noahs_image';
    }
    if ($hasImage && !$hasNoahs) {
      return 'image';
    }
    return 'noahs_image';
  }

  /**
   * Builds the widget form.
   *
   * @param array $form
   *   The form array.
   *
   * @return array
   *   The modified form array.
   */
  abstract protected function buildWidgetForm(array $form);
}
