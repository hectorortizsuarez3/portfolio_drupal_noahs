<?php

namespace Drupal\noahs_page_builder\Plugin\Control;

use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\file\Entity\File;

/**
 * @ControlPlugin(
 *   id = "noahs_video_upload",
 *   label = @Translation("Video Upload")
 * )
 */
class ControlNoahsVideoUpload extends ControlBase {

  use StringTranslationTrait;

  /**
   * {@inheritdoc}
   */
  public function getype() {
    return 'noahs_video_upload';
  }

  /**
   * {@inheritdoc}
   */
  public function contentTemplate(array $params = []) {
    $data = $params['data'] ?? NULL;
    $name = $params['name'] ?? NULL;
    $value = $params['value'] ?? NULL;
    $video_local_url = '/' . NOAHS_PAGE_BUILDER_PATH . '/assets/video/5772359_Coll_wavebreak_Animation_Emoji_1280x720.mp4';
    $file_name = 'video/mp4';

    if (!empty($value['fid'])) {
      $video_file = File::load($value['fid']);
      $video_file_uri = $video_file->getFileUri();
      $file_name = $video_file->filemime->value;
      $video_local_url = $this->fileUrlGenerator->generateAbsoluteString($video_file_uri);
    }

    $output = '';

    $output .= '<div class="mb-3 background-image-field">';
    $output .= '<div class="media-preview-actions d-flex justify-content-center align-items-center mb-3">';
    $output .= '<video class="noahs-video-iframe" width="100%">';
    $output .= '<source src="' . htmlspecialchars($video_local_url, ENT_QUOTES, 'UTF-8') . '" type="' . htmlspecialchars($file_name, ENT_QUOTES, 'UTF-8') . '">';
    $output .= '<p>Su navegador no soporta vídeos HTML5.</p>';
    $output .= '</video>';
    $output .= '<input type="hidden" name="' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '[fid]" id="noahs_page_builder_video" value="' . (!empty($value['fid']) ? htmlspecialchars($value['fid'], ENT_QUOTES, 'UTF-8') : '') . '" class="form-control file-fid" field-settings>';
    $output .= '<input type="hidden" name="' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '[url]" id="noahs_page_builder_video_url" value="' . (!empty($value['url']) ? htmlspecialchars($value['url'], ENT_QUOTES, 'UTF-8') : '') . '" class="form-control file-url" field-settings>';
    $output .= '<div class="btn-group position-absolute d-flex justify-content-between w-100">';
    $output .= '<button type="button" class="btn btn-primary media-upload_video area_tooltip" title="' . $this->t('Add/change Video') . '" data-element-id="noahs_page_builder_video"><i class="fa-solid fa-circle-plus"></i></button>';
    $output .= '<button type="button" class="btn btn-danger media-remove_video area_tooltip" title="' . $this->t('Remove Video') . '"><i class="fa-solid fa-trash"></i></button>';
    $output .= '</div>';
    $output .= '</div>';
    $output .= '</div>';

    return $output;
  }

  /**
   * {@inheritdoc}
   */
  public function getDefaultSettings() {
    return [
      'input_type' => 'noahs_video_upload',
      'placeholder' => '',
      'title' => '',
    ];
  }

}
