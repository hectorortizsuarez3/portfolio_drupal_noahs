<?php

namespace Drupal\noahs_page_builder\Plugin\Control;

/**
 * @ControlPlugin(
 *   id = "date",
 *   label = @Translation("Date")
 * )
 */
class ControlDate extends ControlBase {

  /**
   * {@inheritdoc}
   */
  public function getype() {
    return 'date';
  }

  /**
   * {@inheritdoc}
   */
  public function contentTemplate(array $params = []) {
    $data = $params['data'] ?? NULL;
    $name = $params['name'] ?? NULL;
    $value = $params['value'] ?? NULL;

    $output = '<div class="field_item">';
    $output .= '<label for="' . $data['item_id'] . '">' . $data['item']['title'] . '</label>';
    $output .= '<input type="date" name="' . $name . '" id="' . $data['item_id'] . '" title="' . $data['item']['title'] . '" class="form-control" value="' . $value . '" field-settings/>';
    $output .= '</div>';

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
      'input_type' => 'date',
      'placeholder' => '',
      'title' => '',
    ];
  }

}
