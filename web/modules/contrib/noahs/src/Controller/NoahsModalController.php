<?php

namespace Drupal\noahs_page_builder\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\noahs_page_builder\ModalForm;
use Symfony\Component\HttpFoundation\Request;
use Drupal\noahs_page_builder\Service\ControlServices;
use Drupal\noahs_page_builder\Service\WidgetServices;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Modal controller.
 */
class NoahsModalController extends ControllerBase {

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
    WidgetServices $widget_service,
    ControlServices $control_service,
    ModalForm $modal_form
  ) {
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
      $container->get('noahs_page_builder.widget_service'),
      $container->get('noahs_page_builder.control_service'),
      $container->get('noahs_page_builder.modal_form')
    );
  }

  /**
   * The modal.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The request.
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   The json response.
   */
  public function modal(Request $request) {
    $data = json_decode($request->getContent(), TRUE);
    $entity_id = $data['section_id'];
    $widget_id = $data['section_id'];
    $widget = $data['widget'];
    $global = !empty($data['global']) ? $data['global'] : 0;
    $global_class = !empty($data['global']) ? 'global_widget' : '';
    $settings = json_decode($data['settings'], TRUE);
    $widget_details = $this->widgetService->loadWidgetById($widget);
    $widget_title = $widget_details->getPluginDefinition()['label']->__toString();
    $widget_title = ($global) ? t('Global Widget:') . ' ' . $widget_title : t('Edit Widget:') . ' ' . $widget_title;
    $fields = $this->widgetService->getWidgetFields($widget);

    $form = $this->modalForm->renderForm($fields, $settings);

    $output = '<div class="noahs_page_builder-modal ' . $global_class . '">';
    $output .= '<div class="noahs_page_builder-modal_container">';
    $output .= '<div class="noahs_page_builder-modal-topbar">';
    $output .= '<div class="noahs-widget-title">' . $widget_title . '</div>';
    $output .= '<a href="#" class="move-modal">
    <svg width="51px" height="51px" viewBox="0 0 51 51" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
            <g id="Group" transform="translate(0.500000, 0.500000)">
                <rect id="Rectangle-Copy" fill="#E4E4E4" x="0.5" y="0.5" width="25" height="49"></rect>
                <path d="M50,0 L50,50 L0,50 L0,0 L50,0 Z M49,1 L1,1 L1,49 L49,49 L49,25.5 L35.408,25.5 L41.7451306,29.0642122 L42.1809184,29.3093429 L41.6906571,30.1809184 L41.2548694,29.9357878 L33.2548694,25.4357878 L32.4801356,25 L33.2548694,24.5642122 L41.2548694,20.0642122 L41.6906571,19.8190816 L42.1809184,20.6906571 L41.7451306,20.9357878 L35.408,24.5 L49,24.5 L49,1 Z" id="Combined-Shape" fill="#000000" fill-rule="nonzero"></path>
            </g>
        </g>
    </svg></a>
    <button class="btn noahs_page_builder-close-modal" title="' . $this->t('Close') . '">
      <i class="las la-times"></i>
    </button>
    </div>';
    $output .= '<form class="form-widget" id="noahs_page_builder_edit_widget_form">';
    $output .= '<input type="hidden" name="wid" value="' . $widget_id . '">';
    $output .= '<input type="hidden" name="noahs_id" value="' . $entity_id . '">';
    $output .= '<input type="hidden" name="type" value="' . $widget . '">';
    $output .= '<input type="hidden" name="global" value="' . $global . '">';
    $output .= '<div class="form-wrapper">';

    foreach ($form as $item) {
      $output .= $item;
    }
    $output .= '</div>';

    // $output .= '<button class="btn btn-danger btn-labeled noahs_page_builder-close-modal"><span class="btn-label"><i class="fa-solid fa-xmark"></i></span>' . $this->t('Close') . '</button>';
    if ($global) {
      $output .= '<div class="p-3 w-100 d-flex justify-content-end shadow-lg bg-white">';
      $output .= '<button type="submit" class="btn btn-outline-success save-global-widget">' . $this->t('Save Global') . '</button>';
      $output .= '</div>';
    }

    $output .= '<div class="noahs-input--control-css"><input type="hidden" class="update_data_form" name="element[update_form_data]"></div>';
    $output .= '</form>';
    $output .= '</div>';
    $output .= '</div>';

    return new JsonResponse(['html' => $output]);

  }

}
