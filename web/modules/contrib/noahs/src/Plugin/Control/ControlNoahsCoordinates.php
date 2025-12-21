<?php

namespace Drupal\noahs_page_builder\Plugin\Control;

/**
 * @ControlPlugin(
 *   id = "noahs_coordinates",
 *   label = @Translation("Coordinates")
 * )
 */
class ControlNoahsCoordinates extends ControlBase {

  /**
   * {@inheritdoc}
   */
  public function getype() {
    return 'noahs_coordinates';
  }

  /**
   * {@inheritdoc}
   */
  public function contentTemplate(array $params = []) {
    $data = $params['data'] ?? NULL;
    $name = $params['name'] ?? NULL;
    $value = $params['value'] ?? NULL;
    $fields = $data['item']['fields'];
    $html = '';

    $html .= '<div class="nohas-field-description">Use your property as px, em, rem, %, ...</div>';
    $html .= '<ul class="field-element-list-horizontal">';

    foreach ($fields as $key => $field) {
      $final_value = htmlspecialchars($value[$key] ?? '', ENT_QUOTES, 'UTF-8');
      $field_title = htmlspecialchars($field['title'] ?? $key, ENT_QUOTES, 'UTF-8');

      $html .= '<li>';
      $html .= '<input type="text" name="' . htmlspecialchars($name) . '[' . htmlspecialchars($key) . ']" value="' . $final_value . '" class="form-control" field-settings>';
      $html .= '<label for="noahs_page_builder_coordinate_left">' . $field_title . '</label>';
      $html .= '</li>';
    }

    $html .= '</ul>';

    return $html;
  }

  /**
   * {@inheritdoc}
   */
  public function getDefaultSettings() {
    return [
      'input_type' => 'noahs_coordinates',
      'title' => '',
    ];
  }

}
