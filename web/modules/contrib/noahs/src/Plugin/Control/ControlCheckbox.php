<?php

namespace Drupal\noahs_page_builder\Plugin\Control;

/**
 * @ControlPlugin(
 *   id = "checkbox",
 *   label = @Translation("Checkbox")
 * )
 */
class ControlCheckbox extends ControlBase {

  /**
   * {@inheritdoc}
   */
  public function getype() {
    return 'checkbox';
  }

  /**
   * Content template.
   *
   * @param array $params
   *   The params.
   *
   * @return string
   *   The content template.
   */
  public function contentTemplate(array $params = []): string {

    $data = $params['data'] ?? NULL;
    $name = $params['name'] ?? NULL;
    $value = $params['value'] ?? NULL;
    $attributes = '';
    $class = 'form-check-input';
    $extra_class = [];
    $data_value = $data['item']['value'];

    $selector = !empty($data['item']['update_selector']) ? 'data-update-selector="#widget-id-' . $data['wid'] . ' ' . $data['item']['update_selector'] . '"' : NULL;

    if (isset($data['delta']) && strpos($selector, '[index]') !== FALSE) {
      $selector = str_replace('[index]', $data['delta'], $selector);
    }

    if (!empty($data['item']['attributes'])) {
      $attributes = implode(' ', array_map(
      function ($key, $value) {
        return sprintf('%s="%s"', $key, htmlspecialchars($value));
      },
        array_keys($data['item']['attributes']),
        $data['item']['attributes']
      ));

      if (!empty($data['item']['attributes']['class'])) {
        $extra_class = $data['item']['attributes']['class'];
      }

    }

    $class = $class . ' ' . implode(' ', (array) $extra_class);

    $checked = ($value == $data_value) ? 'checked' : '';
    $selectorAttr = $selector ?? '';

    $html = '<div class="form-check form-switch">';
    $html .= '<input type="checkbox" ';
    $html .= 'id="option-' . $data['item_id'] . '" ';
    $html .= 'name="' . htmlspecialchars($name) . '" ';
    $html .= 'value="' . htmlspecialchars($data_value) . '" ';

    $html .= $checked . ' ';
    $html .= 'class="' . $class . '" ';
    $html .= $selectorAttr . ' ';
    $html .= 'field-settings>';
    $html .= '<label for="option-' . $data['item_id'] . '" class="form-check-label">';
    $html .= htmlspecialchars($data['item']['title']);
    $html .= '</label></div>';

    return $html;
  }

  /**
   * Render control.
   *
   * @param array $data
   *   The data.
   *
   * @return string
   *   The render control.
   */
  public function renderControl($data) {
    return $this->base($data, $this->contentTemplate($data));
  }

  /**
   * {@inheritdoc}
   */
  public function getDefaultSettings() {
    return [
      'input_type' => 'checkbox',
      'title' => '',
    ];
  }

}
