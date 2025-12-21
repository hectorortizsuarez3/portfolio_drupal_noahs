<?php

namespace Drupal\noahs_page_builder\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Language\LanguageManagerInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\noahs_page_builder\Service\WidgetServices;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\Core\Database\Connection;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Extension\ModuleExtensionList;
use Drupal\editor\Plugin\EditorManager;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\image\Entity\ImageStyle;
use Drupal\media\Entity\Media;
use Drupal\Core\File\FileUrlGeneratorInterface;
use Drupal\Core\Utility\Token;
use Drupal\Core\Routing\CurrentRouteMatch;

/**
 * Provides route responses for Noah's functions.
 */
class NoahsFunctionsController extends ControllerBase {

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
   * The file URL generator service.
   *
   * @var \Drupal\Core\File\FileUrlGeneratorInterface
   */
  protected $fileUrlGenerator;

  /**
   * The token service.
   *
   * @var \Drupal\Core\Utility\Token
   */
  protected $token;

  /**
   * The current route match service.
   *
   * @var \Drupal\Core\Routing\CurrentRouteMatch
   */
  protected $currentRouteMatch;

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
   * @param \Drupal\Core\File\FileUrlGeneratorInterface $file_url_generator
   *   The file url generator service.
   * @param \Drupal\Core\Utility\Token $token
   *   The token service.
   * @param \Drupal\Core\Routing\CurrentRouteMatch $current_route_match
   *   The current route matchservice.
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
  // Moved before other services.
    EntityTypeManagerInterface $entity_type_manager,
    FileUrlGeneratorInterface $file_url_generator,
    Token $token,
    CurrentRouteMatch $current_route_match
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
    $this->fileUrlGenerator = $file_url_generator;
    $this->token = $token;
    $this->currentRouteMatch = $current_route_match;
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
      $container->get('file_url_generator'),
      $container->get('token'),
      $container->get('current_route_match')
    );
  }

  /**
   * Get Media Image.
   *
   * @param string $fid
   *   The fid.
   * @param string $image_style
   *   The image style.
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   The json response.
   */
  public function getMediaImage($media_type, $fid, $image_style) {

    $background_image = NULL;

    if (!empty($fid)) {
      $media = Media::load($fid);

      if ($media && $media->bundle() === $media_type) {
        $media_field_name = 'field_media_image';
        if ($media->hasField($media_field_name) && !$media->get($media_field_name)->isEmpty()) {
          $file = $media->get($media_field_name)->entity;
          if (!empty($file) && $file != NULL && !is_null($file->getFileUri())) {
            $file_uri = $file->getFileUri();
            if ($image_style != 'original') {
              $background_image = ImageStyle::load($image_style)->buildUrl($file_uri);
            }
            else {
              $background_image = $this->fileUrlGenerator->generateString($file_uri);
            }
            // Convertir a URL relativa.
            if (!empty($background_image)) {
              $background_image = $this->fileUrlGenerator->transformRelative($background_image);
            }
          }
        }
      }
    }
    return new JsonResponse($background_image);
  }

  /**
   * Get Media Image Token.
   *
   * @param string $token
   *   The token.
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   The json response.
   */
  public function getMediaImageToken($token) {

    $rendered_token = NULL;

    $tokenService = $this->token;

    if (!empty($token)) {
      $token_value = $token;
    }

    if (!empty($token)) {

      $route_match = $this->currentRouteMatch;
      if (!empty($route_match->getParameter('entity')) && !empty($route_match->getParameter('nid'))) {
        $node = $this->entityTypeManager->getStorage($route_match->getParameter('entity'))->load($route_match->getParameter('nid'));
        $rendered_token = '';
        if (!empty($node)) {
          $rendered_token = $tokenService->replace($token_value, [
            $route_match->getParameter('entity') => $node,
          ]);
        }
        else {
          $rendered_token = $tokenService->replace($token_value);
        }
      }
      elseif (!empty($route_match->getParameter('node'))) {
        $node = $route_match->getParameter('node');
        $rendered_token = '';
        if (!empty($node)) {
          $rendered_token = $tokenService->replace($token_value, [
            $node->getEntityTypeId() => $node,
          ]);
        }
        else {
          $rendered_token = $tokenService->replace($token_value);
        }
      }
    }
    return new JsonResponse($rendered_token);
  }

}
