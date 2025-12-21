<?php

namespace Drupal\noahs_page_builder\Plugin\Widget;

/**
 * @WidgetPlugin(
 *   id = "noahs_separator",
 *   label = @Translation("Separator")
 * )
 */
class WidgetNoahsSeparator extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function data() {
    return [
      'icon' => '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 682.667 682.667" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g transform="matrix(6.123233995736766e-17,-1,1,6.123233995736766e-17,9.998162269592285,682.6685266494751)"><defs><clipPath id="a" clipPathUnits="userSpaceOnUse"><path d="M0 512h512V0H0Z" fill="#000000" opacity="1" data-original="#000000"></path></clipPath></defs><g clip-path="url(#a)" transform="matrix(1.33333 0 0 -1.33333 0 682.667)"><path d="M0 0c-1.902-1.903-.556-5.156 2.136-5.156h63.583c2.136 0 4.184.848 5.695 2.359l98.417 98.417a4.026 4.026 0 0 1 0 5.695l-98.417 98.417a8.054 8.054 0 0 1-5.695 2.36H2.136c-2.692 0-4.038-3.253-2.136-5.156l95.62-95.621a4.026 4.026 0 0 0 0-5.695z" style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(333.49 157.532)" fill="none" stroke="#000000" stroke-width="15" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#000000" class=""></path><path d="m0 0-37.366 37.366a4.028 4.028 0 0 0 0 5.696l98.417 98.417a8.055 8.055 0 0 0 5.695 2.359h63.583c2.692 0 4.038-3.253 2.136-5.156l-95.62-95.62a4.026 4.026 0 0 1 0-5.696l95.62-95.62c1.902-1.903.556-5.156-2.136-5.156H66.746a8.05 8.05 0 0 0-5.695 2.359L24.747-24.747" style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(46.046 215.786)" fill="none" stroke="#000000" stroke-width="15" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#000000" class=""></path><path d="M0 0v240.105a5.034 5.034 0 0 1-5.033 5.034h-44.748a5.033 5.033 0 0 1-5.033-5.034v-357.591a5.033 5.033 0 0 1 5.033-5.034h44.748A5.034 5.034 0 0 1 0-117.486V-35" style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(283.407 194.69)" fill="none" stroke="#000000" stroke-width="15" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#000000" class=""></path></g></g></svg>',
      'title' => 'Separator',
      'description' => 'Stylized separator to divide content sections.',
      'group' => 'General',
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

    $form['group_separator'] = [
      'type' => 'group',
      'title' => t('Separator'),
    ];
    $form['separator_type'] = [
      'type'      => 'select',
      'tab'     => 'section_content',
      'title'     => ('Type'),
      'group' => 'group_separator',
      'options' => [
        'line' => 'Line',
        'double_line' => 'Double Line',
        'dotted' => 'Dotted',
        'dashed' => 'Dashed',
        'line_shadow' => 'Line  + Shadow',
        'line_gradient' => 'Line Gradient',
        'curve' => 'Curve',
        'triangle' => 'Triangle',
        'slash' => 'Slash',
      ],
      'attributes' => [
        'class' => 'noahs-regenerate-design',
      ],
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
    $form['separator_width'] = [
      'type'    => 'text',
      'title'   => ('Separator Width'),
      'style_type' => 'style',
      'style_selector' => '.noahs_page_builder-separator-item',
      'style_css' => 'width',
      'tab' => 'section_content',
      'placeholder' => 'use as 10%, 100px, 100vw...',
      'group' => 'group_separator',
    ];

    $form['separator_weight'] = [
      'type'    => 'text',
      'title'   => ('Separator Weight'),
      'tab' => 'section_content',
      'placeholder' => 'use as 10%, 100px, 100vw...',
      'attributes' => [
        'data-selector' => '.noahs_page_builder-separator-item',
      ],
      'group' => 'group_separator',
    ];
    $form['separator_size'] = [
      'type'    => 'text',
      'title'   => ('Separator Size'),
      'style_type' => 'style',
      'style_selector' => '.noahs_page_builder-separator-item',
      'style_css' => '--separator-mask-size',
      'tab' => 'section_content',
      'placeholder' => 'use as 10%, 100px, 100vw...',
      'group' => 'group_separator',
    ];

    $form['separator_color'] = [
      'type'    => 'noahs_color',
      'title'   => t('Separator Color'),
      'style_type' => 'style',
      'style_selector' => '.noahs_page_builder-separator-item',
      'style_css' => '--separator-mask-color',
      'tab' => 'section_content',
      'group' => 'group_separator',
    ];

    $form['separator_text'] = [
      'type'    => 'text',
      'title'   => t('Separator Text'),
      'tab' => 'section_content',
      'group' => 'group_separator',
      'translate_ai' => TRUE,
    ];

    $form['font'] = [
      'type'        => 'noahs_font',
      'title'       => t('Font'),
      'tab'     => 'section_content',
      'style_type' => 'style',
      'style_selector' => '.noahs_page_builder-separator-item span h4',
      'responsive' => TRUE,
      'group' => 'group_separator',
    ];

    $form['separator_icon'] = [
      'type'    => 'group',
      'title'   => t('Icon Styles'),
      'tab' => 'section_content',
    ];

    $form['icon'] = [
      'type'    => 'noahs_icon',
      'title'   => t('Icon'),
      'tab' => 'section_content',
      'group' => 'separator_icon',
    ];

    $form['icon_color'] = [
      'type'    => 'noahs_color',
      'title'   => t('Icon Color'),
      'style_type' => 'style',
      'style_selector' => '.widget-content i',
      'style_css' => 'color',
      'tab' => 'section_content',
      'group' => 'separator_icon',
    ];

    $form['icon_size'] = [
      'type'    => 'text',
      'title'   => t('Icon Size'),
      'placeholder'   => t('20px, 2rem, etc...'),
      'tab' => 'section_content',
      'group' => 'icon_group',
      'responsive' => TRUE,
      'style_type' => 'style',
      'style_css' => 'font-size',
      'style_selector' => '.widget-content i',
      'group' => 'separator_icon',
    ];

    $form['separator_space'] = [
      'type'    => 'text',
      'title'   => ('Separator Space'),
      'style_type' => 'style',
      'style_selector' => '.noahs_page_builder-separator-item span',
      'style_css' => '--separator-text-padding',
      'tab' => 'section_content',
      'placeholder' => 'use as 10%, 100px, 100vw...',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public static function template($settings) {

    $settings = $settings->element;
    $class = !empty($settings->separator_type) ? $settings->separator_type : 'line';
    $style = '';
    $icon = !empty($settings->icon->class) ? '<i class="' . $settings->icon->class . '"></i>' : '';
    $title = !empty($settings->separator_text->text) ? $settings->separator_text->text : NULL;
    $weight = !empty($settings->separator_weight->text) ? $settings->separator_weight->text : '1px';

    $class .= !empty($icon) ? ' icon' : '';
    $class .= !empty($title) ? ' title' : '';

    if (!empty($settings->separator_type)) {
      switch ($settings->separator_type) {
        case 'double_line':
          break;

        case 'dotted':
          break;

        case 'dashed':
          break;

        case 'line_shadow':
          break;

        case 'line_gradient':
          break;

        case 'curve':
          $style = '--separator-pattern-url: url(\'data:image/svg+xml,%3Csvg xmlns=&quot;http://www.w3.org/2000/svg&quot; preserveAspectRatio=&quot;none&quot; overflow=&quot;visible&quot; height=&quot;100%25&quot; viewBox=&quot;0 0 24 24&quot; fill=&quot;none&quot; stroke=&quot;black&quot; stroke-width=&quot;' . $weight . '&quot; stroke-linecap=&quot;square&quot; stroke-miterlimit=&quot;10&quot;%3E%3Cpath d=&quot;M0,6c6,0,6,13,12,13S18,6,24,6&quot;/&gt;%3C/svg&gt;\');';
          break;

        case 'triangle':
          $style = '--separator-pattern-url: url(\'data:image/svg+xml,%3Csvg xmlns=&quot;http://www.w3.org/2000/svg&quot; preserveAspectRatio=&quot;none&quot; overflow=&quot;visible&quot; height=&quot;100%25&quot; viewBox=&quot;0 0 24 24&quot; fill=&quot;none&quot; stroke=&quot;black&quot; stroke-width=&quot;' . $weight . '&quot; stroke-linecap=&quot;square&quot; stroke-miterlimit=&quot;10&quot;%3E%3Cpolyline points=&quot;0,18 12,6 24,18 &quot;/&gt;%3C/svg&gt;\');';
          break;

        case 'slash':
          $style = '--separator-pattern-url: url(\'data:image/svg+xml,%3Csvg xmlns=&quot;http://www.w3.org/2000/svg&quot; preserveAspectRatio=&quot;none&quot; overflow=&quot;visible&quot; height=&quot;100%25&quot; viewBox=&quot;0 0 20 16&quot; fill=&quot;none&quot; stroke=&quot;black&quot; stroke-width=&quot;' . $weight . '&quot; stroke-linecap=&quot;square&quot; stroke-miterlimit=&quot;10&quot;%3E%3Cg transform=&quot;translate(-12.000000, 0)&quot;%3E%3Cpath d=&quot;M28,0L10,18&quot;/&gt;%3Cpath d=&quot;M18,0L0,18&quot;/&gt;%3Cpath d=&quot;M48,0L30,18&quot;/&gt;%3Cpath d=&quot;M38,0L20,18&quot;/&gt;%3C/g%3E%3C/svg&gt;\');';
          break;

        default:
          $class .= ' line';
          break;
      }

    }
    $html = '
          <div class="widget-content d-flex">
            <div class="noahs_page_builder-separator-item ' . $class . '" style="' . $style . '">
              <span>';

    if (isset($icon)) {
      $html .= $icon;
    }

    $html .= '<h4>' . $title . '</h4>
              </span>
            </div>
          </div>';

    return $html;
  }

  /**
   * {@inheritdoc}
   */
  public function renderContent($element, $content = NULL) {
    return $this->wrapper($element, $this->template($element->settings));
  }

}
