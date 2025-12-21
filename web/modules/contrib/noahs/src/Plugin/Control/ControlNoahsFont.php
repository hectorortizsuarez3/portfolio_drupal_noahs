<?php

namespace Drupal\noahs_page_builder\Plugin\Control;

use Drupal\noahs_page_builder\Fonts;

/**
 * @ControlPlugin(
 *   id = "noahs_font",
 *   label = @Translation("Font")
 * )
 */
class ControlNoahsFont extends ControlBase {

  /**
   * {@inheritdoc}
   */
  public function getype() {
    return 'noahs_font';
  }

  /**
   * {@inheritdoc}
   */
  public function contentTemplate(array $params = []) {
    $data = $params['data'] ?? NULL;
    $name = $params['name'] ?? NULL;
    $value = $params['value'] ?? NULL;
    $id = $data['wid'];

    $text_transform_options = [
      '' => 'Default',
      'uppercase' => 'Uppercase',
      'lowercase' => 'Lowercase',
      'capitalize' => 'Capitalize',
      'none' => 'Normal',
    ];

    $font_style_options = [
      '' => 'Default',
      'normal' => 'Normal',
      'italic' => 'Italic',
      'oblique' => 'Oblique',
    ];

    $text_decoration_options = [
      '' => 'Default',
      'underline' => 'Underline',
      'overline' => 'Overline',
      'line-through' => 'Line Through',
      'none' => 'None',
    ];

    $output = '';

    $output .= '<div class="row gx-2 mb-3">';
    $output .= '<div class="col-4">';
    $output .= '<label for="noahs_page_builder_font">' . t('Font family') . '</label>';
    $output .= '<select name="' . $name . '[font_family]" class="form-select" field-settings>';
    foreach (Fonts::getFontsAvailables() as $key => $font) {
      $output .= '<option value="' . $key . '" ' . (!empty($value['font_family']) && $value['font_family'] === $font ? 'selected' : '') . '>' . $font . '</option>';
    }
    $output .= '</select>';
    $output .= '</div>';
    $output .= '<div class="col-4">';
    $output .= '<label for="noahs_page_builder_font">' . t('Font Weight') . '</label>';
    $output .= '<select name="' . $name . '[font_weight]" class="form-select" field-settings data-value="' . (!empty($value['font_weight']) ? $value['font_weight'] : '') . '">';
    foreach (Fonts::getFontsWeights() as $key_weight => $font_weight) {
      $selected = (!empty($value['font_weight']) && trim((string)$value['font_weight']) === (string)$key_weight) 
        ? ' selected="selected"' 
        : '';

      $output .= '<option value="' . $key_weight . '"' . $selected . '>' . $font_weight . '</option>';
    }
    $output .= '</select>';
    $output .= '</div>';

    $output .= '<div class="col-4">';
    $output .= '<label for="noahs_page_builder_font">' . t('Font Size') . '</label>';
    $output .= '<input type="text" name="' . $name . '[font_size]" value="' . (!empty($value['font_size']) ? $value['font_size'] : '') . '" placeholder="16px" class="form-control" field-settings>';
    $output .= '</div>';
    $output .= '</div>';

    $output .= '<div class="row gx-2 mb-3">';
    $output .= '<div class="col-4">';
    $output .= '<label for="noahs_page_builder_font">' . t('Transform') . '</label>';
    $output .= '<select name="' . $name . '[text_transform]" class="form-select" field-settings>';
    foreach ($text_transform_options as $k => $label) {
      $output .= '<option value="' . $k . '" ' . (!empty($value['text_transform']) && $value['text_transform'] === $k ? 'selected' : '') . '>' . $label . '</option>';
    }
    $output .= '</select>';
    $output .= '</div>';

    $output .= '<div class="col-4">';
    $output .= '<label for="noahs_page_builder_font">' . t('Style') . '</label>';
    $output .= '<select name="' . $name . '[font_style]" class="form-select" field-settings>';
    foreach ($font_style_options as $k => $label) {
      $output .= '<option value="' . $k . '" ' . (!empty($value['font_style']) && $value['font_style'] === $k ? 'selected' : '') . '>' . $label . '</option>';
    }
    $output .= '</select>';
    $output .= '</div>';

    $output .= '<div class="col-4">';
    $output .= '<label for="noahs_page_builder_font">' . t('Decoration') . '</label>';
    $output .= '<select name="' . $name . '[text_decoration]" class="form-select" field-settings>';
    foreach ($text_decoration_options as $k => $label) {
      $output .= '<option value="' . $k . '" ' . (!empty($value['text_decoration']) && $value['text_decoration'] === $k ? 'selected' : '') . '>' . $label . '</option>';
    }
    $output .= '</select>';
    $output .= '</div>';
    $output .= '</div>';

    $output .= '<div class="row gx-2 mb-3">';
    $output .= '<div class="col-3">';
    $output .= '<label for="noahs_page_builder_font">' . t('Line height') . '</label>';
    $output .= '<input type="text" name="' . $name . '[line_height]" class="form-control" value="' . (!empty($value['line_height']) ? $value['line_height'] : '') . '" field-settings>';
    $output .= '</div>';

    $output .= '<div class="col-3">';
    $output .= '<label for="noahs_page_builder_font">' . t('Letter Space') . '</label>';
    $output .= '<input type="text" name="' . $name . '[letter_spacing]" class="form-control" value="' . (!empty($value['letter_spacing']) ? $value['letter_spacing'] : '') . '" field-settings>';
    $output .= '</div>';

    $output .= '<div class="col-3">';
    $output .= '<label for="noahs_page_builder_font">' . t('Word Space') . '</label>';
    $output .= '<input type="text" name="' . $name . '[word_spacing]" class="form-control" value="' . (!empty($value['word_spacing']) ? $value['word_spacing'] : '') . '" field-settings>';
    $output .= '</div>';

    $output .= '<div class="col-3">';
    $output .= '<label for="noahs_page_builder_font_color">' . t('Color') . '</label>';
    $output .= '<input type="text" name="' . $name . '[color]" class="form-control-color" value="' . (!empty($value['color']) ? $value['color'] : '') . '" field-settings>';
    $output .= '</div>';

    $output .= '</div>';

    // New row: margin & padding (top/bottom) on a single line.
    $output .= '<div class="row gx-2 mb-3">';
    // Margin Top
    $output .= '<div class="col-3">';
    $output .= '<label>' . t('Margin Top') . '</label>';
    $output .= '<input type="text" name="' . $name . '[margin_top]" class="form-control" value="' . (!empty($value['margin_top']) ? $value['margin_top'] : '') . '" placeholder="20px" field-settings>';
    $output .= '</div>';
    // Margin Bottom
    $output .= '<div class="col-3">';
    $output .= '<label>' . t('Margin Bottom') . '</label>';
    $output .= '<input type="text" name="' . $name . '[margin_bottom]" class="form-control" value="' . (!empty($value['margin_bottom']) ? $value['margin_bottom'] : '') . '" placeholder="20px" field-settings>';
    $output .= '</div>';
    // Padding Top
    $output .= '<div class="col-3">';
    $output .= '<label>' . t('Padding Top') . '</label>';
    $output .= '<input type="text" name="' . $name . '[padding_top]" class="form-control" value="' . (!empty($value['padding_top']) ? $value['padding_top'] : '') . '" placeholder="10px" field-settings>';
    $output .= '</div>';
    // Padding Bottom
    $output .= '<div class="col-3">';
    $output .= '<label>' . t('Padding Bottom') . '</label>';
    $output .= '<input type="text" name="' . $name . '[padding_bottom]" class="form-control" value="' . (!empty($value['padding_bottom']) ? $value['padding_bottom'] : '') . '" placeholder="10px" field-settings>';
    $output .= '</div>';
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
      'input_type' => 'noahs_font',
      'placeholder' => '',
      'title' => '',
    ];
  }

}
