<?php

namespace Drupal\noahs_page_builder\Plugin\Control;

/**
 * @ControlPlugin(
 *   id = "text",
 *   label = @Translation("Text")
 * )
 */
class ControlText extends ControlBase {

  /**
   * {@inheritdoc}
   */
  public function getype() {
    return 'text';
  }

  /**
   * {@inheritdoc}
   */
  public function contentTemplate(array $params = []) {
    $data = $params['data'] ?? NULL;
    $name = $params['name'] ?? NULL;
    $value = $params['value'] ?? NULL;
    $delta = $params['delta'] ?? NULL;

    $attributes = '';
    $class = [];
    $class[] = 'form-control';
    $class[] = !empty($data['item']['noahs_ai']) ? 'noahs-ai-control' : FALSE;
    $placeholder = !empty($data['item']['placeholder']) ? $data['item']['placeholder'] : $data['item']['title'];
    $selector = !empty($data['item']['update_selector']) ? 'data-update-selector="#widget-id-' . $data['wid'] . ' ' . $data['item']['update_selector'] . '"' : NULL;
    $rows_number = !empty($data['item']['rows']) ? (int) $data['item']['rows'] : 2;

    if (isset($data['delta']) && is_string($selector)) {
      if (strpos($selector, '[index]') !== FALSE) {
        $selector = str_replace('[index]', $data['delta'], $selector);
      }
    }

    $output = '<div class="field_item">';

    if (!empty($data['item']['autocomplete'])) {
      $class[] = 'select2-control';
      $class[] = $data['item']['autocomplete'];
    }

    if (!empty($data['item']['attributes'])) {
      $attributes = implode(' ', array_map(
      function ($key, $value) {
        return sprintf('%s="%s"', $key, htmlspecialchars($value));
      },
                array_keys($data['item']['attributes']),
                $data['item']['attributes']
      ));
      $class[] = !empty($data['item']['attributes']['class']) ? $data['item']['attributes']['class'] : NULL;
    }

    $class = implode(" ", $class);

    $value = is_array($value) ? ($value['text'] ?? '') : $value;

    if (!empty($data['item']['format']) && $data['item']['format'] === 'json') {
      $value = $value['text'] ? $value['text'] : '';
    }

    $output .= '<input type="hidden" name="' . $name . '[extra_value]" value="' . ($value['extra_value'] ?? '') . '" field-settings/>';

    if (empty($data['item']['textarea'])) {
      $output .= '<input type="text" name="' . $name . '[text]" ' . $attributes . ' title="' . $data['item']['title'] . '" class="' . $class . '" value="' . htmlspecialchars($value ?? '') . '" placeholder="' . $placeholder . '" ' . $selector . ' field-settings/>';
    }
    else{
      $output .= '<textarea rows="' . $rows_number . '" name="' . $name . '[text]" ' . $attributes . ' title="' . $data['item']['title'] . '" class="' . $class . '" placeholder="' . $placeholder . '" ' . $selector . ' field-settings/>' . $value . '</textarea>';
    }  

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
      'input_type' => 'text',
      'placeholder' => '',
      'title' => '',
    ];
  }

}
