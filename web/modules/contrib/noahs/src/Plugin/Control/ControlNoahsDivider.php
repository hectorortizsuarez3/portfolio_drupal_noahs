<?php

namespace Drupal\noahs_page_builder\Plugin\Control;

use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;

/**
 * @ControlPlugin(
 *   id = "noahs_divider",
 *   label = @Translation("Divider")
 * )
 */
class ControlNoahsDivider extends ControlBase implements ContainerFactoryPluginInterface {

  use StringTranslationTrait;

  /**
   * {@inheritdoc}
   */
  public function getype() {
    return 'noahs_divider';
  }

  /**
   * {@inheritdoc}
   */
  public function contentTemplate(array $params = []) {
    $data = $params['data'] ?? NULL;
    $name = $params['name'] ?? NULL;
    $value = $params['value'] ?? NULL;

    $options = [
      '' => 'None',
      'tilt' => $this->t('Tilt'),
      'waves' => $this->t('Waves'),
      'waves_2' => $this->t('Waves 2'),
      'waves_opaque' => $this->t('Waves opaque'),
      'triangles' => $this->t('Triangles'),
      'triangle' => $this->t('Triangle'),
      'triangle_invert' => $this->t('Triangle Invert'),
      'curve' => $this->t('Curve'),
      'slash' => $this->t('Slash'),
    ];

    // Initialize $value if it's not set to avoid undefined index error.
    $value['top'] = $value['top'] ?? [];
    $value['bottom'] = $value['bottom'] ?? [];

    $items = $this->list($name);

    $optionsAlign = [
      'center' => $this->t('Center'),
      'left' => $this->t('Left'),
      'right' => $this->t('Right'),
    ];

    $optionsDirection = [
      '' => 'Normal',
      'reverse' => 'Reverse',
    ];

    $output = '';

    $output .= '<ul class="nav nav-tabs noahs_page_builder-tabs" id="nav-tab-maks" role="tablist">';
    $output .= '<li class="nav-item">';
    $output .= '<button class="nav-link active" id="nav-divider-top-tab" data-bs-toggle="tab" data-bs-target="#nav-divider-top" type="button" role="tab" aria-controls="nav-divider-top" aria-selected="true">Top</button>';
    $output .= '</li>';
    $output .= '<li class="nav-item">';
    $output .= '<button class="nav-link" id="nav-divider-bottom-tab" data-bs-toggle="tab" data-bs-target="#nav-divider-bottom" type="button" role="tab" aria-controls="nav-divider-bottom" aria-selected="false">Bottom</button>';
    $output .= '</li>';
    $output .= '</ul>';

    $output .= '<div class="tab-content" id="nav-tabContent">';
    $output .= '<div class="tab-pane fade show active nohas-divider-controls" id="nav-divider-top" role="tabpanel" aria-labelledby="nav-divider-top-tab">';
    $output .= $this->generateOptionBlock($name, 'top', $value['top'], $options, $optionsDirection, $optionsAlign, $items);
    $output .= '</div>';

    $output .= '<div class="tab-pane fade nohas-divider-controls" id="nav-divider-bottom" role="tabpanel" aria-labelledby="nav-divider-bottom-tab">';
    $output .= $this->generateOptionBlock($name, 'bottom', $value['bottom'], $options, $optionsDirection, $optionsAlign, $items);
    $output .= '</div>';
    $output .= '</div>';

    return $output;
  }

  /**
   * Generate option block.
   *
   * @param string $name
   *   The name.
   * @param string $type
   *   The type.
   * @param array $value
   *   The value.
   * @param array $options
   *   The options.
   * @param array $optionsDirection
   *   The options direction.
   * @param array $optionsAlign
   *   The options align.
   * @param array $items
   *   The items.
   *
   * @return string
   *   The output.
   */
  protected function generateOptionBlock($name, $type, $value, $options, $optionsDirection, $optionsAlign, $items) {
    $output = '<div class="media-preview-actions media-preview-actions--divider overflow-auto mb-3" style="height:200px">';
    $output .= '<div class="row g-3">';
    foreach ($items as $k => $item) {
      $checked = ($item['url'] === $selected_value) ? 'checked' : '';
      $output .= '<div class="col-12">';
      $output .= '<label for="mask-' . $type . '-' . $k . '">';
      $output .= '<input type="radio" data-type="' . $type . '" id="mask-' . $type . '-' . $k . '" name="' . $name . '[' . $type . '][divider]" value="' . $item['url'] . '" ' . $checked . ' field-setting>';
      $output .= $item['content'];
      $output .= '</label>';
      $output .= '</div>';
    }
    $output .= '</div>';
    $output .= '<div class="actions">';
    $output .= '<button type="button" class="btn btn-danger media-remove_divider area_tooltip me-2" title="" data-type="' . $type . '"><i class="fa-solid fa-trash"></i></button>';
    $output .= '</div>';
    $output .= '</div>';

    $output .= '<div class="noahs-divider-styles" data-type="' . $type . '">';
    $output .= '<div class="mb-3 d-flex gap-3">';
    $output .= '<div class="field__color col">';
    $output .= '<input type="text" name="' . $name . '[' . $type . '][color]" class="form-control-color noahs-divider-color" value="' . (!empty($value['color']) ? $value['color'] : '') . '" field-settings>';
    $output .= '<label for="" class="form-label">' . $this->t('Color') . '</label>';
    $output .= '</div>';
    $output .= '<div class="col">';
    $output .= '<input type="number" name="' . $name . '[' . $type . '][width]" min="0" value="' . (!empty($value['width']) ? $value['width'] : '') . '" class="form-control noahs-divider-width" field-settings>';
    $output .= '<label for="">' . $this->t('Width') . '</label>';
    $output .= '</div>';
    $output .= '<div class="col">';
    $output .= '<input type="number" name="' . $name . '[' . $type . '][height]" value="' . (!empty($value['height']) ? $value['height'] : '') . '" class="form-control noahs-divider-height" field-settings>';
    $output .= '<label for="">' . $this->t('Height') . '</label>';
    $output .= '</div>';
    $output .= '</div>';

    $output .= '<div class="mb-3 d-flex gap-3">';
    $output .= '<div class="col">';
    $output .= '<label class="form-label">' . $this->t('Direction') . '</label>';
    $output .= '<select name="' . $name . '[' . $type . '][direction]" class="form-control form-select" field-settings="">';
    foreach ($optionsDirection as $key => $label) {
      $output .= '<option value="' . $key . '" ' . ($key == $currentDirection ? 'selected' : '') . '>' . $label . '</option>';
    }
    $output .= '</select>';
    $output .= '</div>';
    $output .= '<div class="col">';
    $output .= '<label class="form-label">' . $this->t('Align') . '</label>';
    $output .= '<select name="' . $name . '[' . $type . '][align]" class="form-control form-select" field-settings="">';
    foreach ($optionsAlign as $key => $label) {
      $output .= '<option value="' . $key . '" ' . ($key == $currentAlign ? 'selected' : '') . '>' . $label . '</option>';
    }
    $output .= '</select>';
    $output .= '</div>';
    $output .= '</div>';
    $output .= '</div>';

    return $output;
  }

  /**
   * {@inheritdoc}
   */
  public function renderControl($data) {
    return $this->base($data, $this->contentTemplate($data));
  }

  /**
   * List.
   *
   * @param string|null $name
   *   The name.
   *
   * @return array
   */
  protected function list($name = NULL) {
    $module_path = NOAHS_PAGE_BUILDER_PATH;
    $icon_folder_path = $module_path . '/assets/svg-divider-kit/';
    $files = $this->fileSystem->scanDirectory($icon_folder_path, '/\.svg$/');

    $svg_data = [];

    foreach ($files as $file) {
      $svg_path = $file->uri;
      $svg_content = file_get_contents($svg_path);
      $svg_name = pathinfo($svg_path, PATHINFO_FILENAME);
      $svg_url = '/' . $file->uri;

      $svg_data[] = [
        'name' => $svg_name,
        'url' => $svg_path,
        'content' => $svg_content,
      ];
    }

    return $svg_data;
  }

  /**
   * {@inheritdoc}
   */
  public function getDefaultSettings() {
    return [
      'input_type' => 'nohas_divider',
      'placeholder' => '',
      'title' => '',
    ];
  }

}
