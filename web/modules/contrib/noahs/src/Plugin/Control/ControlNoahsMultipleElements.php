<?php

namespace Drupal\noahs_page_builder\Plugin\Control;

use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * @ControlPlugin(
 *   id = "noahs_multiple_elements",
 *   label = @Translation("Multiple Elements")
 * )
 */
class ControlNoahsMultipleElements extends ControlBase {

  use StringTranslationTrait;

  /**
   * {@inheritdoc}
   */
  public function getype() {
    return 'noahs_multiple_elements';
  }

  /**
   * {@inheritdoc}
   */
  public function contentTemplate(array $params = []) {

    $data = $params['data'] ?? NULL;
    $name = $params['name'] ?? NULL;
    $values = $params['value'] ?? NULL;
    $css_values = $data['values']['element']['css'] ?? NULL;
  
    $fields = !empty($data['item']['fields']) && is_array($data['item']['fields']) ? $data['item']['fields'] : [];

    $parent = $data['item_id'];

    $html = '
			<div class="accordion-item" data-delta="header_replace">
			<h2 class="accordion-header" id="header_replace">
				<div class="accordion-actions">
					<button type="button" class="btn btn-light noahs_page_builder-remove-item area_tooltip" title="Remove"><i class="fa-regular fa-trash-can"></i></button>
					<button type="button" class="btn btn-light noahs_page_builder-duplicate-item area_tooltip" title="Clone"><i class="fa-regular fa-copy"></i></i></button>
					<div class="btn btn-light noahs_page_builder-move-item area_tooltip" title="Move"><i class="fa-solid fa-up-down-left-right"></i></div>
				</div>
				<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#colapse_replace" aria-expanded="true" aria-controls="colapse_replace">
					Item #1
				</button>
			</h2>
			<div id="colapse_replace" class="accordion-collapse collapse" aria-labelledby="header_replace" data-bs-parent="#' . $data['item_id'] . '">
				<div class="accordion-body">';
    $newvalue['wid'] = $data['wid'];
    // $default_form = $this->modalForm->renderSubFields($fields, $newvalue, 'replace_it', $parent);
    $html .= $default_form;
    $html .= '
				</div>
			</div>
		</div>';
    $addItemHtml = $html;
    $index = 1;

    $output = '';

    $output .= '<div class="noahs_page_builder_multiple_elements">';
    $output .= '<div class="accordion" id="' . htmlspecialchars($data['item_id'], ENT_QUOTES, 'UTF-8') . '">';

    $index = 1;

    foreach ($values as $i => $value) {

      $i = str_replace('element_', '', $i);
      $value['css'] = $css_values;
      $value['wid'] = $data['wid'];
      $form = $this->modalForm->renderSubFields($fields, $value, $i, $parent);

      $output .= '<div class="accordion-item" data-delta="' . $i . '">';
      $output .= '<h2 class="accordion-header" id="header_' . $i . '">';
      $output .= '<div class="accordion-actions btn-group">';
      $output .= '<button type="button" class="btn btn-light noahs_page_builder-remove-item area_tooltip" title="Remove"><i class="fa-regular fa-trash-can"></i></button>';
      $output .= '<button type="button" class="btn btn-light noahs_page_builder-duplicate-item area_tooltip" title="Clone"><i class="fa-regular fa-copy"></i></button>';
      $output .= '<div class="btn btn-light noahs_page_builder-move-item area_tooltip" title="Move"><i class="fa-solid fa-up-down-left-right"></i></div>';
      $output .= '</div>';
      $output .= '<button type="button" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#slideshow_' . $i . '" aria-expanded="false" aria-controls="slideshow_' . $i . '">';
      $output .= 'Item #' . $index;
      $output .= '</button>';
      $output .= '</h2>';
      $output .= '<div id="slideshow_' . $i . '" class="accordion-collapse collapse" aria-labelledby="header_' . $i . '" data-bs-parent="#' . htmlspecialchars($data['item_id'], ENT_QUOTES, 'UTF-8') . '">';
      $output .= '<div class="accordion-body">';
      $output .= $form;
      $output .= '</div>';
      $output .= '</div>';
      $output .= '</div>';

      $index++;
    }

    $output .= '</div>';
    $output .= '<input type="hidden" class="update_reload_form" name="element[multiple_items_reload]">';
    $output .= '<button type="button" class="btn btn-secondary btn-labeled noahs_page_builder-add-item mt-3" data-widget-type="' . htmlspecialchars($data['item_id'], ENT_QUOTES, 'UTF-8') . '" data-html="' . htmlspecialchars($addItemHtml, ENT_QUOTES, 'UTF-8') . '">';
    $output .= '<span class="btn-label"><i class="fa-solid fa-circle-plus"></i></span>' . $this->t('Add new Item');
    $output .= '</button>';
    $output .= '</div>';

    return $output;
  }

  /**
   * {@inheritdoc}
   */
  public function getDefaultSettings() {
    return [
      'input_type' => 'noahs_multiple_elements',
      'title' => '',
    ];
  }

}
