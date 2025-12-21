<?php

namespace Drupal\noahs_page_builder\Plugin\Control;

use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * @ControlPlugin(
 *   id = "noahs_image",
 *   label = @Translation("Image")
 * )
 */
class ControlNoahsImage extends ControlBase {

  use StringTranslationTrait;

  /**
   * {@inheritdoc}
   */
  public function getype() {
    return 'noahs_image';
  }

  /**
   * {@inheritdoc}
   */
  public function contentTemplate(array $params = []) {
    $data = $params['data'] ?? NULL;
    $name = $params['name'] ?? NULL;
    $value = $params['value'] ?? NULL;
    $image_styles = $this->getImageStyles();
    $no_image = '/' . NOAHS_PAGE_BUILDER_PATH . '/assets/img/no-image-thumbnail.jpg';
    $image = (!empty($value['thumbnail']) || !empty($data['item']['default_value'])) ? ($value['thumbnail'] ?? $data['item']['default_value']) : $no_image;
    $element_id = str_replace('[', '_', $name);
    $element_id = str_replace(']', '_', $element_id);

    $output = '';

    $output .= '<div class="mb-3 background-image-field">';
    $output .= '<div class="media-preview-actions d-flex justify-content-center align-items-center mb-3">';
    $output .= '<img class="background-thumbnail-image" src="' . $image . '" alt="Thumbnail">';
    $output .= '<input type="hidden" name="' . $name . '[fid]" id="' . $element_id . '_fid" value="' . ($value['fid'] ?? '') . '" class="form-control background-fid" field-settings>';
    $output .= '<input type="hidden" name="' . $name . '[thumbnail]" id="' . $element_id . '_thumbnail" value="' . ($value['thumbnail'] ?? '') . '" class="form-control background-thumbnail" field-settings>';
    $output .= '<input type="hidden" name="' . $name . '[media_type]" id="' . $element_id . '_media_type" value="' . ($value['media_type'] ?? '') . '" class="form-control background-media-type" field-settings>';
    $output .= '<div class="btn-actions">';
    $output .= '<button type="button" class="btn btn-light media-upload_image border-dark" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="' . $this->t('Add/change Image') . '" data-element-id="' . $element_id . '_fid"><i class="las la-plus-circle"></i></button>';
    $output .= '<button type="button" class="btn btn-light media-removebg_image remove-single border-dark" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="' . $this->t('Remove Image') . '"><i class="lar la-trash-alt"></i></button>';
    $output .= '</div>';
    $output .= '</div>';
    $output .= '<div class="noahs-img-drop-area border p-3 text-center" data-source="image">' . $this->t('Drag and drop your image here') . '</div>';

    $output .= '<div class="mb-3">';
    $output .= '<label for="">' . $this->t('Use Media Token Field') . '</label>';
    $output .= '<input type="text" name="' . $name . '[token_media]" value="' . ($value['token_media'] ?? '') . '" class="form-control" field-settings>';
    $output .= '</div>';
    $output .= '<div class="nohas-field-description mb-4">' . $this->t('This is not available on token module, copy and replace your entity, field and style: [node:field_featured_image:entity:field_media_image:og_image_1200x630]') . '</div>';
    $output .= '<div class="field_group field_item mb-3">';
    $output .= '<label for="noahs_page_builder_background_image_style">' . $this->t('Image Style') . '</label>';
    $output .= '<select name="' . $name . '[image_style]" class="form-control noahs-regenerate-design" field-settings>';
    foreach ($image_styles as $k => $style) {
      $selected = (!empty($value['image_style']) && $value['image_style'] === $k) ? 'selected' : '';
      $output .= '<option value="' . $k . '" ' . $selected . '>' . $style . '</option>';
    }
    $output .= '</select>';
    $output .= '</div>';
    $output .= '</div>';

    return $output;
  }

  /**
   * {@inheritdoc}
   */
  public function getDefaultSettings() {
    return [
      'input_type' => 'noahs_background',
      'placeholder' => '',
      'title' => '',
    ];
  }

}
