<?php

namespace Drupal\miswidgets\Plugin\Widget;

/**
 * @WidgetPlugin(
 *   id = "miswidgets_image_comparer",
 *   label = @Translation("Image Comparer")
 * )
 */
class WidgetMiswidgetsImageComparer extends \Drupal\noahs_page_builder\Plugin\Widget\WidgetBase {

  public function data() {
    return [
      'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 5a1 1 0 0 1 1 -1h14a1 1 0 0 1 1 1v14a1 1 0 0 1 -1 1h-14a1 1 0 0 1 -1 -1z" /><path d="M12 4v16" /><path d="M4 14l4 -4a3 5 0 0 1 3 0l5 5" /><path d="M14 15l1 -1a2 3 0 0 1 3 0l2 2" /></svg>',
      'title' => 'Image Comparer',
      'description' => 'Compare two images with a draggable divider.',
      'group' => 'General',
    ];
  }

  public function buildWidgetForm(array $form) {

    $form['section_content'] = [
      'type' => 'tab',
      'title' => t('Content'),
    ];

    $form['before_image'] = [
      'type' => 'image_comparer',
      'title' => t('Before image'),
      'tab' => 'section_content',
    ];

    $form['after_image'] = [
      'type' => 'image_comparer',
      'title' => t('After image'),
      'tab' => 'section_content',
    ];

    $form['before_label'] = [
      'type' => 'text',
      'title' => t('Before label'),
      'tab' => 'section_content',
      'default_value' => 'Before',
    ];

    $form['after_label'] = [
      'type' => 'text',
      'title' => t('After label'),
      'tab' => 'section_content',
      'default_value' => 'After',
    ];

    $form['comparer_alt'] = [
      'type'    => 'text',
      'title'   => t('Comparer alt text'),
      'tab' => 'section_content',
    ];
    
    $form['comparer_title'] = [
      'type'    => 'text',
      'title'   => t('Comparer title'),
      'tab' => 'section_content',
    ];

    //---------------Sección Estilos------------------

    $form['section_styles'] = [
      'type' => 'tab',
      'title' => t('Style'),
    ];

    $form['image_style'] = [
      'type' => 'group',
      'title' => t('Image styles'),
      'tab' => 'section_styles',
    ];

    $form['image_width'] = [
      'type'    => 'text',
      'title'   => t('Image Width'),
      'tab' => 'section_styles',
      'group' => 'image_style',
      'style_type' => 'style',
      'style_css' => 'width',
      'style_selector' => '.miswidgets-image-comparer',
      'responsive' => TRUE,
    ];

    $form['horizontal_align'] = [
      'type'    => 'select',
      'title'   => t('Horizontal Align'),
      'tab' => 'section_styles',
      'group' => 'image_style',
      'style_type' => 'style',
      'style_selector' => '.widget-wrapper',
      'style_css' => 'justify-content',
      'responsive' => TRUE,
      'options' => [
        '' => t('Por defecto'),
        'flex-start' => t('Left'),
        'center' => t('Center'),
        'flex-end' => t('Right'),
      ],
    ];

    $form['box_shadows'] = [
      'type'    => 'noahs_shadows',
      'title'   => t('Image Shadow'),
      'tab' => 'section_styles',
      'group' => 'image_style',
      'style_type' => 'style',
      'style_selector' => '.miswidgets-image-comparer',
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];
    $form['image_border'] = [
      'type' => 'noahs_border',
      'title' => t('Border'),
      'tab' => 'section_styles',
      'group' => 'image_style',
      'style_type' => 'style',
      'style_selector' => '.miswidgets-image-comparer',
      'style_css' => 'border',
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];
    $form['border-radius'] = [
      'type'    => 'noahs_radius',
      'title'   => t('Border Radius'),
      'tab' => 'section_styles',
      'group' => 'image_style',
      'style_type' => 'style',
      'style_selector' => '.miswidgets-image-comparer',
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];

/*--------------LABEL STYLES-------------------------------*/

    $form['label_styles'] = [
      'type' => 'group',
      'title' => t('Labels styles'),
      'tab' => 'section_styles',
    ];

    $form['labels_font'] = [
      'type' => 'noahs_font',
      'title' => t('Labels font'),
      'tab' => 'section_styles',
      'group' => 'label_styles',
      'style_type' => 'style',
      'style_selector' => '.miswidgets-image-comparer__label',
      'wrapper' => FALSE,
      'responsive' => TRUE,
    ];

    // color de fondo
    $form['labels_background'] = [
      'type' => 'noahs_color',
      'title' => t('Labels background'),
      'tab' => 'section_styles',
      'group' => 'label_styles',
      'style_type' => 'style',
      'style_selector' => '.miswidgets-image-comparer__label',
      'style_css' => 'background-color',
      'style_hover' => FALSE,
    ];

    $form['label_padding'] = [
      'type' => 'noahs_padding',
      'title' => t('Labels padding'),
      'tab' => 'section_styles',
      'group' => 'label_styles',
      'style_type' => 'style',
      'style_selector' => '.miswidgets-image-comparer__label',
      'style_css' => 'padding',
      'responsive' => TRUE,
      'style_hover' => FALSE,
    ];

    $form['label_border_radius'] = [
      'type' => 'noahs_radius',
      'title' => t('Labels border radius'),
      'tab' => 'section_styles',
      'group' => 'label_styles',
      'style_type' => 'style',
      'style_selector' => '.miswidgets-image-comparer__label',
      'responsive' => TRUE,
      'style_hover' => FALSE,
    ];

    // Label position

    $form['labels_position_group'] = [
      'type' => 'group',
      'title' => t('Labels position'),
      'tab' => 'section_styles',
    ];

    $form['label_top_margin'] = [
      'type' => 'text',
      'title' => t('Labels top margin'),
      'tab' => 'section_styles',
      'group' => 'labels_position_group',
      'style_type' => 'style',
      'style_selector' => '.miswidgets-image-comparer__label',
      'style_css' => 'top',
      'responsive' => TRUE,
      'placeholder' => '20px',
    ];

    $form['before_label_left'] = [
      'type' => 'text',
      'title' => t('Before-label left margin'),
      'tab' => 'section_styles',
      'group' => 'labels_position_group',
      'style_type' => 'style',
      'style_selector' => '.miswidgets-image-comparer__label--before',
      'style_css' => 'left',
      'responsive' => TRUE,
      'placeholder' => '20px',
    ];


    $form['after_label_right'] = [
      'type' => 'text',
      'title' => t('After-label right margin'),
      'tab' => 'section_styles',
      'group' => 'labels_position_group',
      'style_type' => 'style',
      'style_selector' => '.miswidgets-image-comparer__label--after',
      'style_css' => 'right',
      'responsive' => TRUE,
      'placeholder' => '20px',
    ];

    return $form;
  }

  public function template($settings) {
    $element = $settings->element ?? new \stdClass();

    /*
    ------1º: Generación de ids únicos y variables
    */

    //Creamos ID HTML único para usar con JS
    $seed = $settings->wid
      ?? $settings->noahs_id
      ?? $element->wid
      ?? uniqid('image_comparer_', TRUE);

      //generamos un id HTML válido y seguro, añadiendo el prefijo propio del widget
    $instance_id = 'miswidgets-image-comparer-' . preg_replace('/[^a-zA-Z0-9\-_]/', '-', (string) $seed);

    //extraemos el id interno de cada archivo (fid - file id)
    $before_mid = $element->before_image->fid ?? NULL;
    $after_mid = $element->after_image->fid ?? NULL;

    //Si hay imagen, conviertela a html, sino, deja vacío
    $before_html = $before_mid ? $this->getMediaImage($before_mid) : '';
    $after_html = $after_mid ? $this->getMediaImage($after_mid) : '';

    $before_label = $element->before_label->text ?? 'Before';
    $after_label = $element->after_label->text ?? 'After';

    /*
    ------2º: Construcción del html
    */
    $output = '<div class="widget-content miswidgets-image-comparer"'
      . ' id="' . htmlspecialchars($instance_id) . '"'
      . (!empty($element->comparer_alt->text) ? ' aria-label="' . htmlspecialchars($element->comparer_alt->text) . '"' : '')
      . (!empty($element->comparer_title->text) ? ' title="' . htmlspecialchars($element->comparer_title->text) . '"' : '')
      . '>';

    $output .= '<div class="miswidgets-image-comparer__inner">';

    // AFTER (fondo)
    $output .= '<div class="miswidgets-image-comparer__image miswidgets-image-comparer__image--after">';
    $output .= $after_html;
    $output .= '<span class="miswidgets-image-comparer__label miswidgets-image-comparer__label--after">'
      . htmlspecialchars($after_label) . '</span>';
    $output .= '</div>';

    // BEFORE (overlay con clip)
    $output .= '<div class="miswidgets-image-comparer__overlay">';
    $output .= '<div class="miswidgets-image-comparer__image miswidgets-image-comparer__image--before">';
    $output .= $before_html;
    $output .= '<span class="miswidgets-image-comparer__label miswidgets-image-comparer__label--before">'
      . htmlspecialchars($before_label) . '</span>';
    $output .= '</div></div>';

    // Separador que el usuario arrastra
    $output .= '<div class="miswidgets-image-comparer__divider">';
    $output .= '<span class="miswidgets-image-comparer__handle"></span>';
    $output .= '</div>';

    $output .= '</div></div>';

    return $output;
  }

  public function renderContent($element, $content = NULL, $entity = NULL) {
    return $this->wrapper($element, $this->template($element->settings));
  }
}