<?php

namespace Drupal\noahs_page_builder\Plugin\Widget;

use Drupal\file\Entity\File;

/**
 * @WidgetPlugin(
 *   id = "noahs_icon",
 *   label = @Translation("Icon")
 * )
 */
class WidgetNoahsIcon extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function data() {
    return [
      'icon' => '<svg id="fi_7579050" height="512" viewBox="0 0 64 64" width="512" xmlns="http://www.w3.org/2000/svg" data-name="Line Expand"><path d="m32 1a31 31 0 0 0 0 62 1 1 0 0 0 .707-.293l30-30a1 1 0 0 0 .293-.707 31.035 31.035 0 0 0 -31-31zm-.4 54.99a24 24 0 1 1 24.39-24.39 30.864 30.864 0 0 0 -13.477 6.351l-.438-2.551 8.625-8.41a1 1 0 0 0 -.554-1.706l-11.919-1.731-5.33-10.8a1 1 0 0 0 -1.794 0l-5.33 10.8-11.917 1.731a1 1 0 0 0 -.556 1.706l8.625 8.41-2.035 11.865a1 1 0 0 0 1.451 1.054l10.659-5.604 4.182 2.2a30.827 30.827 0 0 0 -4.582 11.075zm8.412-20.774.735 4.282a31.179 31.179 0 0 0 -3.4 3.769l-4.882-2.567a1 1 0 0 0 -.93 0l-9.331 4.9 1.782-10.389a1 1 0 0 0 -.288-.885l-7.549-7.359 10.432-1.516a1 1 0 0 0 .753-.547l4.666-9.449 4.666 9.454a1 1 0 0 0 .753.547l10.432 1.516-7.551 7.359a1 1 0 0 0 -.286.885zm-6.9 24.253a29.04 29.04 0 0 1 26.357-26.352zm24.864-28.2a26 26 0 1 0 -26.707 26.712q-.192 1.477-.243 2.994a29 29 0 1 1 29.949-29.949q-1.516.05-2.994.243z"></path></svg>',
      'title' => 'Icon',
  'description' => 'Display a single icon with custom size and color.',
      'group' => 'General',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildWidgetForm(array $form) {

    
    $options = noahs_page_builder_load_blocks();

    $form['section_content'] = [
      'type' => 'tab',
      'title' => t('Content'),
    ];

    $form['icon'] = [
      'type'    => 'noahs_icon',
      'title'   => t('Icon'),
      'tab' => 'section_content',
    ];
    $form['icon_size'] = [
      'type'    => 'text',
      'title'   => t('Icon Size'),
      'placeholder'   => t('20px, 2rem, etc...'),
      'tab' => 'section_content',
      'responsive' => TRUE,
      'style_type' => 'style',
      'style_css' => 'font-size',
      'style_selector' => '.widget-wrapper i',
      'default_value' => '36px',
    ];
    $form['icon_url'] = [
      'type'    => 'noahs_url',
      'title'   => t('Url'),
      'placeholder'  => t('Url'),
      'tab' => 'section_content',
      'autocomplete' => 'url_autocomplete',
    ];

    $form['icon_target'] = [
      'type'    => 'select',
      'title'   => t('Target'),
      'tab' => 'section_content',
      'style_type'      => 'attribute',
      'style_selector'  => '.noahs-icon-link',
      'attribute_type'  => 'target',
      'options' => [
        '' => 'Opens in the same frame as it was clicked',
        '_blank' => 'Opens in a new window or tab',
        '_parent' => 'Opens in the parent frame',
        '_top' => 'Opens in the full body of the window',
        'framename' => 'Opens in the named iframe',
      ],
    ];

    $form['horizontal_align'] = [
      'type'    => 'select',
      'title'   => t('Horizontal Align'),
      'tab' => 'section_content',
      'style_type' => 'style',
      'style_selector' => '.widget-wrapper',
      'style_css' => 'justify-content',
      'default_value' => 'center',
      'responsive' => TRUE,
      'options' => [
        '' => 'Por defecto',
        'flex-start' => 'Start',
        'center' => 'Center',
        'flex-end' => 'End',
      ],
    ];

    $form['svg_group'] = [
      'type' => 'group',
      'title' => t('SVG Size'),
    ];

    $form['svg_width'] = [
      'type'    => 'text',
      'title'   => t('Width'),
      'placeholder'   => t('20px, 2rem, etc...'),
      'tab' => 'section_content',
      'group' => 'svg_group',
      'responsive' => TRUE,
      'style_type' => 'style',
      'style_css' => 'width',
      'style_selector' => '.noahs-icon-wrapper svg',
    ];

    $form['svg_height'] = [
      'type'    => 'text',
      'title'   => t('Height'),
      'placeholder'   => t('20px, 2rem, etc...'),
      'tab' => 'section_content',
      'group' => 'svg_group',
      'responsive' => TRUE,
      'style_type' => 'style',
      'style_css' => 'height',
      'style_selector' => '.noahs-icon-wrapper svg',
    ];

    // Section Styles.
    $form['section_styles'] = [
      'type' => 'tab',
      'title' => t('Styles'),
    ];

    $form['color'] = [
      'type'     => 'noahs_color',
      'title'    => ('Color'),
      'tab'     => 'section_styles',
      'style_type' => 'style',
      'style_selector' => '.widget-wrapper i',
      'style_css' => 'color',
      'style_hover' => TRUE,
    ];
    $form['svg_color'] = [
      'type'     => 'noahs_color',
      'title'    => ('SVG Color'),
      'tab'     => 'section_styles',
      'style_type' => 'style',
      'style_selector' => '.widget-wrapper svg',
      'style_css' => 'fill',
      'style_hover' => TRUE,
    ];

    $form['box_group'] = [
      'type' => 'group',
      'title' => t('Background box Size'),
    ];

    $form['box_width'] = [
      'type'    => 'text',
      'title'   => t('Width'),
      'placeholder'   => t('20px, 2rem, etc...'),
      'tab' => 'section_styles',
      'group' => 'box_group',
      'responsive' => TRUE,
      'style_type' => 'style',
      'style_css' => 'width',
      'style_selector' => '.noahs-icon-wrapper',
    ];
    $form['box_height'] = [
      'type'    => 'text',
      'title'   => t('Height'),
      'placeholder'   => t('20px, 2rem, etc...'),
      'tab' => 'section_styles',
      'group' => 'box_group',
      'responsive' => TRUE,
      'style_type' => 'style',
      'style_css' => 'height',
      'style_selector' => '.noahs-icon-wrapper',
    ];

    $form['background_color'] = [
      'type' => 'noahs_color',
      'title' => t('Background Color'),
      'tab' => 'section_styles',
      'style_type' => 'style',
      'style_selector' => '.noahs-icon-wrapper',
      'style_css' => 'background-color',
      'style_hover' => TRUE,
    ];

    $form['border'] = [
      'type' => 'noahs_border',
      'title' => t('Border'),
      'tab' => 'section_styles',
      'style_type' => 'style',
      'style_selector' => '.noahs-icon-wrapper',
      'style_css' => 'border',
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];

    $form['btn_margin'] = [
      'type' => 'noahs_margin',
      'title' => t('Margin'),
      'tab' => 'section_styles',
      'style_type' => 'style',
      'style_selector' => '.noahs-icon-wrapper',
      'style_css' => 'margin',
      'default_value' => [
        'margin_bottom' => '15px',
      ],
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];

    $form['btn_padding'] = [
      'type' => 'noahs_padding',
      'title' => t('Padding'),
      'tab' => 'section_styles',
      'style_type' => 'style',
      'style_selector' => '.noahs-icon-wrapper',
      'style_css' => 'padding',
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];

    $form['button_shadows'] = [
      'type'    => 'noahs_shadows',
      'title'   => t('Image Shadow'),
      'tab' => 'section_styles',
      'style_type' => 'style',
      'style_selector' => '.noahs-icon-wrapper',
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];
    $form['button_radius'] = [
      'type'    => 'noahs_radius',
      'title'   => t('Border Radius'),
      'tab' => 'section_styles',
      'style_type' => 'style',
      'style_selector' => '.noahs-icon-wrapper',
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];
    return $form;

  }

  /**
   * {@inheritdoc}
   */
  public function template($settings) {
    $settings = $settings->element;

    $icon = $settings->icon->class ?? 'fa-solid fa-cube';
    $url = NULL;
    $svg_content = NULL;

    if (!empty($settings->icon_url->url)) {
      $url = $settings->icon_url->url;
    }
    elseif (!empty($settings->icon_url->text)) {
      $url = $settings->icon_url->text;
    }

    if (!empty($settings->icon->fid)) {
      $file = File::load($settings->icon->fid);
      $svg_url = $file->getFileUri();
      $svg_content = file_get_contents($svg_url);
    }

    $output = '';

    if (!empty($svg_content)) {
      if (isset($url)) {
        $output .= '<a href="' . $url . '" class="noahs-icon-link noahs-icon-wrapper noahs-icon-svg d-flex justify-content-center align-items-center element-transition">' . $svg_content . '</a>';
      }
      else {
        $output .= '<div class="noahs-icon-wrapper noahs-icon-svg d-flex justify-content-center align-items-center element-transition">' . $svg_content . '</div>';
      }
    }
    else {
      if (isset($url)) {
        $output .= '<a href="' . $url . '" class="noahs-icon-link noahs-icon-wrapper d-flex justify-content-center align-items-center element-transition"><i class="' . $icon . '"></i></a>';
      }
      else {
        $output .= '<div class="noahs-icon-wrapper d-flex justify-content-center align-items-center element-transition"><i class="' . $icon . '"></i></div>';
      }
    }

    return $output;
  }

  /**
   * {@inheritdoc}
   */
  public function renderContent($element, $content = NULL) {
    return $this->wrapper($element, $this->template($element->settings));
  }

}
