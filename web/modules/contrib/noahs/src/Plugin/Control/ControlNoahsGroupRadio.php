<?php

namespace Drupal\noahs_page_builder\Plugin\Control;

/**
 * @ControlPlugin(
 *   id = "noahs_group_radio",
 *   label = @Translation("Group Radio")
 * )
 */
class ControlNoahsGroupRadio extends ControlBase {

  /**
   * {@inheritdoc}
   */
  public function getype() {
    return 'noahs_group_radio';
  }

  /**
   * {@inheritdoc}
   */
  public function contentTemplate(array $params = []) {
    $data = $params['data'] ?? NULL;
    $name = $params['name'] ?? NULL;
    $value = $params['value'] ?? NULL;
    $html = '';

    $html .= '<div class="noahs_page_builder_field field__Noahs_group_radiobox">';
    $html .= '<h5>' . $data['title'] . '</h5>';
    $html .= '<ul class="field-element-list-horizontal">';

    foreach ($data['options'] as $key => $option) {
      $html .= '<li>';
      $html .= '<input type="radio" id="option-' . $key . '" name="' . $name . '" value="' . $key . '" class="form-check-input" field-settings>';
      $html .= '<label for="option-' . $key . '">' . $option . '</label>';
      $html .= '</li>';
    }

    $html .= '</ul>';
    $html .= '</div>';

    return $html;
  }

  /**
   * {@inheritdoc}
   */
  public function getDefaultSettings() {
    return [
      'input_type' => 'noahs_group_radio',
      'placeholder' => '',
      'title' => '',
    ];
  }

}
