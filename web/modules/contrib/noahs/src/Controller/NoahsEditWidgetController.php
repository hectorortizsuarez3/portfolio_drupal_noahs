<?php

namespace Drupal\noahs_page_builder\Controller;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Controller\ControllerBase;
use Drupal\noahs_page_builder\ModalForm;
use Drupal\noahs_page_builder\Service\WidgetServices;
use Drupal\noahs_page_builder\Service\ControlServices;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Controller routines for domain finder routes.
 */
class NoahsEditWidgetController extends ControllerBase {

  /**
   * The config factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * The widget services.
   *
   * @var \Drupal\noahs_page_builder\Service\WidgetServices
   */

  protected $widgetService;
  
  /**
   * The widget services.
   *
   * @var \Drupal\noahs_page_builder\Service\ControlServices
   */

  protected $controlService;
  
  /**
   * The widget services.
   *
   * @var \Drupal\noahs_page_builder\ModalForm
   */
  
  protected $modalForm;

  /**
   * ModalController constructor.
   *
   * @param \Drupal\noahs_page_builder\Service\WidgetServices $widget_service
   *   The widget services.
   * @param \Drupal\noahs_page_builder\Service\ControlServices $control_service
   *   The widget services.
   * @param \Drupal\noahs_page_builder\ModalForm $modal_form
   *   The model form services.
   */
  public function __construct(
    ConfigFactoryInterface $configFactorty,
    WidgetServices $widget_service,
    ControlServices $control_service,
    ModalForm $modal_form
  ) {
    $this->configFactory = $configFactory;
    $this->widgetService = $widget_service;
    $this->controlService = $control_service;
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
      $container->get('config.factory'),
      $container->get('noahs_page_builder.widget_service'),
      $container->get('noahs_page_builder.control_service'),
      $container->get('noahs_page_builder.modal_form')
    );
  }

  /**
   * Edit widget.
   *
   * @param string $nid
   *   The nid.
   * @param string $widget
   *   The widget.
   * @param string $widget_id
   *   The widget id.
   *
   * @return array
   *   The page.
   */
  public function edit($nid, $widget, $widget_id): array {



    $widgetService = $this->widgetService;
    $langcode = $this->languageManager()->getCurrentLanguage()->getId();
    $uid = $this->currentUser()->id();

    $pallete_color = [];

    $page['#attached']['drupalSettings']['noahs_page_builder']['pallete_color'] = $pallete_color;

    $fields = $widgetService->getWidgetFields($widget);

    $page['#attached']['drupalSettings']['noahs_page_builder']['field_settings'] = $settings;

    $jsonData = json_encode($settings);
    $escapedJsonData = htmlspecialchars($jsonData, ENT_QUOTES, 'UTF-8');

      $form = $this->modalForm->renderForm($fields, $settings);
    // $langcode = \Drupal::languageManager()->getCurrentLanguage()->getId();
    $output = '<form class="form-widget" id="noahs_page_builder_edit_widget_form">';
    $output .= '<input type="hidden" name="wid" value="' . $widget_id . '"/>';
    $output .= '<input type="hidden" name="did" value="' . $nid . '"/>';
    // $output .= '<input type="hidden" name="uid" value="' . \Drupal::currentUser()->id() . '"/>';
    $output .= '<input type="hidden" name="uid" value="' . $uid . '"/>';
    $output .= '<input type="hidden" name="type" value="' . $widget . '"/>';
    $output .= '<input type="hidden" name="langcode" value="' . $langcode . '"/>';
    $output .= '<div class="form-data-settings" data-settings="' . $escapedJsonData . '"></div>';

    foreach ($form as $item) {

      $output .= $item;
    }
    $output .= '<div class="btn-group-margin">
    <button type="submit" class="btn btn-success btn-labeled save-widget"><span class="btn-label"><i class="fa-regular fa-floppy-disk"></i></span>Save</button>
    <button class="btn btn-danger btn-labeled noahs_page_builder-close-modal"><span class="btn-label"><i class="fa-solid fa-xmark"></i></span>Close</button>
    </div>';
    $output .= '</form>';

    $page['#attached']['library'][] = 'noahs_page_builder/noahs_page_builder.assets.admin';

    $page['noahs_page_builder-admin-edit-widget'] = [
      '#theme' => 'noahs-admin-edit-widget',
      '#content' => $output,
    ];

    return $page;
  }

}
