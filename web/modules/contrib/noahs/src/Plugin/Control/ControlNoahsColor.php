<?php

namespace Drupal\noahs_page_builder\Plugin\Control;

/**
 * @ControlPlugin(
 *   id = "noahs_color",
 *   label = @Translation("Color")
 * )
 */
class ControlNoahsColor extends ControlBase {

  /**
   * {@inheritdoc}
   */
  public function getype() {
    return 'noahs_color';
  }

  /**
   * {@inheritdoc}
   */
  public function contentTemplate(array $params = []) {
    $data = $params['data'] ?? NULL;
    $name = $params['name'] ?? NULL;
    $value = $params['value'] ?? NULL;

    $placeholder = !empty($data['item']['placeholder']) ? $data['item']['placeholder'] : t('Enter a color');
    $output = '<div class="noahs_page_builder_field field__color">';
    $output .= '<input type="text" name="' . $name . '" id="' . $data['item_id'] . '" title="' . $data['item']['title'] . '" placeholder="' . $placeholder . '" value="' . $value . '" class="form-control-color"  field-settings/>';
    $output .= '</div>';

    return $output;
  }

  /**
   * {@inheritdoc}
   */
  public function getDefaultSettings() {
    return [
      'input_type' => 'noahs_color',
      'placeholder' => '',
      'title' => '',
    ];
  }

}
