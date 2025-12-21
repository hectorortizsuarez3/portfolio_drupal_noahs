<?php

namespace Drupal\noahs_page_builder\Plugin\Widget;

/**
 * @WidgetPlugin(
 *   id = "noahs_row",
 *   label = @Translation("Section"),
 * )
 */
class WidgetNoahsRow extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function data() {
    return [
      'icon' => '<svg id="fi_6938167" enable-background="new 0 0 60 60" height="512" viewBox="0 0 60 60" width="512" xmlns="http://www.w3.org/2000/svg"><path d="m6 54h48v-48h-48zm2-10h21v8h-21zm23 8v-8h21v8zm21-44v34h-44v-34z"></path></svg>',
      'title' => 'Section',
      'description' => 'New section to add columns and widgets.',
      'group' => 'General',
      'id' => 'noahs_row',
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

    $form['row_name'] = [
      'type'      => 'text',
      'title'     => t('Row Name'),
      'tab'     => 'section_content',
      'placeholder'     => t('Row Name'),
      'wrapper' => FALSE,
    ];

    $form['info_text'] = [
      'type'      => 'info',
      'tab'     => 'section_content',
      'title'     => ('Structure'),
    ];

    $form['section_container'] = [
      'type'    => 'select',
      'title'   => t('Container'),
      'tab' => 'section_content',
      'style_type' => 'class',
      'style_selector' => '> .widget-wrapper > .noahs_page_builder-row-wrapper > .noahs_page_builder-row-container',
      'wrapper' => FALSE,
      'options' => [
        'container' => t('Container'),
        'container container-small' => t('Small Container'),
        'container container-large' => t('Large Container'),
        'container container-extra-large' => t('Extra Large Container'),
        'container container-fluid' => t('Full Width'),
      ],
    ];

    $form['section_container_width'] = [
      'type'    => 'text',
      'title'   => t('Container Width'),
      'tab' => 'section_content',
      'placeholder'     => t('Custom Container Width'),
      'style_type' => 'style',
      'style_selector' => '.widget-wrapper > .noahs_page_builder-row-wrapper > .noahs_page_builder-row-container',
      'style_css' => 'max-width',
      'open' => TRUE,
      'state' => [
        'visible' => [
          'section_container' => ['value' => 'container'],
        ],
      ],
      'responsive' => TRUE,

    ];
    $form['section_grid'] = [
      'type'    => 'select',
      'title'   => t('Grid'),
      'tab' => 'section_content',
      'style_type' => 'class',
      'style_selector' => '.row-elements',
      'options' => [
        '' => t('default'),
        'row-cols-1 row-cols-md-2' => t('2 Columns'),
        'row-cols-1 row-cols-md-3' => t('3 Columns'),
        'row-cols-1 row-cols-sm-2 row-cols-md-4' => t('4 Columns'),
        'row-cols-1 row-cols-sm-2 row-cols-md-5' => t('5 Columns'),
        'row-cols-1 row-cols-sm-2 row-cols-md-6' => t('6 Columns'),
      ],
    ];

    $form['column_elements_wrap'] = [
      'type'    => 'select',
      'title'   => t('Elements wrap'),
      'tab' => 'section_content',
      'style_type' => 'style',
      'style_selector' => '.widget-wrapper > .noahs_page_builder-row-wrapper > .noahs_page_builder-row-container > .row-elements',
      'style_css' => 'flex-wrap',
      'responsive' => TRUE,
      'options' => [
        'wrap' => t('Por defecto (wrap)'),
        'nowrap' => t('No Wrap'),
      ],
    ];
    $form['section_columns_gap'] = [
      'type'    => 'text',
      'title'   => t('Columns Gap'),
      'tab' => 'section_content',
      'style_type' => 'style',
      'style_selector' => '.widget-wrapper > .noahs_page_builder-row-wrapper > .noahs_page_builder-row-container > .row-elements',
      'style_css' => 'gap',
      'responsive' => TRUE,
      'default_value' => '',
    ];

    $form['section_grid_gapy'] = [
      'type'    => 'text',
      'title'   => t('Grid gap Y'),
      'tab' => 'section_content',
      'style_type' => 'style',
      'style_selector' => '.widget-wrapper > .noahs_page_builder-row-wrapper > .noahs_page_builder-row-container > .row-elements',
      'style_css' => '--bs-gutter-y',
      'responsive' => TRUE,
      'default_value' => '',
    ];

    $form['section_grid_gapx'] = [
      'type'    => 'text',
      'title'   => t('Grid gap X'),
      'tab' => 'section_content',
      'style_type' => 'style',
      'style_selector' => '.widget-wrapper > .noahs_page_builder-row-wrapper > .noahs_page_builder-row-container > .row-elements',
      'style_css' => '--bs-gutter-x',
      'responsive' => TRUE,
      'default_value' => '',
    ];
    $form['section_height'] = [
      'type'    => 'select',
      'title'   => t('Row height'),
      'tab' => 'section_content',
      'style_type' => 'class',
      'style_selector' => 'widget',
      'options' => [
        '' => t('default'),
        'full-height' => t('Full height'),
        'min-height' => t('Min Height'),
        'max-height' => t('Max Height'),
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
      'wrapper' => FALSE,
      'responsive' => TRUE,
      'state' => [
        'visible' => [
          'section_height' => ['value' => 'min-height'],
        ],
      ],
    ];
    $form['section_max_height'] = [
      'type'    => 'text',
      'title'   => t('Max height'),
      'tab' => 'section_content',
      'placeholder'     => t('Max height'),
      'style_type' => 'style',
      'style_selector' => 'widget',
      'style_css' => 'max-height',
      'wrapper' => FALSE,
      'responsive' => TRUE,
      'state' => [
        'visible' => [
          'section_height' => ['value' => 'max-height'],
        ],
      ],
    ];
    $form['column_space'] = [
      'type'    => 'text',
      'title'   => t('Colum space'),
      'tab' => 'section_content',
      'placeholder'     => t('Column Space'),
      'style_type' => 'style',
      'style_selector' => '.row-elements',
      'style_css' => '--bs-gutter-x',
    ];

    $form['columns_position'] = [
      'type'    => 'select',
      'title'   => t('Column position'),
      'tab' => 'section_content',
      'style_type' => 'style',
      'style_selector' => 'widget',
      'style_css' => 'align-items',
      'responsive' => TRUE,
      'options' => [
        'center' => t('Center'),
        'stretch' => t('Stretch'),
        'flex-start' => t('Top'),
        'flex-end' => t('Bottom'),
      ],
    ];

    $form['columns_horizontal_align'] = [
      'type'    => 'select',
      'title'   => t('Horizontal Align'),
      'tab' => 'section_content',
      'style_type' => 'style',
      'style_selector' => '.widget-wrapper > .noahs_page_builder-row-wrapper > .noahs_page_builder-row-container > .row-elements',
      'style_css' => 'justify-content',
      'responsive' => TRUE,
      'options' => [
        'center' => 'Center',
        'flex-start' => 'Start',
        'flex-end' => 'End',
        'space-between' => 'Space Betwenn',
        'space-around' => 'Space Around',
        'space-evenly' => 'Space Evenly',
      ],
    ];

    $form['inverted_columns'] = [
      'type' => 'group',
      'tab' => 'section_content',
      'title' => t('Inverted Columns'),
    ];

    $form['columns_inverted'] = [
      'type'    => 'checkbox',
      'title'   => t('Mobile'),
      'tab' => 'section_content',
      'group' => 'inverted_columns',
      'style_type' => 'class',
      'style_selector' => '.widget-wrapper > .noahs_page_builder-row-wrapper > .noahs_page_builder-row-container > .row-elements',
      'value' => 'flex-column-reverse flex-sm-row',
      'wrapper' => FALSE,
    ];

    $form['columns_inverted_tablet'] = [
      'type'    => 'checkbox',
      'title'   => t('Tablet'),
      'tab' => 'section_content',
      'group' => 'inverted_columns',
      'style_type' => 'class',
      'style_selector' => '.widget-wrapper > .noahs_page_builder-row-wrapper > .noahs_page_builder-row-container > .row-elements',
      'value' => 'flex-column-reverse flex-md-row',
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
      'responsive' => TRUE,
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
      'description' => t('Set the speed of the parallax effect on the background image.'),
      'wrapper' => FALSE,
    ];

    $form['background_animations'] = [
      'type'    => 'select',
      'title'   => ('Background Animations'),
      'options' => [
        '' => t('None'),
        'noahs-animation--image-zoom' => t('Image zoom'),
        'noahs-animation--color-gradient' => t('Background gradient'),
        'noahs-animation--particles' => t('Background particles'),
        'noahs-animation--waves' => t('Background waves'),
      ],
      'style_selector' => 'widget',
      'style_type' => 'class',
      'tab' => 'section_styles',
      'group' => 'group_bg_animate',
      'description' => t('Set a background animation effect. Maybe you need to disable the overlay or background image to see the effect.'),
      'wrapper' => FALSE,
    ];

    $form['bg_image_overlay'] = [
      'type'     => 'noahs_background_overlay',
      'title'    => ('Background Overlay'),
      'tab'     => 'section_styles',
      'style_type' => 'style',
      'style_selector' => ':before',
    ];

    $form['bg_gradient'] = [
      'type'     => 'noahs_background_gradient',
      'title'    => ('Background Gradient'),
      'tab'     => 'section_styles',
      'style_type' => 'style',
      'style_selector' => 'widget',
      'responsive' => TRUE,
    ];

    $form['bg_divider'] = [
      'type'     => 'noahs_divider',
      'title'    => ('Divider'),
      'tab'     => 'section_styles',
      'style_type' => 'style',
      'style_selector' => 'widget',
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

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function template($settings, $content = '') {

    $twig = $this->twig;

    $element_content = $twig->render(NOAHS_PAGE_BUILDER_PATH . '/templates/widgets/noahs_row.twig', [
      'settings' => $settings,
      'content' => $content,
    ]);
    return $element_content;
  }

  /**
   * {@inheritdoc}
   */
  public function renderContent($element, $content = NULL) {
    return $this->wrapper($element, $this->template($element->settings, $content), $element);
  }

}
