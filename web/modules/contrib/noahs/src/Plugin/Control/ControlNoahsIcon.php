<?php

namespace Drupal\noahs_page_builder\Plugin\Control;

use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * @ControlPlugin(
 *   id = "noahs_icon",
 *   label = @Translation("Icon")
 * )
 */
class ControlNoahsIcon extends ControlBase {

  use StringTranslationTrait;

  /**
   * {@inheritdoc}
   */
  public function getype() {
    return 'noahs_icon';
  }

  /**
   * {@inheritdoc}
   */
  public function contentTemplate(array $params = []) {
    $data = $params['data'] ?? NULL;
    $name = $params['name'] ?? NULL;
    $value = $params['value'] ?? NULL;
    $delta = $params['delta'] ?? NULL;
    $id = $data['wid'];
    $field_id = str_replace(['[', ']'], ['_', ''], $name);
    $icon = $value['class'] ?? '';
    $icon = empty($icon) && !empty($data['item']['default_value']) ? $data['item']['default_value'] : $icon;

    $image = empty($value['url']) && !empty($data['item']['default_value']) ? $data['item']['default_value'] : $value['url'];

    $output = '<div class="media-preview-actions d-flex justify-content-center align-items-center">';
    $output .= '<div class="mb-3 image-svg ' . (empty($value['url']) ? 'hidden' : '') . '" id="background_thumbnail_svg_' . $delta . '">';
    $output .= '<img src="' . $image . '" alt="Thumbnail" style="width:50px;"></div>';
    $output .= '<input type="hidden" name="' . $name . '[class]" id="noahs_page_builder_icon_class_' . $delta . '" value="' . $icon . '" class="form-control" field-settings>';
    $output .= '<input type="hidden" name="' . $name . '[fid]" id="noahs_page_builder_icon_fid_' . $delta . '" value="' . (!empty($value['fid']) ? $value['fid'] : '') . '" class="form-control" field-settings>';
    $output .= '<input type="hidden" name="' . $name . '[url]" id="noahs_page_builder_icon_url_' . $delta . '" value="' . (!empty($value['url']) ? $value['url'] : '') . '" class="form-control" field-settings>';
    $output .= '<span class="icon-empty ' . $icon . '"></span>';
    $output .= '<div class="btn-actions">';
    $output .= '<button type="button" id="element_' . $field_id . $delta . '" data-element-id="element_' . $field_id . $delta . '" class="btn btn-light media-select-icon border-dark" data-delta="' . $delta . '" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="' . $this->t('Add/change Icon') . '"><i class="las la-plus-circle"></i></button>';
    $output .= '<button type="button" id="remove_' . $field_id . $delta . '" class="btn btn-light media-remove-icon border-dark" data-delta="' . $delta . '" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="' . $this->t('Remove Icon') . '" data-element-id="element_' . $field_id . $delta . '"><i class="las la-trash-alt"></i></button>';
    $output .= '</div></div>';

    return $output;
  }

  /**
   * {@inheritdoc}
   */
  public function getDefaultSettings() {
    return [
      'input_type' => 'noahs_icon',
      'placeholder' => '',
      'title' => '',
    ];
  }

}
