<?php

namespace Drupal\noahs_page_builder\Plugin\Widget;

/**
 * @WidgetPlugin(
 *   id = "noahs_drupal_title",
 *   label = @Translation("Drupal title")
 * )
 */
class WidgetNoahsDrupalNodeTitle extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function data() {
    return [
      'icon' => '<i class="fa-solid fa-font"></i>',
      'title' => 'Drupal Page Title',
  'description' => 'Display the current Drupal page title.',
      'group' => 'Drupal',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildWidgetForm(array $form) {

    // Section Content.
    $form['section_content'] = [
      'type' => 'tab',
      'title' => t('Content'),
    ];

    $form['heading_type'] = [
      'type'      => 'select',
      'tab'     => 'section_content',
      'title'     => ('Type'),
      'options' => [
        'h1' => 'H1',
        'h2' => 'H2',
        'h3' => 'H3',
        'h4' => 'H4',
        'h5' => 'H5',
        'h6' => 'H6',
      ],
      'update_selector_html' => '.widget-content > *',
      'open' => 'show',

    ];

    $form['horizontal_align'] = [
      'type'    => 'select',
      'title'   => t('Horizontal Align'),
      'tab' => 'section_content',
      'style_type' => 'style',
      'style_selector' => '.widget-content',
      'style_css' => 'justify-content',
      'responsive' => TRUE,
      'options' => [
        '' => 'Por defecto',
        'flex-start' => 'Start',
        'center' => 'Center',
        'flex-end' => 'End',
        'space-between' => 'Space Betwenn',
        'space-around' => 'Space Around',
        'space-evenly' => 'Space Evenly',
      ],
    ];
    $form['menu_text_align'] = [
      'type'    => 'select',
      'title'   => t('Text Align'),
      'tab' => 'section_content',
      'style_type' => 'style',
      'style_selector' => '.widget-content',
      'style_css' => 'text-align',
      'responsive' => TRUE,
      'options' => [
        '' => 'Default',
        'left' => 'Left',
        'center' => 'Center',
        'right' => 'Right',
      ],
    ];
    $form['section_style'] = [
      'type' => 'tab',
      'title' => t('Style'),
    ];

    $form['font'] = [
      'type'        => 'noahs_font',
      'title'       => t('Font'),
      'tab'     => 'section_style',
      'style_type' => 'style',
      'style_selector' => 'widget',
      'responsive' => TRUE,
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function template($settings) {

    $settings = $settings->element;
    $request = $this->requestStack->getCurrentRequest();
    $route = $this->routeMatch->getRouteObject();
    $title = $this->titleResolver->getTitle($request, $route);

    $ouput = '';
    $ouput .= '<div class="widget-content d-flex w-100">';
    $ouput .= '<' . ($settings->heading_type ?? 'h1') . '>';
    $ouput .= '<span>' . $title . '</span>';
    $ouput .= '</' . ($settings->heading_type ?? 'h1') . '>';
    $ouput .= '</div>';

    return $ouput;
  }

  /**
   * {@inheritdoc}
   */
  public function renderContent($element, $content = NULL) {
    return $this->wrapper($element, $this->template($element->settings));
  }

}
