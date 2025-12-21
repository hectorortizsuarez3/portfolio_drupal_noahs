<?php

namespace Drupal\noahs_page_builder\Plugin\Control;

use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\image\Entity\ImageStyle;
use Drupal\media\Entity\Media;

/**
 * @ControlPlugin(
 *   id = "noahs_gallery",
 *   label = @Translation("Gallery")
 * )
 */
class ControlNoahsGallery extends ControlBase {

  use StringTranslationTrait;

  /**
   * {@inheritdoc}
   */
  public function getype() {
    return 'noahs_gallery';
  }

  /**
   * {@inheritdoc}
   */
  public function contentTemplate(array $params = []) {
    $data = $params['data'] ?? NULL;
    $name = $params['name'] ?? NULL;
    $value = $params['value'] ?? NULL;

    $items = $value ? $value : [];
    $data_field = [];

    $html = '';

    $html .= '<div class="noahs_page_builder_gallery_field">';
    $html .= '<div id="' . $data['item_id'] . '">';
    $html .= '<div class="gallery-images-wrapper p-3 mb-3 bg-light rounded-3 row position-relative" id="gallery-images-wrapper">';

    foreach ($items as $i => $item) {

      $image = '';
      if (isset($item['fid'])) {
        $media = Media::load($item['fid']);
        $media_bundle = 'noahs_image';
        if (\Drupal::entityTypeManager()->getStorage('media_type')->load('image')) {
          if (!\Drupal::entityTypeManager()->getStorage('media_type')->load('noahs_image')) {
            $media_bundle = 'image';
          }
        }
        if ($media && $media->bundle() === $media_bundle) {
          $media_field_name = 'field_media_image';
          if ($media->hasField($media_field_name) && !$media->get($media_field_name)->isEmpty()) {
            $file = $media->get($media_field_name)->entity;
            if (!empty($file)) {
              $file_uri = $file->getFileUri();
              $image = ImageStyle::load('thumbnail')->buildUrl($file_uri);
            }
          }
        }
      }

      $html .= '<div class="col-3 image-box mb-2 position-relative" data-value="' . $item['fid'] . '" data-delta="' . $i . '">';
      $html .= '<div class="noahs_gallery_field_actions">';
      $html .= '<div class="noahs_page_builder-edit-grid-item btn btn-sm btn-info position-absolute top-50 start-50 translate-middle rounded-circle" data-bs-toggle="modal" data-bs-target="#editGalleryImageModal-' . $i . '"><i class="fa-solid fa-pen-to-square"></i></div>';
      $html .= '<div class="noahs_page_builder-move-grid-item btn btn-sm btn-info position-absolute top-0 start-0 rounded-circle"><i class="fa-solid fa-arrows-up-down-left-right"></i></div>';
      $html .= '<button type="button" class="noahs_page_builder-remove-grid-item btn btn-sm btn-danger position-absolute bottom-0 end-0 rounded-circle"><i class="fa-solid fa-trash"></i></button>';
      $html .= '</div>';
      $html .= '<img src="' . $image . '" style="width:100%; height:auto;">';

      // Modal HTML.
      $html .= '<div class="modal fade" id="editGalleryImageModal-' . $i . '" tabindex="-1" aria-labelledby="editGalleryImageModalLabel-' . $i . '" aria-hidden="true">';
      $html .= '<div class="modal-dialog">';
      $html .= '<div class="modal-content">';
      $html .= '<div class="modal-header">';
      $html .= '<h5 class="modal-title" id="editGalleryImageModalLabel-' . $i . '">' . $this->t('Edit Image') . ' #' . $i . '</h5>';
      $html .= '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
      $html .= '</div>';
      $html .= '<div class="modal-body">';

      // Hidden Field.
      $html .= '<input class="form-control mb-3" type="hidden" name="element[gallery_items][' . $i . '][fid]" value="' . ($item['fid'] ?? '') . '">';

      // Input Field with Label.
      $html .= '<div class="mb-3">';
      $html .= '<label for="galleryUrl-' . $i . '" class="form-label">Image URL</label>';
      $html .= '<input id="galleryUrl-' . $i . '" class="form-control select2-control url_autocomplete ui-autocomplete-input" type="text" name="element[gallery_items][' . $i . '][url]" value="' . ($item['url'] ?? '') . '">';
      $html .= '</div>';

      // Textarea with Label.
      $html .= '<div class="mb-3">';
      $html .= '<label for="galleryDescription-' . $i . '" class="form-label">Image Description</label>';
      $html .= '<textarea id="galleryDescription-' . $i . '" class="form-control" name="element[gallery_items][' . $i . '][description]" rows="4" placeholder="Enter a description...">' . htmlspecialchars($item['description'] ?? '') . '</textarea>';
      $html .= '</div>';

      // Hidden Node ID Field.
      $html .= '<input type="hidden" name="element[gallery_items][' . $i . '][node_id]" value="' . (!empty($value['node_id']) ? $value['node_id'] : '') . '" class="node_id" field-settings/>';
      $html .= '</div>';
      $html .= '<div class="modal-footer">';
      $html .= '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">' . $this->t('Apply') . '</button>';
      $html .= '</div>';
      $html .= '</div>';
      $html .= '</div>';
      $html .= '</div>';

      $html .= '</div>';
    }

    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';

    return $html;
  }

  /**
   * {@inheritdoc}
   */
  public function getDefaultSettings() {
    return [
      'input_type' => 'noahs_gallery',
      'placeholder' => '',
      'title' => '',
    ];
  }

}
