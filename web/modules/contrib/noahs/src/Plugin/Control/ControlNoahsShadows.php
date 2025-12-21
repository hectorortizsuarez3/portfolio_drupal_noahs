<?php

namespace Drupal\noahs_page_builder\Plugin\Control;

/**
 * @ControlPlugin(
 *   id = "noahs_shadows",
 *   label = @Translation("Shadows")
 * )
 */
class ControlNoahsShadows extends ControlBase {

  /**
   * {@inheritdoc}
   */
  public function getype() {
    return 'noahs_shadows';
  }

  /**
   * {@inheritdoc}
   */
  public function contentTemplate(array $params = []) {
    $data = $params['data'] ?? NULL;
    $name = $params['name'] ?? NULL;
    $value = $params['value'] ?? NULL;
    $output = '';

    $output .= '<div class="row">';
    $output .= '<div class="col col-8">';
    $output .= '<ul class="field-element-list-horizontal">';
    $output .= '<li>';
    $output .= '<input type="text" name="' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '[shadow_x]" value="' . (!empty($value['shadow_x']) ? htmlspecialchars($value['shadow_x'], ENT_QUOTES, 'UTF-8') : '') . '" class="form-control" field-settings>';
    $output .= '<label for="noahs_page_builder_shadow_x">' . ('Horizontal') . '</label>';
    $output .= '</li>';
    $output .= '<li>';
    $output .= '<input type="text" name="' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '[shadow_y]" value="' . (!empty($value['shadow_y']) ? htmlspecialchars($value['shadow_y'], ENT_QUOTES, 'UTF-8') : '') . '" class="form-control" field-settings>';
    $output .= '<label for="noahs_page_builder_shadow_y">' . ('Vertical') . '</label>';
    $output .= '</li>';
    $output .= '<li>';
    $output .= '<input type="text" name="' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '[blur]" value="' . (!empty($value['blur']) ? htmlspecialchars($value['blur'], ENT_QUOTES, 'UTF-8') : '') . '" class="form-control" field-settings>';
    $output .= '<label for="noahs_page_builder_shadow_blur">' . ('Blur') . '</label>';
    $output .= '</li>';
    $output .= '<li>';
    $output .= '<input type="text" name="' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '[spread]" value="' . (!empty($value['spread']) ? htmlspecialchars($value['spread'], ENT_QUOTES, 'UTF-8') : '') . '" class="form-control" field-settings>';
    $output .= '<label for="noahs_page_builder_shadow_spread">' . ('Spread') . '</label>';
    $output .= '</li>';
    $output .= '</ul>';
    $output .= '</div>';
    $output .= '<div class="col col-4">';
    $output .= '<input type="text" name="' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '[color]" class="form-control-color-alpha" value="' . (!empty($value['color']) ? htmlspecialchars($value['color'], ENT_QUOTES, 'UTF-8') : '') . '" field-settings>';
    $output .= '</div>';
    $output .= '</div>';

    return $output;
  }

  /**
   * {@inheritdoc}
   */
  public function getDefaultSettings() {
    return [
      'input_type' => 'noahs_shadows',
      'placeholder' => '',
      'title' => '',
    ];
  }

}
