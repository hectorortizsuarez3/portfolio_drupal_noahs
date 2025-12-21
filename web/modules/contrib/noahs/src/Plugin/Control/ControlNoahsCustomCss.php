<?php

namespace Drupal\noahs_page_builder\Plugin\Control;

/**
 * @ControlPlugin(
 *   id = "noahs_custom_css",
 *   label = @Translation("Custom CSS")
 * )
 */
class ControlNoahsCustomCss extends ControlBase {

  /**
   * {@inheritdoc}
   */
  public function getype() {
    return 'noahs_custom_css';
  }

  /**
   * {@inheritdoc}
   */
  public function contentTemplate(array $params = []) {
    $data = $params['data'] ?? NULL;
    $name = $params['name'] ?? NULL;
    $value = $params['value'] ?? NULL;
    $delta = $params['delta'] ?? NULL;

    $placeholder = !empty($data['item']['placeholder']) ? $data['item']['placeholder'] : '';
    $selector = !empty($data['item']['update_selector']) ? 'data-update-selector="' . str_replace('[index]', $delta, $data['item']['update_selector']) . '"' : NULL;
    $output = '<div class="field field__textarea">';
    $output .= '<label for="' . $data['item_id'] . '">' . $data['item']['title'] . '</label>';
    $output .= '<textarea 
					name="' . $name . '" 
					class="noahs_page_builder_codemirror w-100" 
					title="' . $data['item']['title'] . '"
					field-settings
					placeholder="' . $placeholder . '" 
					rows="10" 
					class="" ' . $selector . '>' . $value . '</textarea>';
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
      'input_type' => 'noahs_custom_css',
      'placeholder' => '',
      'title' => '',
    ];
  }

}
