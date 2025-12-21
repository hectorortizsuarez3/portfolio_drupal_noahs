<?php

namespace Drupal\noahs_page_builder\Plugin\Control;

/**
 * @ControlPlugin(
 *   id = "noahs_width",
 *   label = @Translation("Width")
 * )
 */
class ControlNoahsWidth extends ControlBase {

  /**
   * {@inheritdoc}
   */
  public function getype() {
    return 'noahs_width';
  }

  /**
   * {@inheritdoc}
   */
  public function contentTemplate(array $params = []) {

    $data = $params['data'] ?? NULL;
    $name = $params['name'] ?? NULL;
    $value = $params['value'] ?? NULL;
    $id = $data['wid'];
    $placeholder = !empty($data['item']['placeholder']) ? $data['item']['placeholder'] : '';

    $output = '';
    $output .= '<input type="text" name="' . $name . '" class="form-control" value="' . $value . '" placeholder="' . $placeholder . '" data-element-settings="' . $data['item_id'] . '" field-settings>';

    return $output;
  }

  /**
   * {@inheritdoc}
   */
  public function getDefaultSettings() {
    return [
      'input_type' => 'noahs_width',
      'placeholder' => '',
      'title' => '',
    ];
  }

}
