<?php

namespace Drupal\noahs_page_builder\Plugin\Control;

use Drupal\image\Entity\ImageStyle;
use Drupal\media\Entity\Media;

/**
 * @ControlPlugin(
 *   id = "noahs_carousel",
 *   label = @Translation("Carousel")
 * )
 */
class ControlNoahsCarousel extends ControlBase {

  /**
   * {@inheritdoc}
   */
  public function getype() {
    return 'noahs_carousel';
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
    $item_id = htmlspecialchars($data['item_id']);

    $html = '';

    $html .= '<div class="noahs_page_builder_carousel_field">';
    $html .= '<div id="' . $item_id . '">';
    $html .= '<div class="carousel-images-wrapper p-3 mb-3 bg-light rounded-3 row position-relative" id="carousel-images-wrapper">';

    foreach (array_values($items) as $i => $item) {
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

      $fid = htmlspecialchars($item['fid'] ?? '');
      $mediaType = htmlspecialchars($item['media_type'] ?? '');
      $url = htmlspecialchars($item['url'] ?? '');

      $html .= '<div class="col-xs-3 image-box mb-2" data-delta="' . $i . '">';
      $html .= '<div class="noahs_page_builder-edit-grid-item btn btn-sm btn-info position-absolute top-50 start-50 translate-middle rounded-circle" data-show-click="#edit-carousel-image-' . $i . '"><i class="fa-solid fa-pen-to-square"></i></div>';
      $html .= '<div class="noahs_page_builder-move-grid-item btn btn-sm btn-info position-absolute top-0 start-0 rounded-circle"><i class="fa-solid fa-arrows-up-down-left-right"></i></div>';
      $html .= '<div class="noahs_page_builder-remove-grid-item btn btn-sm btn-danger position-absolute bottom-0 end-0 rounded-circle"><i class="fa-solid fa-trash"></i></div>';
      $html .= '<img src="' . htmlspecialchars($image) . '">';
      $html .= '<div id="edit-carousel-image-' . $i . '" class="noahs_page_builder-hover-modal bg-light p-3 position-absolute top-50 start-0 translate-middle-y shadow-lg hidden w-100">';
      $html .= '<div class="btn btn-sm btn-danger position-absolute top-0 start-50 translate-middle rounded-circle" data-show-click="#edit-carousel-image-' . $i . '"><i class="fa-regular fa-circle-xmark"></i></div>';
      $html .= '<input class="form-control mb-3" type="hidden" name="element[gallery_items][' . $i . '][fid]" value="' . $fid . '">';
      $html .= '<input class="form-control mb-3" type="hidden" name="element[gallery_items][' . $i . '][media_type]" value="' . $mediaType . '">';
      $html .= '<input class="form-control" type="text" name="element[gallery_items][' . $i . '][url]" value="' . $url . '">';
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
      'input_type' => 'noahs_carousel',
      'placeholder' => '',
      'title' => '',
    ];
  }

}
