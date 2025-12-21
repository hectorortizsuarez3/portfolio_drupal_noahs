<?php

namespace Drupal\noahs_page_builder\Plugin\Control;

use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * @ControlPlugin(
 *   id = "noahs_border",
 *   label = @Translation("Border")
 * )
 */
class ControlNoahsBorder extends ControlBase {

  use StringTranslationTrait;

  /**
   * {@inheritdoc}
   */
  public function getype() {
    return 'noahs_border';
  }

  /**
   * {@inheritdoc}
   */
  public function contentTemplate(array $params = []) {
    $data = $params['data'] ?? NULL;
    $name = $params['name'] ?? NULL;
    $value = $params['value'] ?? NULL;
    $options = [
      '' => 'Por defecto',
      'none' => 'Ninguno',
      'solid' => 'Continuo',
      'double' => 'Doble',
      'dotted' => 'Punteado',
      'dashed' => 'Discontinuo',
      'groove' => 'Acanalado',
    ];

    $html = '';

    $html .= '<div class="row  mb-3">';
    $html .= '<div class="col">';
    $html .= '<label class="font-weight-bold">' . $this->t('Border Color') . '</label>';
    $html .= '<input type="text" name="' . htmlspecialchars($name) . '[border_color]" id="noahs_page_builder_border_color" class="form-control-color-alpha" value="' . htmlspecialchars(!empty($value['border_color']) ? $value['border_color'] : '') . '" field-settings>';
    $html .= '<div class="small">Use your property as px, em, rem, %, ...</div>';
    $html .= '</div>';

    $html .= '<div class="col">';
    $html .= '<label class="font-weight-bold">' . $this->t('Border Style') . '</label>';
    $html .= '<select name="' . htmlspecialchars($name) . '[border_style]" class="form-select" field-settings>';
    foreach ($options as $k => $label) {
      $selected = (!empty($value['border_style']) && $value['border_style'] === $k) ? 'selected' : '';
      $html .= '<option value="' . htmlspecialchars($k) . '" ' . $selected . '>' . htmlspecialchars($label) . '</option>';
    }
    $html .= '</select>';
    $html .= '</div>';
    $html .= '</div>';

    $html .= '<ul class="field-element-list-horizontal">';
    $borderSides = ['left', 'top', 'right', 'bottom'];
    foreach ($borderSides as $side) {
      $html .= '<li>';
      $html .= '<input type="text" name="' . htmlspecialchars($name) . '[border_' . $side . '_width]" value="' . htmlspecialchars(!empty($value['border_' . $side . '_width']) ? $value['border_' . $side . '_width'] : '') . '" class="form-control" field-settings>';
      $html .= '<label for="noahs_page_builder_border_' . $side . '">' . ucfirst($side) . '</label>';
      $html .= '</li>';
    }
    $html .= '<li class="link-li">';
    $html .= '<label class="link-label">';
    $html .= '<input type="checkbox" class="link-checkbox" name="' . htmlspecialchars($name) . '[input_linked]" ' . (!empty($value['input_linked']) ? 'checked' : '') . '>';
    $html .= '<span class="link-icon" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="' . t('Link values') . '"><i class="la la-link"></i></span>';
    $html .= '</label>';
    $html .= '</li>';
    $html .= '</ul>';

    return $html;
  }

  /**
   * {@inheritdoc}
   */
  public function getDefaultSettings() {
    return [
      'input_type' => 'noahs_border',
      'placeholder' => '',
      'title' => '',
    ];
  }

}
