<?php

namespace Drupal\noahs_page_builder\Plugin\Control;

/**
 * @ControlPlugin(
 *   id = "noahs_video_background",
 *   label = @Translation("Video Background")
 * )
 */
class ControlNoahsVideoBackground extends ControlBase {

  /**
   * {@inheritdoc}
   */
  public function getype() {
    return 'noahs_video_background';
  }

  /**
   * {@inheritdoc}
   */
  public function contentTemplate(array $params = []) {
    $data = $params['data'] ?? NULL;
    $name = $params['name'] ?? NULL;
    $value = $params['value'] ?? NULL;

    $id = $data['wid'];

    $output = '';

    $output .= '<div class="field_element">';
    $output .= '<label for="background_option_video">' . t('Background Video URL') . '</label>';
    $output .= '<input type="text" name="' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '[url]" id="background_option_video" value="' . (!empty($value['url']) ? htmlspecialchars($value['url'], ENT_QUOTES, 'UTF-8') : '') . '" class="form-control" field-settings>';
    $output .= '</div>';

    $output .= '<div class="field_element field__color">';
    $output .= '<label for="noahs_page_builder_background_overlay">' . t('Video Overlay') . '</label>';
    $output .= '<input type="text" name="' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '[video_background_overlay]" id="noahs_page_builder_video_background_overlay" class="form-control-color-alpha" value="' . (!empty($value['video_background_overlay']) ? htmlspecialchars($value['video_background_overlay'], ENT_QUOTES, 'UTF-8') : '') . '" field-settings>';
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
