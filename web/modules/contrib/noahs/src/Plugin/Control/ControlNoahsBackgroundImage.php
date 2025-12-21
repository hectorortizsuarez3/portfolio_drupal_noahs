<?php

namespace Drupal\noahs_page_builder\Plugin\Control;

use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * @ControlPlugin(
 *   id = "noahs_background_image",
 *   label = @Translation("Bg image")
 * )
 */
class ControlNoahsBackgroundImage extends ControlBase {

  use StringTranslationTrait;

  /**
   * {@inheritdoc}
   */
  public function getype() {
    return 'noahs_background_image';
  }

  /**
   * {@inheritdoc}
   */
  public function contentTemplate(array $params = []) {
    $name = $params['name'] ?? NULL;
    $value = $params['value'] ?? NULL;

    $image_styles = $this->getImageStyles();

    $image = !empty($value['background_image']['thumbnail']) ? $value['background_image']['thumbnail'] : '/' . NOAHS_PAGE_BUILDER_PATH . '/assets/img/no-image-thumbnail.jpg';

    $field_names = [
      (string) $this->t('Position') => 'background_position',
      (string) $this->t('Repeat') => 'background_repeat',
      (string) $this->t('Attachment') => 'background_attachment',
      (string) $this->t('Size') => 'background_size',
    ];

    $options = [
      'background_position' => [
        '' => $this->t('Center Center'),
        'center top' => $this->t('Center Top'),
        'center right' => $this->t('Center Right'),
        'center bottom' => $this->t('Center Bottom'),
        'left top' => $this->t('Left Top'),
        'left center' => $this->t('Left Center'),
        'left bottom' => $this->t('Left Bottom'),
        'right top' => $this->t('Right Top'),
        'right center' => $this->t('Right Center'),
        'right bottom' => $this->t('Right Bottom'),
      ],
      'background_repeat' => [
        '' => $this->t('No Repeat'),
        'repeat' => $this->t('Repeat'),
        'repeat-x' => $this->t('Repeat X'),
        'repeat-y' => $this->t('Repeat Y'),
      ],
      'background_attachment' => [
        '' => $this->t('Default'),
        'scroll' => $this->t('Scroll'),
        'fixed' => $this->t('Fixed'),
      ],
      'background_size' => [
        '' => $this->t('Default'),
        'cover' => $this->t('Cover'),
        'contain' => $this->t('Contain'),
      ],
    ];

    $nameBase = $name . '[background_image]';
    $element_id = preg_replace('/[\[\]]+/', '_', $name);

    $html = '';
    $html .= '<div class="mb-3 background-image-field">';
    $html .= '<div class="media-preview-actions d-flex justify-content-center align-items-center mb-3">';
    $html .= '<img class="background-thumbnail-image" src="' . $image . '" alt="Thumbnail">';
    $html .= '<input type="hidden" name="' . $name . '[background_image][fid]" id="' . $element_id . '" value="' . (!empty($value['background_image']['fid']) ? $value['background_image']['fid'] : '') . '" class="form-control background-fid" field-settings>';
    $html .= '<input type="hidden" name="' . $name . '[background_image][thumbnail]" value="' . (!empty($value['background_image']['thumbnail']) ? $value['background_image']['thumbnail'] : '') . '" class="form-control background-thumbnail" field-settings>';
    $html .= '<input type="hidden" name="' . $name . '[background_image][url]" value="' . (!empty($value['background_image']['url']) ? $value['background_image']['url'] : '') . '" class="form-control background-url" field-settings>';
    $html .= '<input type="hidden" name="' . $name . '[background_image][media_type]" value="' . (!empty($value['background_image']['media_type']) ? $value['background_image']['media_type'] : '') . '" class="form-control background-media-type" field-settings>';
    $html .= '<div class="btn-actions">';
    $html .= '<button type="button" class="btn btn-light media-uploadbg_image border-dark" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="' . $this->t('Add/change Image') . '" data-element-id="' . $element_id . '"><i class="fa-solid fa-circle-plus"></i></button>';
    $html .= '<button type="button" class="btn btn-light media-removebg_image border-dark" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="' . $this->t('Remove Image') . '"><i class="fa-solid fa-trash"></i></button>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '<div class="noahs-img-drop-area border p-3 text-center"  data-source="background">' . $this->t('Drag and drop your image here') . '</div>';
    $html .= '</div>';

    $html .= '<div class="mb-3">';
    $html .= '<label for="">' . $this->t('Use Media Token Field') . '</label>';
    $html .= '<input type="text" name="' . $name . '[token_media]" value="' . (!empty($value['token_media']) ? $value['token_media'] : '') . '" class="form-control" field-settings>';
    $html .= '</div>';
    $html .= '<div class="nohas-field-description mb-4">' . $this->t('This is not available on token module, copy and replace your entity, field and style: [node:field_featured_image:entity:field_media_image:og_image_1200x630]') . '</div>';

    $html .= '<div class="row row-cols-3">';
    $html .= '<div class="col mb-3">';
    $html .= '<label for="noahs_page_builder_background_image_style">' . $this->t('Image Style') . '</label>';
    $html .= '<select name="' . $name . '[image_style]" class="form-control noahs-select-image-style" field-settings>';
    foreach ($image_styles as $k => $style) {
      $selected = (!empty($value['image_style']) && $value['image_style'] === $k) ? 'selected' : '';
      $html .= '<option value="' . $k . '" ' . $selected . '>' . $style . '</option>';
    }
    $html .= '</select>';
    $html .= '</div>';

    foreach ($field_names as $label => $field_name) {
      $html .= '<div class="col mb-3">';
      $html .= '<label for="noahs_page_builder_' . $field_name . '">' . $label . '</label>';
      $html .= '<select name="' . $nameBase . '[' . $field_name . ']" data-style-css="' . str_replace('_', '-', $field_name) . '" class="form-control" field-settings>';
      foreach ($options[$field_name] as $k => $title) {
        $selected = (!empty($value['background_image'][$field_name]) && $value['background_image'][$field_name] === $k) ? ' selected' : '';
        $html .= '<option value="' . $k . '" ' . $selected . '>' . $title . '</option>';
      }
      $html .= '</select>';
      $html .= '</div>';
    }

    $html .= '<div class="col mb-3">';
    $html .= '<label for="">' . $this->t('Custom Size') . '</label>';
    $html .= '<input type="text" name="' . $name . '[background_size_custom]" value="' . (!empty($value['background_size_custom']) ? $value['background_size_custom'] : '') . '" class="form-control" field-settings>';
    $html .= '<div class="nohas-field-description">' . $this->t('i.e. 100px 100px') . '</div>';
    $html .= '</div>';
    $html .= '<div class="col mb-3">';
    $html .= '<label for="">' . $this->t('Custom Position') . '</label>';
    $html .= '<input type="text" name="' . $name . '[background_position_custom]" value="' . (!empty($value['background_position_custom']) ? $value['background_position_custom'] : '') . '" class="form-control" field-settings>';
    $html .= '<div class="nohas-field-description">' . $this->t('i.e. 100px 100px') . '</div>';
    $html .= '</div>';
    $html .= '</div>';

    return $html;
  }

  /**
   * {@inheritdoc}
   */
  public function getDefaultSettings() {
    return [
      'input_type' => 'noahs_background_image',
      'placeholder' => '',
      'title' => '',
    ];
  }

}
