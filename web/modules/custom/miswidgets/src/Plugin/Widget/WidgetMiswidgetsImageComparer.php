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
      'icon' => '<svg xmlns="http://www.w3.org/2000/svg"...></svg>',
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
      'type' => 'noahs_image',
      'title' => t('Before image'),
      'tab' => 'section_content',
    ];

    $form['after_image'] = [
      'type' => 'noahs_image',
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

    $form['start_position'] = [
      'type' => 'number',
      'title' => t('Initial divider position (%)'),
      'tab' => 'section_content',
      'default_value' => 50,
    ];

    return $form;
  }

  public function template($settings) {
    $element = $settings->element ?? new \stdClass();

    $start_position = isset($element->start_position->text)
      ? (int) $element->start_position->text
      : 50;

    $start_position = max(0, min(100, $start_position));

    $seed = $settings->wid
      ?? $settings->noahs_id
      ?? $element->wid
      ?? uniqid('image_comparer_', TRUE);

    $instance_id = 'miswidgets-image-comparer-' . preg_replace('/[^a-zA-Z0-9\-_]/', '-', (string) $seed);

    $before_mid = $element->before_image->fid ?? NULL;
    $after_mid = $element->after_image->fid ?? NULL;

    $before_html = $before_mid ? $this->getMediaImage($before_mid) : '';
    $after_html = $after_mid ? $this->getMediaImage($after_mid) : '';

    $before_label = $element->before_label->text ?? 'Before';
    $after_label = $element->after_label->text ?? 'After';

    $output = '<div class="widget-content miswidgets-image-comparer"'
      . ' id="' . htmlspecialchars($instance_id) . '"'
      . ' data-start-position="' . $start_position . '"'
      . ' style="--miswidgets-compare-position:' . $start_position . '%;">';

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

    // DIVIDER
    $output .= '<div class="miswidgets-image-comparer__divider" tabindex="0">';
    $output .= '<span class="miswidgets-image-comparer__handle"></span>';
    $output .= '</div>';

    $output .= '</div></div>';

    return $output;
  }

  public function renderContent($element, $content = NULL, $entity = NULL) {
    return $this->wrapper($element, $this->template($element->settings));
  }
}