<?php

namespace Drupal\noahs_page_builder\Plugin\Control;

/**
 * @ControlPlugin(
 *   id = "radio",
 *   label = @Translation("Radio")
 * )
 */
class ControlRadio extends ControlBase {

  /**
   * {@inheritdoc}
   */
  public function getype() {
    return 'radio';
  }

  /**
   * {@inheritdoc}
   */
  public function contentTemplate(array $params = []) {
    $data = $params['data'] ?? NULL;
    $name = $params['name'] ?? NULL;
    $value = $params['value'] ?? NULL;
    $output = '';

    $output .= '<div class="form-check form-switch">';
    $output .= '<input type="radio" id="option-' . htmlspecialchars($data['item_id'], ENT_QUOTES, 'UTF-8') . '" name="element[' . htmlspecialchars($data['item_id'], ENT_QUOTES, 'UTF-8') . ']" value="" class="form-check-input" field-settings>';
    $output .= '<label for="option-' . htmlspecialchars($data['item_id'], ENT_QUOTES, 'UTF-8') . '" class="form-check-label">' . htmlspecialchars($data['item']['title'], ENT_QUOTES, 'UTF-8') . '</label>';
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
      'input_type' => 'radio',
      'title' => '',
    ];
  }

}
