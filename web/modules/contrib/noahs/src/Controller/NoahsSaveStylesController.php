<?php

namespace Drupal\noahs_page_builder\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\noahs_page_builder\Service\ControlServices;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Save styles controller.
 */
class NoahsSaveStylesController extends ControllerBase {


  /**
   * Load service.
   *
   * @var \Drupal\noahs_page_builder\Service\ControlServices
   */
  protected $controlService;

  /**
   * Constructor.
   *
   * @param \Drupal\noahs_page_builder\Service\ControlServices $control_service
   *   The control service used for managing styles.
   */
  public function __construct(ControlServices $control_service) {
    $this->controlService = $control_service;
  }

  /**
   * Creates an instance of the controller.
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *   The instances.
   *
   * @return static
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('noahs_page_builder.control_service')
    );
  }

}
