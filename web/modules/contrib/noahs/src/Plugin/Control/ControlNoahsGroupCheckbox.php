<?php

namespace Drupal\noahs_page_builder\Plugin\Control;

/**
 * @ControlPlugin(
 *   id = "noahs_group_checkbox",
 *   label = @Translation("Group checkbox")
 * )
 */
class ControlNoahsGroupCheckbox extends ControlBase {

  /**
   * {@inheritdoc}
   */
  public function getype() {
    return 'noahs_group_checkbox';
  }

  /**
   * {@inheritdoc}
   */
  public function contentTemplate(array $params = []) {
    $data = $params['data'] ?? NULL;
    $name = $params['name'] ?? NULL;
    $value = $params['value'] ?? NULL;
    $html = '';

    foreach ($data['item']['options'] as $key => $option) {
      $checked = !empty($value) && isset($value[str_replace('-', '_', $key)]) && $value[str_replace('-', '_', $key)] === $key ? 'checked' : '';

      $html .= '<div class="form-check form-switch">';
      $html .= '<input type="checkbox" id="option-' . $key . '" name="' . $name . '[' . str_replace('-', '_', $key) . ']" value="' . $key . '" class="form-check-input" ' . $checked . ' field-settings />';
      $html .= '<label for="option-' . $key . '" class="form-check-label">' . $option . '</label>';
      $html .= '</div>';
    }

    return $html;
  }

  /**
   * {@inheritdoc}
   */
  public function getDefaultSettings() {
    return [
      'input_type' => 'noahs_group_checkbox',
      'placeholder' => '',
      'title' => '',
    ];
  }

}
