<?php

namespace Drupal\noahs_page_builder\Plugin\Control;

/**
 * @ControlPlugin(
 *   id = "number",
 *   label = @Translation("Number")
 * )
 */
class ControlNumber extends ControlBase {

  /**
   * {@inheritdoc}
   */
  public function getype() {
    return 'number';
  }

  /**
   * {@inheritdoc}
   */
  public function contentTemplate(array $params = []) {
    $data = $params['data'] ?? NULL;
    $name = $params['name'] ?? NULL;
    $value = $params['value'] ?? NULL;
    $value = (empty($value) && !empty($data['item']['default_value'])) ? $data['item']['default_value'] : $value;
    $output = '';

    $class = [];
    $class[] = 'form-control';
    $attributes = '';
    if (!empty($data['item']['attributes'])) {
      $attributes = implode(' ', array_map(
      function ($key, $attribute) {

        if ($key != 'class') {
          return sprintf('%s="%s"', $key, htmlspecialchars($attribute));
        }
      },
                array_keys($data['item']['attributes']),
                $data['item']['attributes']
      ));
      $class[] = !empty($data['item']['attributes']['class']) ? $data['item']['attributes']['class'] : NULL;
    }

    $class = implode(" ", $class);
    $placeholder = !empty($data['item']['placeholder']) ? $data['item']['placeholder'] : $data['item']['title'];
    $selector = !empty($data['item']['update_selector']) ? 'data-update-selector="#widget-id-' . $data['wid'] . ' ' . $data['item']['update_selector'] . '"' : NULL;

    $output .= '<input type="number" ' . $attributes . ' name="' . $name . ':string" id="' . $data['item_id'] . '" title="' . $data['item']['title'] . '" class="' . $class . '" placeholder="' . $placeholder . '" value="' . $value . '" ' . $selector . ' field-settings/>';

    return $output;
  }

  /**
   * {@inheritdoc}
   */
  public function getDefaultSettings() {
    return [
      'input_type' => 'number',
      'placeholder' => '',
      'title' => '',
    ];
  }

}
