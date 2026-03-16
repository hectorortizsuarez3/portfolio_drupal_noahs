<?php

namespace Drupal\miswidgets\Plugin\Widget;

use Drupal\miswidgets\Traits\TextNormalizationTrait;
use Drupal\miswidgets\Traits\HtmlNormalizationTrait;

/**
 * @WidgetPlugin(
 *   id = "miswidgets_tab",
 *   label = @Translation("Tabs")
 * )
 */
class WidgetMiswidgetsTab extends \Drupal\noahs_page_builder\Plugin\Widget\WidgetBase {
  use TextNormalizationTrait; //export function to normalize plain text values (for titles)
  use HtmlNormalizationTrait; //export function to normalize enriched text for tab content (allowing html)

  /**
   * Widget data.
   */
  public function data() {
    return [
      'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 18v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2" /><path d="M4 9h16" /><path d="M10 16l2 -2l2 2" /></svg>',
      'title' => 'Tabs',
      'description' => 'Create as many tabs as you need.',
      'group' => 'General',
    ];
  }

  /**
   * Build widget form.
   */
  public function buildWidgetForm(array $form) {

    // -------------------- Content tab --------------------
    $form['section_content'] = [
      'type' => 'tab',
      'title' => t('Content'),
    ];

    //Creation of each tab, with 2 default tabs
    $form['tabs'] = [
      'type' => 'noahs_multiple_elements',
      'title' => t('Tabs'),
      'tab' => 'section_content',
      'update_selector' => '.widget-content',
      'default_value' => [
        [
          'tab_title' => ['text' => 'Tab 1'],
          'tab_content' => ['text' => '<p>Content of tab 1</p>'],
        ],
        [
          'tab_title' => ['text' => 'Tab 2'],
          'tab_content' => ['text' => '<p>Content of tab 2</p>'],
        ],
        [
          'tab_title' => ['text' => 'Tab 3'],
          'tab_content' => ['text' => '<p>Content of tab 3</p>'],
        ],
      ],
      'fields' => [
        'tab_item' => [
          'type' => 'tab',
          'title' => t('Tab item'),
        ],
      ],
    ];

    //define the text field to edit the title on each tab
    $form['tabs']['fields']['tab_title'] = [
      'type' => 'text',
      'title' => t('Tab title'),
      'tab' => 'tab_item',
      'default_value' => 'Tab title',
      'wrapper' => FALSE,
      'translate_ai' => TRUE,
      'update_selector' => '.miswidgets-tab-nav .nav-item-[index] .nav-link',
    ];

    $form['tabs']['fields']['tab_content'] = [
      'type' => 'textarea',
      'title' => t('Tab content'),
      'tab' => 'tab_item',
      'default_value' => '<p>Your content here</p>',
      'wrapper' => FALSE,
      'translate_ai' => TRUE,
      'noahs_ai' => TRUE,
      'update_selector' => '.miswidgets-tab-content .tab-pane-[index]',
    ];
    //-----------------------------------------
    // -------------------- Styles --------------------
    //---------------------------------------------
    $form['section_styles'] = [
      'type' => 'tab',
      'title' => t('Style'),
    ];

    // Fonts
    $form['fonts_group'] = [
      'type' => 'group',
      'title' => t('Font'),
      'tab' => 'section_styles',
    ];

    $form['active_tab_font'] = [
      'type' => 'noahs_font',
      'title' => t('Active tab font'),
      'tab' => 'section_styles',
      'group' => 'fonts_group',
      'style_type' => 'style',
      'style_selector' => '.miswidgets-tab-nav .nav-link.active',
      'wrapper' => FALSE,
      'responsive' => TRUE,
    ];

    $form['non_active_tabs_font'] = [
      'type' => 'noahs_font',
      'title' => t('Non-active tabs font'),
      'tab' => 'section_styles',
      'group' => 'fonts_group',
      'style_type' => 'style',
      'style_selector' => '.miswidgets-tab-nav .nav-link:not(.active)',
      'wrapper' => FALSE,
      'responsive' => TRUE,
    ];

    $form['content_font'] = [
      'type' => 'noahs_font',
      'title' => t('Content font'),
      'tab' => 'section_styles',
      'group' => 'fonts_group',
      'style_type' => 'style',
      'style_selector' => '.widget-content .miswidgets-tab-content p',
      'wrapper' => FALSE,
      'responsive' => TRUE,
    ];

    // Alignment
    $form['alignment_group'] = [
      'type' => 'group',
      'title' => t('Alignment'),
      'tab' => 'section_styles',
    ];
  

    $form['content_align'] = [
      'type' => 'select',
      'title' => t('Content alignment'),
      'tab' => 'section_styles',
      'group' => 'alignment_group',
      'style_type' => 'style',
      'style_selector' => '.miswidgets-tab-content',
      'style_css' => 'text-align',
      'options' => [
        'left' => 'Left',
        'center' => 'Center',
        'right' => 'Right',
      ],
      'default_value' => 'left',
      'update_selector' => '.widget-content',
    ];

    $form['tabs_nav_align'] = [
      'type' => 'select',
      'title' => t('Tabs alignment'),
      'tab' => 'section_styles',
      'group' => 'alignment_group',
      'style_type' => 'style',
      'style_selector' => '.miswidgets-tab-nav',
      'style_css' => 'justify-content',
      'options' => [
        'flex-start' => 'Left',
        'center' => 'Center',
        'flex-end' => 'Right',
      ],
      'default_value' => 'flex-start',
      'update_selector' => '.widget-content',
    ];

    // Background color group
    $form['background_group'] = [
      'type' => 'group',
      'title' => t('Background color'),
      'tab' => 'section_styles',
    ];

    $form['tabs_content_background'] = [
      'type' => 'noahs_color',
      'title' => t('Content background color'),
      'tab' => 'section_styles',
      'group' => 'background_group',
      'style_type' => 'style',
      'style_selector' => '.miswidgets-tab-content .tab-pane',
      'style_css' => 'background-color',
      'style_hover' => FALSE,
    ];

    $form['tabs_nav_active_background'] = [
      'type' => 'noahs_color',
      'title' => t('Active tab background color'),
      'tab' => 'section_styles',
      'group' => 'background_group',
      'style_type' => 'style',
      'style_selector' => '.miswidgets-tab-nav .nav-link.active',
      'style_css' => 'background-color',
      'style_hover' => FALSE,
    ];

    $form['tabs_nav_background'] = [
      'type' => 'noahs_color',
      'title' => t('Non-active tabs background color'),
      'tab' => 'section_styles',
      'group' => 'background_group',
      'style_type' => 'style',
      'style_selector' => '.miswidgets-tab-nav .nav-link:not(.active)',
      'style_css' => 'background-color',
      'style_hover' => TRUE,
    ];

    $form['car_background_color'] = [
      'type' => 'noahs_color',
      'title' => t('Whole box background color'),
      'tab' => 'section_styles',
      'group' => 'background_group',
      'style_type' => 'style',
      'style_selector' => '.widget-content',
      'style_css' => 'background-color',
      'style_hover' => TRUE,
    ];

    // Borders group
    $form['borders_group'] = [
      'type' => 'group',
      'title' => t('Borders'),
      'tab' => 'section_styles',
    ];

    $form['content_border'] = [
      'type' => 'noahs_border',
      'title' => t('Content border'),
      'tab' => 'section_styles',
      'group' => 'borders_group',
      'style_type' => 'style',
      'style_selector' => '.miswidgets-tab-content .tab-pane',
      'style_css' => 'border',
      'responsive' => TRUE,
      'style_hover' => FALSE,
    ];

    $form['car_border'] = [
      'type' => 'noahs_border',
      'title' => t('Box border'),
      'tab' => 'section_styles',
      'group' => 'borders_group',
      'style_type' => 'style',
      'style_selector' => '.miswidgets-tabs',
      'style_css' => 'border',
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];

    // Radius group
    $form['radius_group'] = [
      'type' => 'group',
      'title' => t('Border radius'),
      'tab' => 'section_styles',
    ];

    $form['card_radius'] = [
      'type' => 'noahs_radius',
      'title' => t('Box border radius'),
      'tab' => 'section_styles',
      'group' => 'radius_group',
      'style_type' => 'style',
      'style_selector' => '.miswidgets-tabs',
      'responsive' => TRUE,
      'style_hover' => FALSE,
    ];

    $form['content_radius'] = [
      'type' => 'noahs_radius',
      'title' => t('Content border Radius'),
      'tab' => 'section_styles',
      'group' => 'radius_group',
      'style_type' => 'style',
      'style_selector' => '.miswidgets-tab-content .tab-pane',
      'responsive' => TRUE,
      'style_hover' => FALSE,
    ];

    $form['card_margin'] = [
      'type' => 'noahs_margin',
      'title' => t('Box margin'),
      'tab' => 'section_styles',
      'style_type' => 'style',
      'style_selector' => '.miswidgets-tabs',
      'style_css' => 'margin',
      'responsive' => TRUE,
      'style_hover' => FALSE,
    ];

    // Padding group
    $form['padding_group'] = [
      'type' => 'group',
      'title' => t('Padding'),
      'tab' => 'section_styles',
    ];

    $form['card_padding'] = [
      'type' => 'noahs_padding',
      'title' => t('Box padding'),
      'tab' => 'section_styles',
      'group' => 'padding_group',
      'style_type' => 'style',
      'style_selector' => '.miswidgets-tabs',
      'style_css' => 'padding',
      'responsive' => TRUE,
      'style_hover' => FALSE,
    ];

    $form['tabs_content_padding'] = [
      'type' => 'noahs_padding',
      'title' => t('Content padding'),
      'tab' => 'section_styles',
      'group' => 'padding_group',
      'style_type' => 'style',
      'style_selector' => '.miswidgets-tab-content .tab-pane',
      'style_css' => 'padding',
      'responsive' => TRUE,
      'style_hover' => FALSE,
    ];

    return $form;
  }

  /*
  Template render
  */
  public function template($settings) {

  $element = $settings->element ?? new \stdClass();

  $raw_tabs = $element->tabs ?? NULL;

  if (empty($raw_tabs)) {
    return '<div class="noahs-placeholder">' . t('Add tabs to display the content.') . '</div>';
  }

  // Convert stdClass to array, preserving original keys like element_0, element_1...
  $tabs_array = json_decode(json_encode($raw_tabs), TRUE);

  // Normalize text/html, remove fully empty tabs, preserve real indexes.
  $parsed_tabs = [];

  foreach ($tabs_array as $key => $tab) {
    $title = $this->normalizeText($tab['tab_title'] ?? '');
    $content = $this->normalizeHtml($tab['tab_content'] ?? '');

    // Skip totally empty tabs.
    if ($title === '' && $content === '') {
      continue;
    }

    if ($title === '') {
      $title = t('Tab');
    }

    // Keep the real index used by Noahs multiple elements.
    $real_index = is_string($key) ? str_replace('element_', '', $key) : $key;
    $real_index = preg_replace('/[^0-9]/', '', (string) $real_index);

    // Fallback in case key is not numeric after cleanup.
    if ($real_index === '') {
      $real_index = (string) count($parsed_tabs);
    }

    $parsed_tabs[] = [
      'real_index' => $real_index,
      'title' => $title,
      'content' => $content,
    ];
  }

  if (empty($parsed_tabs)) {
    return '<div class="noahs-placeholder">' . t('Fill at least one tab title or content to display the widget.') . '</div>';
  }

  // Create a unique widget ID to avoid conflicts if more than one tab widget is on the same page.
  $seed = $settings->wid
    ?? $settings->noahs_id
    ?? $element->wid
    ?? uniqid('tabs_', TRUE);

  $instance_id = 'miswidgets-tabs-' . preg_replace('/[^a-zA-Z0-9\-_]/', '-', (string) $seed);

  $output = '<div class="widget-content miswidgets-tabs">';

  // -------------------- Tabs navigation --------------------
  $output .= '<ul class="nav nav-tabs miswidgets-tab-nav" id="' . htmlspecialchars($instance_id . '-nav', ENT_QUOTES, 'UTF-8') . '" role="tablist">';

  $first_tab = TRUE;

  foreach ($parsed_tabs as $tab) {
    $real_index = $tab['real_index'];
    $is_active = $first_tab;
    $tab_btn_id = $instance_id . '-tab-' . $real_index;
    $pane_id = $instance_id . '-pane-' . $real_index;

    $output .= '<li class="nav-item nav-item-' . htmlspecialchars($real_index, ENT_QUOTES, 'UTF-8') . '" role="presentation">';
    $output .= '<button'
      . ' class="nav-link nav-link-' . htmlspecialchars($real_index, ENT_QUOTES, 'UTF-8') . ($is_active ? ' active' : '') . '"'
      . ' id="' . htmlspecialchars($tab_btn_id, ENT_QUOTES, 'UTF-8') . '"'
      . ' data-bs-toggle="tab"'
      . ' data-bs-target="#' . htmlspecialchars($pane_id, ENT_QUOTES, 'UTF-8') . '"'
      . ' type="button"'
      . ' role="tab"'
      . ' aria-controls="' . htmlspecialchars($pane_id, ENT_QUOTES, 'UTF-8') . '"'
      . ' aria-selected="' . ($is_active ? 'true' : 'false') . '">'
      . htmlspecialchars($tab['title'], ENT_QUOTES, 'UTF-8')
      . '</button>';
    $output .= '</li>';

    $first_tab = FALSE;
  }

  $output .= '</ul>';

  // -------------------- Tabs content --------------------
  $output .= '<div class="tab-content miswidgets-tab-content" id="' . htmlspecialchars($instance_id . '-content', ENT_QUOTES, 'UTF-8') . '">';

  $first_tab = TRUE;

  foreach ($parsed_tabs as $tab) {
    $real_index = $tab['real_index'];
    $is_active = $first_tab;
    $tab_btn_id = $instance_id . '-tab-' . $real_index;
    $pane_id = $instance_id . '-pane-' . $real_index;

    $output .= '<div'
      . ' class="tab-pane fade tab-pane-' . htmlspecialchars($real_index, ENT_QUOTES, 'UTF-8') . ($is_active ? ' show active' : '') . '"'
      . ' id="' . htmlspecialchars($pane_id, ENT_QUOTES, 'UTF-8') . '"'
      . ' role="tabpanel"'
      . ' aria-labelledby="' . htmlspecialchars($tab_btn_id, ENT_QUOTES, 'UTF-8') . '">';

    $output .= ($tab['content'] !== '') ? $tab['content'] : '<p>' . t('Empty tab content.') . '</p>';

    $output .= '</div>';

    $first_tab = FALSE;
  }

  $output .= '</div>';
  $output .= '</div>';

  return $output;
}
  /**
   * Render content.
   */
  public function renderContent($element, $content = NULL, $entity = null) {
    return $this->wrapper($element, $this->template($element->settings));
  }

}