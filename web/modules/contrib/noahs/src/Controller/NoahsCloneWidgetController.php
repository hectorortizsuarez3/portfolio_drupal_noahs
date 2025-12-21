<?php

namespace Drupal\noahs_page_builder\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\noahs_page_builder\ControlsManager;

/**
 * Controller routines for domain finder routes.
 */
class NoahsCloneWidgetController extends ControllerBase {

  /**
   * Clone widget.
   *
   * @param string $old_id
   *   The old id.
   * @param string $new_id
   *   The new id.
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   The json response.
   */
  public function clone(string $old_id, string $new_id): JsonResponse {

    $widgetService = \Drupal::service('noahs_page_builder.widget_service');
    $settings = [];
    $output = '';
    if (noahs_page_builder_load_widget($old_id)) {

      $settings = json_decode(noahs_page_builder_load_widget($old_id)->settings, TRUE);
      $tabs_class = new ControlsManager();
      $settings['wid'] = $new_id;
      $fields = $widgetService->getWidgetFields($settings['type']);

      if (!empty($settings['element']['css'])) {

        $output .= '<style type="text/css" data-widget-styles="' . $new_id . '">';
        $output .= PHP_EOL . $tabs_class->getStyles($fields, $settings['element']['css'], $new_id);
        $output .= '</style>';

      }
    }
    return new JsonResponse([
      'message' => 'CSS saved!',
      'settings' => json_encode($settings),
      'styles' => $output,
      'wid' => $new_id,
    ]);

  }

}
