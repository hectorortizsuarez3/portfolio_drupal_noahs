<?php

namespace Drupal\noahs_page_builder\Plugin\Control;

/**
 * @ControlPlugin(
 *   id = "noahs_select_design",
 *   label = @Translation("Select Design")
 * )
 */
class ControlNoahsSelectDesign extends ControlBase {

  /**
   * {@inheritdoc}
   */
  public function getype() {
    return 'noahs_select_design';
  }

  /**
   * {@inheritdoc}
   */
  public function contentTemplate(array $params = []) {
    $data = $params['data'] ?? NULL;
    $name = $params['name'] ?? NULL;
    $value = $params['value'] ?? NULL;
    $output = '';

    $value = (empty($value) && !empty($data['item']['default_value'])) ? $data['item']['default_value'] : $value;

    $output .= '<div class="row row-cols-2 g-2">';
    foreach ($data['item']['options'] as $key => $option) {
      $output .= '<label for="option-' . htmlspecialchars($key, ENT_QUOTES, 'UTF-8') . '" class="col">';
      $output .= '<input type="radio" id="option-' . htmlspecialchars($key, ENT_QUOTES, 'UTF-8') . '" name="' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '" value="' . htmlspecialchars($key, ENT_QUOTES, 'UTF-8') . '" class="hidden" ' . ((!empty($value) && $value === $key) ? 'checked' : '') . ' field-settings/>';
      $output .= '<div class="data-control">';
      $output .= '<div class="select-design-title">' . htmlspecialchars($option['title'], ENT_QUOTES, 'UTF-8') . '</div>';
      $output .= '<img src="' . htmlspecialchars($option['img'], ENT_QUOTES, 'UTF-8') . '" class="w-100">';
      $output .= '</div>';
      $output .= '</label>';
    }
    $output .= '</div>';

    return $output;
  }

  /**
   * {@inheritdoc}
   */
  public function getDefaultSettings() {
    return [
      'input_type' => 'noahs_select_design',
      'title' => '',
    ];
  }

}
