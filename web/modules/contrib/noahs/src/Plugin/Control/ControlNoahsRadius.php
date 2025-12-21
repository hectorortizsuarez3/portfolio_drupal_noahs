<?php

namespace Drupal\noahs_page_builder\Plugin\Control;

/**
 * @ControlPlugin(
 *   id = "noahs_radius",
 *   label = @Translation("Radius")
 * )
 */
class ControlNoahsRadius extends ControlBase {

  /**
   * {@inheritdoc}
   */
  public function getype() {
    return 'noahs_radius';
  }

  /**
   * {@inheritdoc}
   */
  public function contentTemplate(array $params = []) {
  $data = $params['data'] ?? NULL;
  $name = $params['name'] ?? NULL;
  $value = $params['value'] ?? NULL;
  $placeholder_top_left = !empty($data['item']['placeholder']['border_top_left_radius']) ? $data['item']['placeholder']['border_top_left_radius'] : NULL;
  $placeholder_top_right = !empty($data['item']['placeholder']['border_top_right_radius']) ? $data['item']['placeholder']['border_top_right_radius'] : NULL;
  $placeholder_bottom_right = !empty($data['item']['placeholder']['border_bottom_right_radius']) ? $data['item']['placeholder']['border_bottom_right_radius'] : NULL;
  $placeholder_bottom_left = !empty($data['item']['placeholder']['border_bottom_left_radius']) ? $data['item']['placeholder']['border_bottom_left_radius'] : NULL;

  $output = '';
  $output .= '<div class="nohas-field-description">Use your property as px, em, rem, %, ...</div>';
  $output .= '<ul class="field-element-list-horizontal">';
  $output .= '<li>';
  $output .= '<input type="text" name="' . $name . '[border_top_left_radius]" data-style-css="border-top-left-radius" value="' . ($value['border_top_left_radius'] ?? '') . '" placeholder="' . $placeholder_top_left . '" class="form-control" field-settings>';
  $output .= '<label for="noahs_page_builder_border_top_left_radius">Top Left</label>';
  $output .= '</li>';
  $output .= '<li>';
  $output .= '<input type="text" name="' . $name . '[border_top_right_radius]" data-style-css="border-top-right-radius" value="' . ($value['border_top_right_radius'] ?? '') . '" placeholder="' . $placeholder_top_right . '" class="form-control" field-settings>';
  $output .= '<label for="noahs_page_builder_border_top_right_radius">Top Right</label>';
  $output .= '</li>';
  $output .= '<li>';
  $output .= '<input type="text" name="' . $name . '[border_bottom_right_radius]" data-style-css="border-bottom-right-radius" value="' . ($value['border_bottom_right_radius'] ?? '') . '" placeholder="' . $placeholder_bottom_right . '" class="form-control" field-settings>';
  $output .= '<label for="noahs_page_builder_border_bottom_right_radius">Bottom Right</label>';
  $output .= '</li>';
  $output .= '<li>';
  $output .= '<input type="text" name="' . $name . '[border_bottom_left_radius]" data-style-css="border-bottom-left-radius" value="' . ($value['border_bottom_left_radius'] ?? '') . '" placeholder="' . $placeholder_bottom_left . '" class="form-control" field-settings>';
  $output .= '<label for="noahs_page_builder_border_bottom_left_radius">Bottom Left</label>';
  $output .= '</li>';
  $output .= '<li class="link-li">';
  $output .= '<label class="link-label">';
  $output .= '<input type="checkbox" class="link-checkbox" name="' . $name . '[input_linked]" ' . (!empty($value['input_linked']) ? 'checked' : '') . '>';
  $output .= '<span class="link-icon" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="' . t('Link values') . '"><i class="la la-link"></i></span>';
  $output .= '</label>';
  $output .= '</li>';
  $output .= '</ul>';

  return $output;
  }

  /**
   * {@inheritdoc}
   */
  public function getDefaultSettings() {
    return [
      'input_type' => 'noahs_radius',
      'placeholder' => '',
      'title' => '',
    ];
  }

}
