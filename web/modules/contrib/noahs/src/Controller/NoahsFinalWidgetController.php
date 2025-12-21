<?php

namespace Drupal\noahs_page_builder\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Controller routines for domain finder routes.
 */
class NoahsFinalWidgetController extends ControllerBase {

  /**
   * Load widget.
   *
   * @param string $nid
   *   The nid.
   * @param string $widget
   *   The widget.
   * @param string $widget_id
   *   The widget id.
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   The json response.
   */
  public function load($nid, $widget, $widget_id): JsonResponse {

    $section = [
      'type' => $widget,
    ];

    $settings = noahs_page_builder_load_widget($widget_id)->settings ? json_decode(noahs_page_builder_load_widget($widget_id)->settings, TRUE) : NULL;

    $widget = noahs_page_builder_render_element($section, $settings);

    $html_sin_tabs = preg_replace('/\t/', '', $widget);
    $output = $html_sin_tabs;

    return new JsonResponse(['html' => $output]);

  }

}
