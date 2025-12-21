<?php

namespace Drupal\noahs_page_builder\Plugin\Control;

/**
 * @ControlPlugin(
 *   id = "noahs_transform",
 *   label = @Translation("Transform")
 * )
 */
class ControlNoahsTransform extends ControlBase {

  /**
   * {@inheritdoc}
   */
  public function getype() {
    return 'noahs_transform';
  }

  /**
   * {@inheritdoc}
   */
  public function contentTemplate(array $params = []) {
    $data = $params['data'] ?? NULL;
    $name = $params['name'] ?? NULL;
    $value = $params['value'] ?? NULL;
    $output = '';

    $output .= '<div class="mb-3 row row-cols-2">';
    $output .= '<div class="mb-2">';
    $output .= '<label class="form-label">Scale:</label>';
    $output .= '<input value="' . (!empty($value['scale']) ? htmlspecialchars($value['scale'], ENT_QUOTES, 'UTF-8') : '') . '" type="number" step="0.1" name="' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '[scale]" class="form-control">';
    $output .= '</div>';
    $output .= '<div class="mb-2">';
    $output .= '<label class="form-label">Rotate X:</label>';
    $output .= '<input value="' . (!empty($value['rotate_x']) ? htmlspecialchars($value['rotate_x'], ENT_QUOTES, 'UTF-8') : '') . '" type="number" name="' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '[rotate_x]" class="form-control">';
    $output .= '</div>';
    $output .= '<div class="mb-2">';
    $output .= '<label class="form-label">Rotate Y:</label>';
    $output .= '<input value="' . (!empty($value['rotate_y']) ? htmlspecialchars($value['rotate_y'], ENT_QUOTES, 'UTF-8') : '') . '" type="number" name="' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '[rotate_y]" class="form-control">';
    $output .= '</div>';
    $output .= '<div class="mb-2">';
    $output .= '<label class="form-label">Rotate Z:</label>';
    $output .= '<input value="' . (!empty($value['rotate_z']) ? htmlspecialchars($value['rotate_z'], ENT_QUOTES, 'UTF-8') : '') . '" type="number" name="' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '[rotate_z]" class="form-control">';
    $output .= '</div>';
    $output .= '<div class="mb-2">';
    $output .= '<label class="form-label">Translate X (Use width, px, %, etc...):</label>';
    $output .= '<input value="' . (!empty($value['translate_x']) ? htmlspecialchars($value['translate_x'], ENT_QUOTES, 'UTF-8') : '') . '" type="text" name="' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '[translate_x]" class="form-control">';
    $output .= '</div>';
    $output .= '<div class="mb-2">';
    $output .= '<label class="form-label">Translate Y (Use width, px, %, etc...):</label>';
    $output .= '<input value="' . (!empty($value['translate_y']) ? htmlspecialchars($value['translate_y'], ENT_QUOTES, 'UTF-8') : '') . '" type="text" name="' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '[translate_y]" class="form-control">';
    $output .= '</div>';
    $output .= '<div class="mb-2">';
    $output .= '<label class="form-label">Skew X:</label>';
    $output .= '<input value="' . (!empty($value['skew_x']) ? htmlspecialchars($value['skew_x'], ENT_QUOTES, 'UTF-8') : '') . '" type="number" name="' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '[skew_x]" class="form-control">';
    $output .= '</div>';
    $output .= '<div class="mb-2">';
    $output .= '<label class="form-label">Skew Y:</label>';
    $output .= '<input value="' . (!empty($value['skew_y']) ? htmlspecialchars($value['skew_y'], ENT_QUOTES, 'UTF-8') : '') . '" type="number" name="' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '[skew_y]" class="form-control">';
    $output .= '</div>';
    $output .= '<div class="mb-2">';
    $output .= '<label class="form-label">Skew Z:</label>';
    $output .= '<input value="' . (!empty($value['skew_z']) ? htmlspecialchars($value['skew_z'], ENT_QUOTES, 'UTF-8') : '') . '" type="number" name="' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '[skew_z]" class="form-control">';
    $output .= '</div>';
    $output .= '</div>';

    return $output;
  }

  /**
   * {@inheritdoc}
   */
  public function getDefaultSettings() {
    return [
      'input_type' => 'noahs_transform',
      'placeholder' => '',
      'title' => '',
    ];
  }

}
