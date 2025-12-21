<?php

namespace Drupal\noahs_page_builder\Plugin\Widget;

/**
 * @WidgetPlugin(
 *   id = "noahs_column",
 *   label = @Translation("Column")
 * )
 */
class WidgetNoahsColumn extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function data() {
    return [
      'icon' => 'icon-column',
      'title' => 'Column',
  'description' => 'Column container for layout and responsive design.',
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

    $form['column_width'] = [
      'type'    => 'noahs_width',
      'title'   => ('Colum Width'),
      'style_type' => 'style',
      'style_selector' => 'widget',
      'style_css' => 'width',
      'tab' => 'section_content',
      'responsive' => TRUE,
      'placeholder' => 'use as 10%, 100px, 100vw...',
      'wrapper' => FALSE,
      'open' => TRUE,
      'slide' => TRUE,
      'units' => [],
    ];
    $form['innver_column_width'] = [
      'type'    => 'noahs_width',
      'title'   => ('Inner Width'),
      'style_type' => 'style',
      'style_selector' => '.widget-wrapper',
      'style_css' => 'max-width',
      'tab' => 'section_content',
      'responsive' => TRUE,
      'placeholder' => 'use as 10%, 100px, 100vw...',
    ];
    $form['section_height'] = [
      'type'    => 'select',
      'title'   => t('Column height'),
      'tab' => 'section_content',
      'style_type' => 'class',
      'style_selector' => 'widget',
      'options' => [
        '' => t('default'),
        'full-height' => t('Full height'),
        'min-height' => t('Min Height'),
      ],
    ];
    $form['section_min_height'] = [
      'type'    => 'text',
      'title'   => t('Min height'),
      'tab' => 'section_content',
      'placeholder'     => t('Min height'),
      'style_type' => 'style',
      'style_selector' => 'widget',
      'style_css' => 'min-height',
      'responsive' => TRUE,
      'state' => [
        'visible' => [
          'section_height' => ['value' => 'min-height'],
        ],
      ],
    ];

    $form['column_elements_inline'] = [
      'type'    => 'select',
      'title'   => t('Elements orientation'),
      'tab' => 'section_content',
      'style_type' => 'style',
      'style_selector' => '.noahs_page_builder-column--content-inner',
      'style_css' => 'flex-direction',
      'responsive' => TRUE,
      'options' => [
        'column' => 'Por defecto (one under the other)',
        'column-reverse' => t('Column Reverse'),
        'row' => t('Inline'),
        'row-reverse' => t('Inline Reverse'),
        'revert' => t('Revert'),
        'unset' => t('Unset'),
      ],
    ];

    $form['elements_align'] = [
      'type'    => 'select',
      'title'   => t('Elements Align'),
      'tab' => 'section_content',
      'style_type' => 'style',
      'style_selector' => '.noahs_page_builder-column--content-inner',
      'style_css' => 'justify-content',
      'responsive' => TRUE,
      'options' => [
        '' => t('Por defecto'),
        'flex-start' => t('Start'),
        'flex-end' => t('End'),
        'space-between' => t('Space Betwenn'),
        'space-around' => t('Space Around'),
        'space-evenly' => t('Space Evenly'),
      ],
    ];

    $form['column_elements_wrap'] = [
      'type'    => 'select',
      'title'   => t('Elements wrap'),
      'tab' => 'section_content',
      'style_type' => 'style',
      'style_selector' => '.noahs_page_builder-column--content-inner',
      'style_css' => 'flex-wrap',
      'responsive' => TRUE,
      'options' => [
        'nowrap' => t('By default (no wrap)'),
        'wrap' => t('Wrap'),
      ],
    ];

    $form['horizontal_align'] = [
      'type'    => 'select',
      'title'   => t('Horizontal Align'),
      'tab' => 'section_content',
      'style_type' => 'style',
      'style_selector' => 'widget',
      'style_css' => 'text-align',
      'responsive' => TRUE,
      'options' => [
        '' => 'Por defecto',
        'left' => 'Left',
        'center' => 'Center',
        'right' => 'Right',
      ],
    ];

    $form['elements_gap'] = [
      'type'    => 'text',
      'title'   => ('Element Space'),
      'style_type' => 'style',
      'style_selector' => '.noahs_page_builder-column--content-inner ',
      'style_css' => 'gap',
      'tab' => 'section_content',
      'responsive' => TRUE,
      'placeholder' => 'use as 10%, 100px, 100vw...',
    ];
    
    $form['elements_order'] = [
      'type'    => 'text',
      'title'   => ('Order'),
      'style_type' => 'style',
      'style_selector' => 'widget',
      'style_css' => 'order',
      'tab' => 'section_content',
      'responsive' => TRUE,
      'wrapper' => FALSE,
    ];

    // Section Styles.
    $form['section_styles'] = [
      'type' => 'tab',
      'title' => t('Styles'),
    ];
    $form['bg_color'] = [
      'type'     => 'noahs_color',
      'title'    => ('Background Color'),
      'tab'     => 'section_styles',
      'style_type' => 'style',
      'style_css' => 'background-color',
      'style_selector' => 'widget',
    ];

    $form['bg_image'] = [
      'type'     => 'noahs_background_image',
      'title'    => ('Background Image'),
      'tab'     => 'section_styles',
      'style_type' => 'style',
      'style_selector' => 'widget',
      'style_hover' => TRUE,
      'responsive' => TRUE,
    ];
    $form['bg_image_overlay'] = [
      'type'     => 'noahs_background_overlay',
      'title'    => ('Background Overlay'),
      'tab'     => 'section_styles',
      'style_type' => 'style',
      'style_selector' => ':before',
    ];
    $form['group_bg_animate'] = [
      'type' => 'group',
      'tab' => 'section_styles',
      'title' => t('Background Animate'),
    ];

    $form['background_parallax'] = [
      'type'    => 'number',
      'title'   => ('Parallax'),
      'style_selector' => 'widget',
      'style_type' => 'attribute',
      'attribute_type' => 'data-background-parallax',
      'tab' => 'section_styles',
      'group' => 'group_bg_animate',
      'wrapper' => FALSE,
    ];

    $form['bg_gradient'] = [
      'type'     => 'noahs_background_gradient',
      'title'    => ('Background Gradient'),
      'tab'     => 'section_styles',
      'style_type' => 'style',
      'style_selector' => 'widget',
      'responsive' => TRUE,
    ];
    
    $form['video_background'] = [
      'type'     => 'noahs_video_background',
      'title'    => ('Video Background'),
      'tab'     => 'section_styles',
      'style_type' => 'style',
      'style_selector' => '.noahs-video-overlay',
      'append' => 'widget',
      'description' => t('This can`t be previewed in the editor some times'),
    ];

    $form['font'] = [
      'type'        => 'noahs_font',
      'title'       => t('Font'),
      'tab'     => 'section_styles',
      'style_type' => 'style',
      'style_selector' => 'widget',
      'responsive' => TRUE,
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function template($settings, $content = '') {

    $twig = $this->twig;
    $element_content = $twig->render(NOAHS_PAGE_BUILDER_PATH . '/templates/widgets/noahs_column.twig', [
      'settings' => $settings,
      'content' => $content,
    ]);

    return $element_content;

  }

  /**
   * {@inheritdoc}
   */
  public function renderContent($element, $content = NULL) {
    return $this->wrapper($element, $this->template($element, $content), $element);
  }

}
