<?php

namespace Drupal\noahs_page_builder\Plugin\Control;

use Drupal\noahs_page_builder_pro\Controller\NoahsMaskImageProController;

/**
 * @ControlPlugin(
 *   id = "noahs_image_mask",
 *   label = @Translation("Image Mask")
 * )
 */
class ControlNoahsImageMask extends ControlBase {

  /**
   * {@inheritdoc}
   */
  public function getype() {
    return 'noahs_image_mask';
  }

  /**
   * {@inheritdoc}
   */
  public function contentTemplate(array $params = []) {
    $data = $params['data'] ?? NULL;
    $name = $params['name'] ?? NULL;
    $value = $params['value'] ?? NULL;
    $id = $data['wid'];
    $items = NoahsMaskImageProController::list($name);

    $options = [
      '' => 'Auto',
      'cover' => 'Cover',
      'contain' => 'Contain',
      'initial' => 'Custom',
    ];

    $output = '';

    $output .= '<div class="media-preview-actions media-preview-actions--mask overflow-auto mb-3" style="height:200px">';
    $output .= '<div class="row gap-3">';
    foreach ($items as $k => $item) {
      $checked = (!empty($value['mask_size']) && $item === $value['mask']) ? 'checked' : '';
      $output .= '<div class="col-2 d-flex align-items-center">';
      $output .= '<label for="mask-' . $k . '">';
      $output .= '<input type="radio" id="mask-' . $k . '" name="' . $name . '[mask]" value="' . $item . '" ' . $checked . ' field-setting>';
      $output .= '<img src="' . $item . '" alt="SVG Image" class="w-100">';
      $output .= '</label>';
      $output .= '</div>';
    }
    $output .= '</div>';
    $output .= '<div class="btn-group position-absolute d-flex justify-content-between w-100">';
    $output .= '<button type="button" class="btn btn-danger media-remove_mask_image area_tooltip" title=""><i class="fa-solid fa-trash"></i></button>';
    $output .= '</div>';
    $output .= '</div>';

    $output .= '<div class="mb-3">';
    $output .= '<label class="form-label">Mask Size (usep px, %, rem, wv...)</label>';
    $output .= '<select name="' . $name . '[mask_size]" class="form-control" field-setting>';
    foreach ($options as $key => $label) {
      $selected = (!empty($value['mask_size']) && $value['mask_size'] === $key) ? 'selected' : '';
      $output .= '<option value="' . $key . '" ' . $selected . '>' . $label . '</option>';
    }
    $output .= '</select>';
    $output .= '</div>';

    return $output;
  }

  /**
   * {@inheritdoc}
   */
  public function getDefaultSettings() {
    return [
      'input_type' => 'noahs_image_mask',
      'placeholder' => '',
      'title' => '',
    ];
  }

}
