<?php

namespace Drupal\noahs_page_builder\Plugin\Control;

/**
 * @ControlPlugin(
 *   id = "noahs_background_overlay",
 *   label = @Translation("Bg overlay")
 * )
 */
class ControlNoahsBackgroundOverlay extends ControlBase {

  /**
   * {@inheritdoc}
   */
  public function getype() {
    return 'noahs_background_overlay';
  }

  /**
   * {@inheritdoc}
   */
  public function contentTemplate(array $params = []) {
    $data = $params['data'] ?? NULL;
    $name = $params['name'] ?? NULL;
    $delta = $params['delta'] ?? NULL;
    $value = $params['value'] ?? NULL;
    $id = $data['wid'];

    $overlays_options = [
      '' => 'Select',
      'solid' => 'Solid',
      'horizontal' => 'Gradient horizontal →',
      'vertical' => 'Gradient vertical ↓',
      'diagonal' => 'Gradient diagonal ↘',
      'diagonal-bottom' => 'Gradient diagonal ↗',
      'radial' => 'Gradient radial ○',
    ];

    $value = !empty($value['overlay']) ? $value['overlay'] : '';

    $html = '<div class="field_group field_item mb-3">';
    $html .= '<label for="background_option_type">Background overlay</label>';
    $html .= '<select class="orientation form-control" name="' . htmlspecialchars($name) . '[overlay][type]" id="background_option_overlay_type" field-settings>';
    foreach ($overlays_options as $k => $label) {
      $selected = (!empty($value['type']) && $value['type'] === $k) ? 'selected' : '';
      $html .= '<option value="' . htmlspecialchars($k) . '" ' . $selected . '>' . htmlspecialchars($label) . '</option>';
    }
    $html .= '</select>';
    $html .= '</div>';

    $html .= '<div class="field_group field_item field__color mb-3">';
    $html .= '<label for="background_option_overlay">Color primario</label>';
    $html .= '<input type="text" name="' . htmlspecialchars($name) . '[overlay][start][color]" id="background_option_overlay_start" class="form-control-color-alpha" value="' . htmlspecialchars($value['start']['color'] ?? '') . '" field-settings>';
    $html .= '</div>';

    $html .= '<div class="field_group field_item mb-3">';
    $html .= '<label for="background_option_start">Start location</label>';
    $html .= '<input type="number" name="' . htmlspecialchars($name) . '[overlay][start][location]" id="background_option_overlay_start_location" value="' . htmlspecialchars($value['start']['location'] ?? '') . '" class="form-control" field-settings>';
    $html .= '</div>';

    $html .= '<div class="field_group field_item field__color mb-3">';
    $html .= '<label for="background_option_overlay">Color secundario</label>';
    $html .= '<input type="text" name="' . htmlspecialchars($name) . '[overlay][end][color]" id="background_option_overlay_end" class="form-control-color-alpha" value="' . htmlspecialchars($value['end']['color'] ?? '') . '" field-settings>';
    $html .= '</div>';

    $html .= '<div class="field_group field_item mb-3">';
    $html .= '<label for="background_option_end">End location</label>';
    $html .= '<input type="number" name="' . htmlspecialchars($name) . '[overlay][end][location]" id="background_option_overlay_end_location" class="form-control" value="' . htmlspecialchars($value['end']['location'] ?? '') . '" field-settings>';
    $html .= '</div>';

    return $html;
  }

  /**
   * {@inheritdoc}
   */
  public function getDefaultSettings() {
    return [
      'input_type' => 'noahs_background_overlay',
      'placeholder' => '',
      'title' => '',
    ];
  }

}
