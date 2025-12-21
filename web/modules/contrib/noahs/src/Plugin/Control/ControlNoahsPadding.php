<?php

namespace Drupal\noahs_page_builder\Plugin\Control;

/**
 * @ControlPlugin(
 *   id = "noahs_padding",
 *   label = @Translation("Padding")
 * )
 */
class ControlNoahsPadding extends ControlBase {

  /**
   * {@inheritdoc}
   */
  public function getype() {
    return 'noahs_padding';
  }

  /**
   * {@inheritdoc}
   */
  public function contentTemplate(array $params = []) {
  $data = $params['data'] ?? NULL;
  $name = $params['name'] ?? NULL;
  $value = $params['value'] ?? NULL;
  $placeholder_left = !empty($data['item']['placeholder']['padding_left']) ? $data['item']['placeholder']['padding_left'] : NULL;
  $placeholder_top = !empty($data['item']['placeholder']['padding_top']) ? $data['item']['placeholder']['padding_top'] : NULL;
  $placeholder_right = !empty($data['item']['placeholder']['padding_right']) ? $data['item']['placeholder']['padding_right'] : NULL;
  $placeholder_bottom = !empty($data['item']['placeholder']['padding_bottom']) ? $data['item']['placeholder']['padding_bottom'] : NULL;

  $output = '';
  $output .= '<div class="nohas-field-description">Use your property as px, em, rem, %, ...</div>';
  $output .= '<ul class="field-element-list-horizontal">';
  $output .= '<li>';
  $output .= '<input type="text" name="' . $name . '[padding_left]" data-style-css="padding-left" value="' . ($value['padding_left'] ?? '') . '" placeholder="' . $placeholder_left . '" class="form-control" field-settings>';
  $output .= '<label for="noahs_page_builder_padding_left">Left</label>';
  $output .= '</li>';
  $output .= '<li>';
  $output .= '<input type="text" name="' . $name . '[padding_top]" data-style-css="padding-top" value="' . ($value['padding_top'] ?? '') . '" placeholder="' . $placeholder_top . '" class="form-control" field-settings>';
  $output .= '<label for="noahs_page_builder_padding_top">Top</label>';
  $output .= '</li>';
  $output .= '<li>';
  $output .= '<input type="text" name="' . $name . '[padding_right]" data-style-css="padding-right" value="' . ($value['padding_right'] ?? '') . '" placeholder="' . $placeholder_right . '" class="form-control" field-settings>';
  $output .= '<label for="noahs_page_builder_padding_right">Right</label>';
  $output .= '</li>';
  $output .= '<li>';
  $output .= '<input type="text" name="' . $name . '[padding_bottom]" data-style-css="padding-bottom" value="' . ($value['padding_bottom'] ?? '') . '" placeholder="' . $placeholder_bottom . '" class="form-control" field-settings>';
  $output .= '<label for="noahs_page_builder_padding_bottom">Bottom</label>';
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
      'input_type' => 'noahs_padding',
      'placeholder' => '',
      'title' => '',
    ];
  }

}
