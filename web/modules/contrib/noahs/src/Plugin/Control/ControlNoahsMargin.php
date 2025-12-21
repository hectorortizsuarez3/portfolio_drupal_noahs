<?php

namespace Drupal\noahs_page_builder\Plugin\Control;

/**
 * @ControlPlugin(
 *   id = "noahs_margin",
 *   label = @Translation("Margin")
 * )
 */
class ControlNoahsMargin extends ControlBase {

  /**
   * {@inheritdoc}
   */
  public function getype() {
    return 'noahs_margin';
  }

  /**
   * {@inheritdoc}
   */
  public function contentTemplate(array $params = []) {
    $data = $params['data'] ?? NULL;
    $name = $params['name'] ?? NULL;
    $value = $params['value'] ?? NULL;
    $placeholder_left = !empty($data['item']['placeholder']['margin_left']) ? $data['item']['placeholder']['margin_left'] : NULL;
    $placeholder_top = !empty($data['item']['placeholder']['margin_top']) ? $data['item']['placeholder']['margin_top'] : NULL;
    $placeholder_right = !empty($data['item']['placeholder']['margin_right']) ? $data['item']['placeholder']['margin_right'] : NULL;
    $placeholder_bottom = !empty($data['item']['placeholder']['margin_bottom']) ? $data['item']['placeholder']['margin_bottom'] : NULL;


    $output = '';
    $output .= '<div class="nohas-field-description">Use your property as px, em, rem, %, ...</div>';
    $output .= '<ul class="field-element-list-horizontal">';
    $output .= '<li>';
    $output .= '<input type="text" name="' . $name . '[margin_left]" data-style-css="margin-left" value="' . ($value['margin_left'] ?? '') . '" placeholder="' . $placeholder_left . '" class="form-control" field-settings>';
    $output .= '<label for="noahs_page_builder_margin_left">Left</label>';
    $output .= '</li>';
    $output .= '<li>';
    $output .= '<input type="text" name="' . $name . '[margin_top]" data-style-css="margin-top" value="' . ($value['margin_top'] ?? '') . '" placeholder="' . $placeholder_top . '" class="form-control" field-settings>';
    $output .= '<label for="noahs_page_builder_margin_top">Top</label>';
    $output .= '</li>';
    $output .= '<li>';
    $output .= '<input type="text" name="' . $name . '[margin_right]" data-style-css="margin-right" value="' . ($value['margin_right'] ?? '') . '" placeholder="' . $placeholder_right . '" class="form-control" field-settings>';
    $output .= '<label for="noahs_page_builder_margin_right">Right</label>';
    $output .= '</li>';
    $output .= '<li>';
    $output .= '<input type="text" name="' . $name . '[margin_bottom]" data-style-css="margin-bottom" value="' . ($value['margin_bottom'] ?? '') . '" placeholder="' . $placeholder_bottom . '" class="form-control" field-settings>';
    $output .= '<label for="noahs_page_builder_margin_bottom">Bottom</label>';
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
  public function renderControl($data) {
    return $this->base($data, $this->contentTemplate($data));
  }

  /**
   * {@inheritdoc}
   */
  public function getDefaultSettings() {
    return [
      'input_type' => 'noahs_margin',
      'placeholder' => '',
      'title' => '',
    ];
  }

}
