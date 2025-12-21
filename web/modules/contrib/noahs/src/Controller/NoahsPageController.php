<?php

namespace Drupal\noahs_page_builder\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\system\SystemManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Noahs page controller.
 */
class NoahsPageController extends ControllerBase {

  /**
   * System manager.
   *
   * @var \Drupal\system\SystemManager
   */
  protected $systemManager;

  /**
   * Constructor.
   *
   * @param \Drupal\system\SystemManager $system_manager
   *   The system manager.
   */
  public function __construct(SystemManager $system_manager) {
    $this->systemManager = $system_manager;
  }

  /**
   * Create.
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *   The container.
   *
   * @return static
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('system.manager')
    );
  }

  /**
   * Admin page.
   *
   * @return array
   *   The page.
   */
  public function adminPage() {
    $blocks = $this->systemManager->getBlockContents();

    // HTML personalizado que quieres añadir, por ejemplo un encabezado o instrucciones.
    $custom_html = [
      '#type' => 'markup',
      '#markup' => '<div class="admin-header"><h2>Panel de configuración de Noah</h2><p>Desde aquí puedes acceder a las herramientas de administración del builder.</p></div>',
      '#allowed_tags' => ['div', 'h2', 'p'],
    ];

    return [
      $custom_html,
      $blocks,
    ];
  }

}
