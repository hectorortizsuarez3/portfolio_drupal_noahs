<?php

namespace Drupal\noahs_page_builder\Plugin\Control;

/**
 * @ControlPlugin(
 *   id = "textarea",
 *   label = @Translation("Textarea")
 * )
 */
class ControlTextarea extends ControlBase {

  /**
   * {@inheritdoc}
   */
  public function getype() {
    return 'textarea';
  }

  /**
   * {@inheritdoc}
   */
  public function contentTemplate(array $params = []) {

    $data = $params['data'] ?? NULL;
    $name = $params['name'] ?? NULL;
    $value = $params['value'] ?? NULL;
    if (!empty($value['text'])) {
      $value = $value['text'];
    }
    $delta = $params['delta'] ?? NULL;
    $text_editor = !empty($data['item']['format']) && $data['item']['format'] === 'noahs_textarea_plain' ? $data['item']['format'] : 'noahs_textarea_full_html';
    $value = $value ?? $data['item']['default_value'];
    $placeholder = !empty($data['item']['placeholder']) ? $data['item']['placeholder'] : '';
    $selector = !empty($data['item']['update_selector']) ? 'data-update-selector="#widget-id-' . $data['wid'] . ' ' . $data['item']['update_selector'] . '"' : NULL;

    if (!empty($delta)) {
      $selector = !empty($data['item']['update_selector']) ? 'data-update-selector="#widget-id-' . $data['wid'] . ' ' . str_replace('[index]', $delta, $data['item']['update_selector']) . '"' : NULL;
    }

    if (isset($data['delta']) && is_string($selector)) {
      if (strpos($selector, '[index]') !== FALSE) {
        $selector = str_replace('[index]', $data['delta'], $selector);
      }
    }

    $class = [];
    $class[] = 'noahs_page_builder_textarea form-control';
    $class[] = !empty($data['item']['noahs_ai']) ? 'noahs-ai-control' : FALSE;
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

    $output = '<div class="field field__textarea">';
    $output .= '<textarea 
					name="' . $name . '" 
					id="noahs_page_builder_textarea_' . $data['item_id'] . '" 
					title="' . $data['item']['title'] . '"
					' . $text_editor . '
					field-settings
					placeholder="' . $placeholder . '" 
					rows="10" 
					cols="50"
          ' . $attributes . '
					class="' . $class . '" ' . $selector . '>' . $value . '</textarea>';
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
