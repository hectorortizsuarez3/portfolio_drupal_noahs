<?php

namespace Drupal\noahs_page_builder\Plugin\Control;

use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * @ControlPlugin(
 *   id = "noahs_background_gradient",
 *   label = @Translation("Bg gradient")
 * )
 */
class ControlNoahsBackgroundGradient extends ControlBase {

  use StringTranslationTrait;

  /**
   * {@inheritdoc}
   */
  public function getype() {
    return 'noahs_background_gradient';
  }

  /**
   * {@inheritdoc}
   */
  public function contentTemplate(array $params = []) {
    $data = $params['data'] ?? NULL;
    $name = $params['name'] ?? NULL;
    $value = $params['value'] ?? NULL;

    // Asegurarte de que $value sea un array.
    $value = is_array($value) && !empty($value['gradient']) ? $value['gradient'] : [];

    $gradients_options = [
      '' => 'Select',
      'horizontal' => 'horizontal →',
      'vertical' => 'vertical ↓',
      'diagonal' => 'diagonal ↘',
      'diagonal-bottom' => 'diagonal ↗',
      'radial' => 'radial ○',
    ];

    $html = '<div class="field_group field_item mb-3">';
    $html .= '<label for="background_option_type">Background Gradient</label>';
    $html .= '<select class="orientation form-control" name="' . $name . '[gradient][type]" id="background_option_gradient_type" field-settings>';
    foreach ($gradients_options as $k => $label) {
      $selected = (!empty($value['type']) && $value['type'] === $k) ? 'selected' : '';
      $html .= '<option value="' . $k . '" ' . $selected . '>' . $label . '</option>';
    }
    $html .= '</select>';
    $html .= '</div>';

    $html .= '<div class="field_group field_item field__color mb-3">';
    $html .= '<label for="background_option_gradient">' . $this->t('Color primario') . '</label>';
    $html .= '<input type="text" name="' . $name . '[gradient][start][color]" id="background_option_gradient_start" class="form-control-color-alpha" value="' . ($value['start']['color'] ?? '') . '" field-settings>';
    $html .= '</div>';

    $html .= '<div class="field_group field_item mb-3">';
    $html .= '<label for="background_option_start">Start location</label>';
    $html .= '<input type="number" name="' . $name . '[gradient][start][location]" id="background_option_gradient_start_location" value="' . ($value['start']['location'] ?? '') . '" class="form-control" field-settings>';
    $html .= '</div>';

    $html .= '<div class="field_group field_item field__color mb-3">';
    $html .= '<label for="background_option_gradient">Color secundario</label>';
    $html .= '<input type="text" name="' . $name . '[gradient][end][color]" id="background_option_gradient_end" class="form-control-color-alpha" value="' . ($value['end']['color'] ?? '') . '" field-settings>';
    $html .= '</div>';

    $html .= '<div class="field_group field_item mb-3">';
    $html .= '<label for="background_option_end">End location</label>';
    $html .= '<input type="number" name="' . $name . '[gradient][end][location]" id="background_option_gradient_end_location" class="form-control" value="' . ($value['end']['location'] ?? '') . '" field-settings>';
    $html .= '</div>';

    return $html;
  }

  /**
   * {@inheritdoc}
   */
  public function getDefaultSettings() {
    return [
      'input_type' => 'noahs_background_gradient',
      'placeholder' => '',
      'title' => '',
    ];
  }

}
