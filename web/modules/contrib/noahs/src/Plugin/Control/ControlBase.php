<?php

namespace Drupal\noahs_page_builder\Plugin\Control;

use Drupal\Component\Plugin\PluginBase;
use Drupal\noahs_page_builder\Service\WidgetServices;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\noahs_page_builder\ModalForm;
use Drupal\path_alias\AliasManagerInterface;
use Drupal\Core\File\FileSystemInterface;
use Drupal\Core\File\FileUrlGeneratorInterface;

/**
 * Control base.
 */
abstract class ControlBase extends PluginBase implements ControlInterface, ContainerFactoryPluginInterface {

  /**
   * The widget service.
   *
   * @var \Drupal\noahs_page_builder\Service\WidgetServices
   */
  protected $widgetServices;

  /**
   * The modal form service.
   *
   * @var \Drupal\noahs_page_builder\ModalForm
   */
  protected $modalForm;

  /**
   * The path alias manager service.
   *
   * @var \Drupal\path_alias\AliasManagerInterface
   */
  protected $pathAliasManager;

  /**
   * The file system service.
   *
   * @var \Drupal\Core\File\FileSystemInterface
   */
  protected $fileSystem;

  /**
   * The file URL generator service.
   *
   * @var \Drupal\Core\File\FileUrlGeneratorInterface
   */
  protected $fileUrlGenerator;

  /**
   * Constructs the control plugin.
   *
   * @param array $configuration
   *   Plugin configuration.
   * @param string $plugin_id
   *   Plugin ID.
   * @param mixed $plugin_definition
   *   Plugin definition.
   * @param \Drupal\noahs_page_builder\Service\WidgetServices $widget_services
   *   The widget service.
   * @param \Drupal\noahs_page_builder\ModalForm $modal_form
   *   The widget service.
   * @param \Drupal\path_alias\AliasManagerInterface $path_alias_manager
   *   The widget service.
   * @param \Drupal\Core\File\FileSystemInterface $file_system
   *   The file system service.
   * @param \Drupal\Core\File\FileUrlGeneratorInterface $file_url_generator
   *   The file URL generator service.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    WidgetServices $widget_services,
    ModalForm $modal_form,
    AliasManagerInterface $path_alias_manager,
    FileSystemInterface $file_system,
    FileUrlGeneratorInterface $file_url_generator
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->widgetServices = $widget_services;
    $this->modalForm = $modal_form;
    $this->pathAliasManager = $path_alias_manager;
    $this->fileSystem = $file_system;
    $this->fileUrlGenerator = $file_url_generator;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('noahs_page_builder.widget_service'),
      $container->get('noahs_page_builder.modal_form'),
      $container->get('path_alias.manager'),
      $container->get('file_system'),
      $container->get('file_url_generator')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getImageStyles() {
    return $this->widgetServices->getImageStyle();
  }

}
