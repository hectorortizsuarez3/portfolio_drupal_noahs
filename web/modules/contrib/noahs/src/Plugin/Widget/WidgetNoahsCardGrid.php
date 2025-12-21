<?php

namespace Drupal\noahs_page_builder\Plugin\Widget;

use Drupal\file\Entity\File;

/**
 * @WidgetPlugin(
 *   id = "noahs_card_grid",
 *   label = @Translation("Cards Grid")
 * )
 */
class WidgetNoahsCardGrid extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function data() {
    return [
      'icon' => '<svg height="682pt" viewBox="-21 -90 682.66669 682" width="682pt" xmlns="http://www.w3.org/2000/svg" id="fi_1700577"><path d="m625.625 50.75h-70v-40.625c0-7.925781-6.449219-14.375-14.375-14.375h-341.152344c-5.179687 0-9.375 4.1992188-9.375 9.375 0 5.175781 4.195313 9.375 9.375 9.375h336.777344v271.203125c0 5.175781 4.199219 9.375 9.375 9.375s9.375-4.199219 9.375-9.375v-216.203125h65.625v331.25h-181.25v-36.25h101.25c7.925781 0 14.375-6.449219 14.375-14.375v-23.011719c0-5.175781-4.199219-9.375-9.375-9.375s-9.375 4.199219-9.375 9.375v18.636719h-433.75v-331.25h56.585938c5.175781 0 9.375-4.199219 9.375-9.375 0-5.1757812-4.199219-9.375-9.375-9.375h-60.960938c-7.925781 0-14.375 6.449219-14.375 14.375v40.625h-70c-7.925781 0-14.375 6.449219-14.375 14.375v340c0 7.925781 6.449219 14.375 14.375 14.375h25.335938c5.175781 0 9.375-4.199219 9.375-9.375s-4.199219-9.375-9.375-9.375h-20.960938v-331.25h65.625v280.625c0 7.925781 6.449219 14.375 14.375 14.375h101.25v36.25h-119.902344c-5.179687 0-9.375 4.199219-9.375 9.375s4.195313 9.375 9.375 9.375h124.277344c7.925781 0 14.375-6.449219 14.375-14.375v-40.625h202.5v40.625c0 7.925781 6.449219 14.375 14.375 14.375h190c7.925781 0 14.375-6.449219 14.375-14.375v-340c0-7.925781-6.449219-14.375-14.375-14.375zm0 0"></path><path d="m127.835938 243.273438c0 15.515624 12.617187 28.125 28.125 28.125h328.023437c15.507813 0 28.125-12.609376 28.125-28.125 0-15.507813-12.617187-28.125-28.125-28.125h-22.324219l-58.085937-80.535157c-3.511719-4.867187-9.191407-7.769531-15.183594-7.769531-6 0-11.675781 2.90625-15.191406 7.773438l-22.167969 30.734374-52.550781-72.085937c-3.632813-4.980469-9.488281-7.960937-15.652344-7.960937-6.167969 0-12.015625 2.980468-15.65625 7.960937l-88.855469 121.890625h-22.347656c-15.515625-.007812-28.132812 12.609375-28.132812 28.117188zm365.519531 0c0 5.171874-4.207031 9.375-9.375 9.375h-328.019531c-5.164063 0-9.375-4.203126-9.375-9.375 0-5.164063 4.210937-9.375 9.375-9.375h328.023437c5.164063 0 9.371094 4.210937 9.371094 9.375zm-104.988281-97.6875 50.179687 69.5625h-51.207031l-24.691406-33.859376zm-106.042969-41.269532c.058593-.085937.183593-.261718.503906-.261718.316406 0 .4375.175781.496094.261718l80.808593 110.832032h-44.21875c-.050781 0-.101562 0-.148437 0h-118.246094zm0 0"></path><path d="m245 433.25c-15.507812 0-28.125 12.617188-28.125 28.125s12.617188 28.125 28.125 28.125 28.125-12.617188 28.125-28.125-12.617188-28.125-28.125-28.125zm0 37.5c-5.171875 0-9.375-4.203125-9.375-9.375s4.203125-9.375 9.375-9.375 9.375 4.203125 9.375 9.375-4.203125 9.375-9.375 9.375zm0 0"></path><path d="m395 433.25c-15.507812 0-28.125 12.617188-28.125 28.125s12.617188 28.125 28.125 28.125 28.125-12.617188 28.125-28.125-12.617188-28.125-28.125-28.125zm0 37.5c-5.171875 0-9.375-4.203125-9.375-9.375s4.203125-9.375 9.375-9.375 9.375 4.203125 9.375 9.375-4.203125 9.375-9.375 9.375zm0 0"></path><path d="m320 425.75c-19.644531 0-35.625 15.980469-35.625 35.625s15.980469 35.625 35.625 35.625 35.625-15.980469 35.625-35.625-15.980469-35.625-35.625-35.625zm0 52.5c-9.304688 0-16.875-7.566406-16.875-16.875 0-9.304688 7.570312-16.875 16.875-16.875s16.875 7.570312 16.875 16.875c0 9.308594-7.570312 16.875-16.875 16.875zm0 0"></path></svg>',
      'title' => 'Cards Grid',
  'description' => 'Grid layout for multiple content cards.',
      'group' => 'General',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildWidgetForm(array $form) {
    
    $image_styles = $this->getImageStyles();
    // Section Content.
    $form['section_content'] = [
      'type' => 'tab',
      'title' => t('Content'),
    ];
    $form['slideshow_items'] = [
      'type'    => 'noahs_multiple_elements',
      'title'   => t('Cards Items'),
      'tab' => 'section_content',
      'default_value' => [
        [
          'single_slideshow_icon' => [
            'class' => null,
          ],
          'slideshow_title' => [
            'text' => 'Card Title 1',
          ],
          'slideshow_text' => [
            'text' => 'In nulla justo, fermentum sit amet fermentum quis, facilisis vitae enim',
          ],
        ],
        [
          'single_slideshow_icon' => [
            'class' => null,
          ],
          'slideshow_title' => [
            'text' => 'Card Title 2',
          ],
          'slideshow_text' => [
            'text' => 'In nulla justo, fermentum sit amet fermentum quis, facilisis vitae enim',
          ],
        ],
        [
          'single_slideshow_icon' => [
            'class' => null,
          ],
          'slideshow_title' => [
            'text' => 'Card Title 3',
          ],
          'slideshow_text' => [
            'text' => 'In nulla justo, fermentum sit amet fermentum quis, facilisis vitae enim',
          ],
        ],
        [
          'single_slideshow_icon' => [
            'class' => null,
          ],
          'slideshow_title' => [
            'text' => 'Card Title 4',
          ],
          'slideshow_text' => [
            'text' => 'In nulla justo, fermentum sit amet fermentum quis, facilisis vitae enim',
          ],
        ],
      ],
      'fields' => [
        'slideshow_content' => [
          'type' => 'tab',
          'title' => t('Card Content'),
        ],
        'single_slideshow_icon' => [
          'type'    => 'noahs_icon',
          'title'   => t('Icon'),
          'tab' => 'slideshow_content',
          'update_selector' => '.multipart-item_element_[index] .noahs_page_builder-cards-grid--icon',
        ],
        'card_image' => [
          'type'    => 'noahs_image',
          'title'   => t('Image'),
          'tab' => 'slideshow_content',
          'update_selector' => '.multipart-item_element_[index] .noahs_page_builder-cards-grid--img',
        ],
        'slideshow_title' => [
          'title' => t('Title'),
          'type' => 'text',
          'placeholder' => t('This is a h4'),
          'tab' => 'slideshow_content',
          'default_value' => 'This is a h4',
          'wrapper'  => FALSE,
          'update_selector' => '.multipart-item_element_[index] .noahs_page_builder-cards-grid--title',
          'translate_ai' => TRUE,
          'textarea' => TRUE,
        ],
        'slideshow_text' => [
          'title' => t('Text'),
          'type' => 'text',
          'placeholder' => 'This is a p',
          'default_value' => 'In nulla justo, fermentum sit amet fermentum quis, facilisis vitae enim',
          'tab' => 'slideshow_content',
          'wrapper'  => FALSE,
          'update_selector' => '.multipart-item_element_[index] .noahs_page_builder-cards-grid--text',
          'translate_ai' => TRUE,
        ],
        'button_title' => [
          'type' => 'text',
          'title' => t('Button Title'),
          'tab' => 'slideshow_content',
          'placeholder' => 'Title',
          'update_selector' => '.btn > span',
          'wrapper' => FALSE,
          'translate_ai' => TRUE,
        ],
        'slideshow_url' => [
          'title' => t('Url'),
          'type' => 'noahs_url',
          'tab' => 'slideshow_content',
          'autocomplete' => 'url_autocomplete',
          'placeholder' => t('Intertal/External URL'),
          'description' => t('If external use https://'),
        ],

        'content_text_align' => [
          'type'    => 'select',
          'title'   => t('Text Align'),
          'tab' => 'slideshow_content',
          'style_type' => 'style',
          'style_selector' => '.multipart-item_element_[index] .noahs_page_builder-cards-grid--content',
          'style_css' => 'text-align',
          'wrapper' => FALSE,
          'options' => [
            'center' => t('Center'),
            'left' => t('Left'),
            'right' => t('Right'),
          ],
        ],

           // Indivildual styles.
        'slideshow_styles' => [
          'type' => 'tab',
          'title' => t('Indivildual Style'),
        ],

        'individual_box_bgcolor' => [
          'type' => 'noahs_color',
          'title' => t('Box Background Color'),
          'tab' => 'slideshow_styles',
          'style_type' => 'style',
          'style_selector' => '.multipart-item_element_[index] .noahs_page_builder-cards-grid--wrapper',
          'style_css' => 'background-color',
          'style_hover' => TRUE,
          'responsive' => TRUE,
        ],

        'individual_box_color' => [
          'type' => 'noahs_color',
          'title' => t('Box Color'),
          'tab' => 'slideshow_styles',
          'style_type' => 'style',
          'style_selector' => '.multipart-item_element_[index] .noahs_page_builder-cards-grid--wrapper',
          'style_css' => 'color',
          'style_hover' => TRUE,
        ],

        'individual_icon_color' => [
          'type' => 'noahs_color',
          'title' => t('Icon Color'),
          'tab' => 'slideshow_styles',
          'style_type' => 'style',
          'style_selector' => '.multipart-item_element_[index] .noahs-icon-wrapper i',
          'style_css' => 'color',
          'style_hover' => TRUE,
        ],

        'individual_btn_background_color' => [
          'type' => 'noahs_color',
          'title' => t('Button Background Color'),
          'tab' => 'slideshow_styles',
          'style_type' => 'style',
          'style_selector' => '.multipart-item_element_[index] .btn',
          'style_css' => 'background-color',
          'style_hover' => TRUE,
        ],

      ],
    ];

    $form['svg_icon_as_url'] = [
      'type'    => 'checkbox',
      'title'   => t('SVG as url'),
      'tab' => 'section_content',
      'value' => TRUE,
      'default_value' => FALSE,
      'attributes' => [
        'class' => 'noahs-regenerate-design',
      ],
    ];

    $form['remove_icon'] = [
      'type'    => 'checkbox',
      'title'   => t('Remove all icons'),
      'tab' => 'section_content',
      'value' => TRUE,
      'default_value' => FALSE,
      'attributes' => [
        'class' => 'noahs-regenerate-design',
      ],
    ];

    $form['carousel_type'] = [
      'type'    => 'select',
      'title'   => t('Type'),
      'tab' => 'section_content',
      'wrapper'  => FALSE,
      'default_value' => 'grid',
      'options' => [
        'grid' => t('Grid'),
        'slide' => t('Slide'),
        'flipped' => t('Flip'),
        'overlay' => t('Overlay'),
      ],
      'attributes' => [
        'class' => 'noahs-regenerate-design',
      ],
    ];
    $form['carousel_type_grid'] = [
      'type'    => 'select',
      'title'   => t('Type'),
      'tab' => 'section_content',
      'wrapper'  => FALSE, 
      'default_value' => 'Vertical',
      'options' => [
        'vertical' => t('Vertical'),
        'horizontal' => t('Horizontal')
      ],
      'attributes' => [
        'class' => 'noahs-regenerate-design',
      ],
      'status' => [
        'visible' => [
          'carousel_type' => ['value' => 'grid'],
        ],
      ],
    ];

    $form['carousel_grid_columns'] = [
      'type'    => 'select',
      'title'   => t('Grid Columns'),
      'tab' => 'section_content',
      'wrapper'  => FALSE,
      'default_value' => 'row-cols-1 row-cols-sm-2 row-cols-md-4',
      'options' => [
        'row-cols-1 row-cols-sm-2' => '2',
        'row-cols-1 row-cols-sm-2 row-cols-md-3' => '3',
        'row-cols-1 row-cols-sm-2 row-cols-md-4' => '4',
        'row-cols-1 row-cols-sm-2 row-cols-md-5' => '5',
        'row-cols-1 row-cols-sm-2 row-cols-md-6' => '6',
      ],
      'state' => [
        'visible' => [
          'carousel_type' => ['value' => ['grid', 'flipped', 'overlay']],
        ],
      ],
      'attributes' => [
        'class' => 'noahs-regenerate-design',
      ],
    ];
    $form['section_grid_gapy'] = [
      'type'    => 'text',
      'title'   => t('Grid gap Y'),
      'tab' => 'section_content',
      'style_type' => 'style',
      'style_selector' => '.cards-grid > .row',
      'style_css' => '--bs-gutter-y',
      'responsive' => TRUE,
      'state' => [
        'visible' => [
          'carousel_type' => ['value' => ['grid', 'flipped', 'overlay']],
        ],
      ],
    ];
    
    $form['section_grid_gapx'] = [
      'type'    => 'text',
      'title'   => t('Grid gap X'),
      'tab' => 'section_content',
      'style_type' => 'style',
      'style_selector' => '.cards-grid > .row',
      'style_css' => '--bs-gutter-x',
      'responsive' => TRUE,
      'state' => [
        'visible' => [
          'carousel_type' => ['value' => ['grid', 'flipped', 'overlay']],
        ],
      ],
    ];

    $form['group_item_show'] = [
      'type' => 'group',
      'tab'     => 'section_styles',
      'title' => t('Items to show'),
      'state' => [
        'visible' => [
          'carousel_type' => ['value' => 'slide'],
        ],
      ],
    ];

    $form['carousel_type_columns'] = [
      'type'    => 'select',
      'title'   => t('Show Elements (Desktop)'),
      'tab' => 'section_content',
      'group' => 'group_item_show',
      'style_type'      => 'attribute',
      'style_selector'  => '.noahs_page_builder-cards-grid',
      'attribute_type'  => 'data-show-items-desktop',
      'wrapper'  => FALSE,
      'options' => [
        '' => 'Default',
        '1' => '1',
        '2' => '2',
        '3' => '3',
        '4' => '4',
        '5' => '5',
        '6' => '6',
        '7' => '7',
        '8' => '8',
        '9' => '9',
        '10' => '10',
      ],
    ];

    $form['carousel_type_columns_tablet'] = [
      'type'    => 'select',
      'title'   => t('Show Elements (Tablet)'),
      'tab' => 'section_content',
      'group' => 'group_item_show',
      'style_type'      => 'attribute',
      'style_selector'  => '.noahs_page_builder-cards-grid',
      'attribute_type'  => 'data-show-items-tablet',
      'wrapper'  => FALSE,
      'options' => [
        '' => 'Default',
        '1' => '1',
        '2' => '2',
        '3' => '3',
        '4' => '4',
        '5' => '5',
        '6' => '6',
        '7' => '7',
        '8' => '8',
        '9' => '9',
        '10' => '10',
      ],

    ];

    $form['carousel_type_columns_mobile'] = [
      'type'    => 'select',
      'title'   => t('Show Elements (Mobile)'),
      'tab' => 'section_content',
      'group' => 'group_item_show',
      'style_type'      => 'attribute',
      'style_selector'  => '.noahs_page_builder-cards-grid',
      'attribute_type'  => 'data-show-items-mobile',
      'wrapper'  => FALSE,
      'options' => [
        '' => 'Default',
        '1' => '1',
        '2' => '2',
        '3' => '3',
        '4' => '4',
        '5' => '5',
        '6' => '6',
        '7' => '7',
        '8' => '8',
        '9' => '9',
        '10' => '10',
      ],
    ];

    $form['carousel_space'] = [
      'type'    => 'number',
      'title'   => t('Items Space'),
      'tab' => 'section_content',
      'style_type'      => 'attribute',
      'style_selector'  => '.noahs_page_builder-cards-grid',
      'attribute_type'  => 'data-space',
      'default_value' => '20px',
    ];
    $form['card_content_text_align'] = [
      'type'    => 'select',
      'title'   => t('Text Align'),
      'tab' => 'section_content',
      'style_type' => 'style',
      'style_selector' => '.noahs_page_builder-cards-grid--wrapper .noahs_page_builder-cards-grid--content',
      'style_css' => 'text-align',
      'wrapper' => FALSE,
      'options' => [
        '' => t('Default'),
        'center' => t('Center'),
        'left' => t('Left'),
        'right' => t('Right'),
      ],
    ];

    $form['slideshow_content_width'] = [
      'type'    => 'text',
      'title'   => t('Content Width'),
      'tab' => 'section_content',
      'placeholder'     => t('Width'),
      'style_type' => 'style',
      'style_selector' => '.noahs_page_builder-cards-grid--content',
      'style_css' => 'max-width',
      'default_value' => '',
    ];

    $form['horizontal_align'] = [
      'type'    => 'select',
      'title'   => t('Horizontal Align'),
      'tab' => 'section_content',
      'style_type' => 'style',
      'style_selector' => '.cards-grid > .row',
      'style_css' => 'justify-content',
      'responsive' => TRUE,
      'options' => [
        'center' => t('Center'),
        'flex-start' => t('Start'),
        'flex-end' => t('End'),
      ],
    ];

    $form['section_styles'] = [
      'type' => 'tab',
      'title' => t('Styles'),
    ];

    $form['image_height'] = [
      'type'    => 'text',
      'title'   => t('Image wrapper height'),
      'placeholder'   => t('20px, 2rem, etc...'),
      'tab' => 'section_styles',
      'responsive' => TRUE,
      'style_type' => 'style',
      'style_css' => 'min-height',
      'style_selector' => '.noahs_page_builder-cards-grid--img',
    ];
    $form['image_margin'] = [
      'type' => 'noahs_margin',
      'title' => t('Image Margin'),
      'tab' => 'section_styles',
      'style_type' => 'style',
      'style_selector' => '.noahs_page_builder-cards-grid--img',
      'style_css' => 'margin',
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];

    $form['heading_font'] = [
      'type'        => 'noahs_font',
      'title'       => t('Heading Font'),
      'tab'     => 'section_styles',
      'style_type' => 'style',
      'style_selector' => '.noahs_page_builder-cards-grid--title',
      'responsive' => TRUE,
    ];

    $form['text_font'] = [
      'type'        => 'noahs_font',
      'title'       => t('Text Font'),
      'tab'     => 'section_styles',
      'style_type' => 'style',
      'style_selector' => '.noahs_page_builder-cards-grid--text',
      'responsive' => TRUE,
    ];

    $form['group_bullet'] = [
      'type' => 'group',
      'tab'     => 'section_styles',
      'title' => t('Pagination'),
    ];

    $form['pagination_background_color'] = [
      'type' => 'noahs_color',
      'title' => t('Background Color'),
      'tab' => 'section_styles',
      'style_type' => 'style',
      'style_selector' => '.swiper-pagination-bullet',
      'style_css' => 'background-color',
      'style_hover' => TRUE,
      'responsive' => TRUE,
      'group' => 'group_bullet',
    ];

    $form['pagination_active_background_color'] = [
      'type' => 'noahs_color',
      'title' => t('Active Background Color'),
      'tab' => 'section_styles',
      'style_type' => 'style',
      'style_selector' => '.swiper-pagination-bullet.swiper-pagination-bullet-active',
      'style_css' => 'background-color',
      'style_hover' => TRUE,
      'responsive' => TRUE,
      'group' => 'group_bullet',
    ];

    $form['box_group'] = [
      'type' => 'group',
      'title' => t('Card box settings'),
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
      'style_selector' => '.noahs_page_builder-cards-grid--wrapper',
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
      'style_selector' => '.noahs_page_builder-cards-grid--wrapper',
    ];

    $form['box_background_color'] = [
      'type' => 'noahs_color',
      'title' => t('Background Color'),
      'tab' => 'section_styles',
      'group' => 'box_group',
      'style_type' => 'style',
      'style_selector' => '.noahs_page_builder-cards-grid--wrapper',
      'style_css' => 'background-color',
      'style_hover' => TRUE,
    ];

    $form['box_border'] = [
      'type' => 'noahs_border',
      'title' => t('Border'),
      'tab' => 'section_styles',
      'group' => 'box_group',
      'style_type' => 'style',
      'style_selector' => '.noahs_page_builder-cards-grid--wrapper',
      'style_css' => 'border',
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];

    $form['box_margin'] = [
      'type' => 'noahs_margin',
      'title' => t('Margin'),
      'tab' => 'section_styles',
      'group' => 'box_group',
      'style_type' => 'style',
      'style_selector' => '.noahs_page_builder-cards-grid--wrapper',
      'style_css' => 'margin',
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];

    $form['box_padding'] = [
      'type' => 'noahs_padding',
      'title' => t('Padding'),
      'tab' => 'section_styles',
      'group' => 'box_group',
      'style_type' => 'style',
      'style_selector' => '.noahs_page_builder-cards-grid--wrapper',
      'style_css' => 'padding',
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];

    $form['box_shadows'] = [
      'type'    => 'noahs_shadows',
      'title'   => t('Image Shadow'),
      'tab' => 'section_styles',
      'group' => 'box_group',
      'style_type' => 'style',
      'style_selector' => '.noahs_page_builder-cards-grid--wrapper',
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];
    $form['box_border_radius'] = [
      'type'    => 'noahs_radius',
      'title'   => t('Border Radius'),
      'tab' => 'section_styles',
      'group' => 'box_group',
      'style_type' => 'style',
      'style_selector' => '.noahs_page_builder-cards-grid--wrapper',
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];

    $form['content_box_group'] = [
      'type' => 'group',
      'title' => t('Content box settings'),
    ];

    $form['content_box_width'] = [
      'type'    => 'text',
      'title'   => t('Width'),
      'placeholder'   => t('20px, 2rem, etc...'),
      'tab' => 'section_styles',
      'group' => 'content_box_group',
      'responsive' => TRUE,
      'style_type' => 'style',
      'style_css' => 'width',
      'style_selector' => '.noahs_page_builder-cards-grid--bottom',
    ];

    $form['content_box_height'] = [
      'type'    => 'text',
      'title'   => t('Height'),
      'placeholder'   => t('20px, 2rem, etc...'),
      'tab' => 'section_styles',
      'group' => 'content_box_group',
      'responsive' => TRUE,
      'style_type' => 'style',
      'style_css' => 'height',
      'style_selector' => '.noahs_page_builder-cards-grid--bottom',
    ];

    $form['content_box_background_color'] = [
      'type' => 'noahs_color',
      'title' => t('Background Color'),
      'tab' => 'section_styles',
      'group' => 'content_box_group',
      'style_type' => 'style',
      'style_selector' => '.noahs_page_builder-cards-grid--bottom',
      'style_css' => 'background-color',
      'style_hover' => TRUE,
    ];

    $form['content_box_border'] = [
      'type' => 'noahs_border',
      'title' => t('Border'),
      'tab' => 'section_styles',
      'group' => 'content_box_group',
      'style_type' => 'style',
      'style_selector' => '.noahs_page_builder-cards-grid--bottom',
      'style_css' => 'border',
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];

    $form['content_box_margin'] = [
      'type' => 'noahs_margin',
      'title' => t('Margin'),
      'tab' => 'section_styles',
      'group' => 'content_box_group',
      'style_type' => 'style',
      'style_selector' => '.noahs_page_builder-cards-grid--bottom',
      'style_css' => 'margin',
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];

    $form['content_box_padding'] = [
      'type' => 'noahs_padding',
      'title' => t('Padding'),
      'tab' => 'section_styles',
      'group' => 'content_box_group',
      'style_type' => 'style',
      'style_selector' => '.noahs_page_builder-cards-grid--bottom',
      'style_css' => 'padding',
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];

    $form['content_box_shadows'] = [
      'type'    => 'noahs_shadows',
      'title'   => t('Image Shadow'),
      'tab' => 'section_styles',
      'group' => 'content_box_group',
      'style_type' => 'style',
      'style_selector' => '.noahs_page_builder-cards-grid--bottom',
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];
    $form['content_box_border_radius'] = [
      'type'    => 'noahs_radius',
      'title'   => t('Border Radius'),
      'tab' => 'section_styles',
      'group' => 'content_box_group',
      'style_type' => 'style',
      'style_selector' => '.noahs_page_builder-cards-grid--bottom',
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];

    $form['icon_box_group'] = [
      'type' => 'group',
      'title' => t('Icon box settings'),
    ];

    $form['icon_class_color'] = [
      'type' => 'noahs_color',
      'title' => t('Icon class color'),
      'tab' => 'section_styles',
      'style_type' => 'style',
      'style_selector' => '.noahs-icon-wrapper i',
      'style_css' => 'color',
      'style_hover' => TRUE,
      'group' => 'icon_box_group',
    ];

    $form['icon_size'] = [
      'type'    => 'text',
      'title'   => t('Icon size'),
      'placeholder'   => t('20px, 2rem, etc...'),
      'tab' => 'section_styles',
      'group' => 'icon_box_group',
      'responsive' => TRUE,
      'style_type' => 'style',
      'style_css' => 'font-size',
      'style_selector' => '.noahs-icon-wrapper i',
    ];

    $form['icon_box_width'] = [
      'type'    => 'text',
      'title'   => t('Width'),
      'placeholder'   => t('20px, 2rem, etc...'),
      'tab' => 'section_styles',
      'group' => 'icon_box_group',
      'responsive' => TRUE,
      'style_type' => 'style',
      'style_css' => 'width',
      'style_selector' => '.noahs-icon-wrapper',
    ];

    $form['icon_box_height'] = [
      'type'    => 'text',
      'title'   => t('Height'),
      'placeholder'   => t('20px, 2rem, etc...'),
      'tab' => 'section_styles',
      'group' => 'icon_box_group',
      'responsive' => TRUE,
      'style_type' => 'style',
      'style_css' => 'height',
      'style_selector' => '.noahs-icon-wrapper',
    ];

    $form['icon_box_background_color'] = [
      'type' => 'noahs_color',
      'title' => t('Background Color'),
      'tab' => 'section_styles',
      'group' => 'icon_box_group',
      'style_type' => 'style',
      'style_selector' => '.noahs-icon-wrapper',
      'style_css' => 'background-color',
      'style_hover' => TRUE,
    ];

    $form['icon_box_border'] = [
      'type' => 'noahs_border',
      'title' => t('Border'),
      'tab' => 'section_styles',
      'group' => 'icon_box_group',
      'style_type' => 'style',
      'style_selector' => '.noahs-icon-wrapper',
      'style_css' => 'border',
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];

    $form['icon_box_margin'] = [
      'type' => 'noahs_margin',
      'title' => t('Margin'),
      'tab' => 'section_styles',
      'group' => 'icon_box_group',
      'style_type' => 'style',
      'style_selector' => '.noahs-icon-wrapper',
      'style_css' => 'margin',
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];

    $form['icon_box_padding'] = [
      'type' => 'noahs_padding',
      'title' => t('Padding'),
      'tab' => 'section_styles',
      'group' => 'icon_box_group',
      'style_type' => 'style',
      'style_selector' => '.noahs-icon-wrapper',
      'style_css' => 'padding',
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];

    $form['icon_box_shadows'] = [
      'type'    => 'noahs_shadows',
      'title'   => t('Shadow'),
      'tab' => 'section_styles',
      'group' => 'icon_box_group',
      'style_type' => 'style',
      'style_selector' => '.noahs-icon-wrapper',
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];
    $form['icon_box_border_radius'] = [
      'type'    => 'noahs_radius',
      'title'   => t('Border Radius'),
      'tab' => 'section_styles',
      'group' => 'icon_box_group',
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

    $elements = !empty($settings->element->slideshow_items) ? $settings->element->slideshow_items : [];
    $settings = $settings->element;

    $html = '<div class="noahs-services-slide-container w-100 ' . $settings->carousel_type . '">';

    if ($settings->carousel_type === 'grid'  || $settings->carousel_type === 'flipped' || $settings->carousel_type === 'overlay') {
      $html = '<div class="noahs-services-slide-container px-0 w-100">';
      $html .= '<div class="cards-grid noahs_page_builder-cards-grid">';
      $cols = !empty($settings->carousel_grid_columns) ? $settings->carousel_grid_columns : 'row-cols-4';

      $html .= '<div class="multipart-item row ' . $cols . '">';
    }
    if ($settings->carousel_type === 'slide') {
      $html .= '<div class="swiper noahs_elements_carousel noahs_page_builder-cards-grid">';
      $html .= '<div class="swiper-wrapper multipart-item">';
    }
    $svg_url = !empty($settings->svg_icon_as_url) ? TRUE : FALSE;

    if (!empty($elements)) {
      $index = 0;

      foreach ($elements as $k => $element) {

        $icon = $element->single_slideshow_icon->class ?? 'fa-solid fa-check';
        $url = NULL;
        $svg_content = NULL;
        $image = NULL;
        $style = NULL;

        if (!empty($element->card_image->image_style)) {
          $style = $element->card_image->image_style;
        }

        if (!empty($element->card_image->token_media)) {
          $token_service = $this->token;
          $token = $element->card_image->token_media;
          $route_match = $this->routeMatch;

          $node = $route_match->getParameter('node');
          if (!empty($node)) {
            $image = $token_service->replace($token, [
              $node->getEntityTypeId() => $node,
            ]);
          }
        }

        $mid = !empty($element->card_image->fid) ? $element->card_image->fid : NULL;

        if (!empty($element->single_slideshow_icon->fid)) {
          $file = File::load($element->single_slideshow_icon->fid);
          if ($file) {
            $svg_url = $file->getFileUri();
            if ($svg_url) {
              $svg_local_url = $this->fileUrlGenerator->generateAbsoluteString($file->getFileUri());
              $svg_content = '<img src="' . $svg_local_url . '">';
            }
            else {
              $svg_content = file_get_contents($svg_url);
            }
          }
        }

        if (!empty($element->slideshow_url->node_id)) {
          $url = $this->aliasManager->getAliasByPath('/node/' . $element->slideshow_url->node_id);
        }
        elseif (!empty($element->slideshow_url->text)) {
          $url = $element->slideshow_url->text;
        }

        if (!empty($element->single_slideshow_image->token_media)) {
          $token_service = $this->token;
          $token = $element->single_slideshow_image->token_media;
          $route_match = $this->routeMatch;
          $node = $route_match->getParameter('node');
          if (!empty($node)) {
            $image = $token_service->replace($token, [
              $node->getEntityTypeId() => $node,
            ]);
          }
        }
        if ($settings->carousel_type === 'grid') {
          $html .= '<div class="grid col multipart-item_' . $k . '">';
        }
        if ($settings->carousel_type === 'flipped') {
          $html .= '<div class="grid grid-cart-flip col multipart-item_' . $k . '">';
        }
        if ($settings->carousel_type === 'overlay') {
          $html .= '<div class="grid grid-cart-overlay col multipart-item_' . $k . '">';
        }
        if ($settings->carousel_type === 'slide') {
          $html .= '<div class="swiper-slide swiper-slide_' . $k . ' multipart-item_' . $k . '">';
        }

        $html .= '<div class="noahs_page_builder-cards-grid--wrapper">
                     <div class="noahs_page_builder-cards-grid--container">
                        <div class="noahs_page_builder-cards-grid--content">
                        <div class="noahs_page_builder-cards-grid--box">
                        <div class="noahs_page_builder-cards-grid--top">';

        if (empty($settings->remove_icon)) {
          if (!empty($svg_content)) {
            $html .= '<div class="noahs-icon-wrapper noahs-icon-svg d-flex justify-content-center align-items-center element-transition">' . $svg_content . '</div>';
          }
          else {
            $html .= '<div class="noahs-icon-wrapper d-flex justify-content-center align-items-center element-transition"><i class="' . $icon . '"></i></div>';
          }
        }
        if (!empty($mid)) {
          $html .= '<div class="noahs_page_builder-cards-grid--img">' . $this->getMediaImage($mid, $style) . '</div>';
        }

        if (!empty($element->slideshow_title->text)) {
          $html .= '<h4 class="noahs_page_builder-cards-grid--title">' . $element->slideshow_title->text . '</h4>';
        }
        $html .= '</div>';
        $html .= '<div class="noahs_page_builder-cards-grid--bottom">';
        if (!empty($element->slideshow_text->text)) {

          if (!empty($svg_content)) {
            $html .= '<div class="noahs-icon-wrapper noahs-icon-svg justify-content-center align-items-center hidden">' . $svg_content . '</div>';
          }
          elseif (!empty($icon)) {
            $html .= '<div class="noahs-icon-wrapper justify-content-center align-items-center hidden"><i class="' . $icon . '"></i></div>';
          }

          $html .= '<h4 class="title-2 hidden">' . $element->slideshow_title->text . '</h4>';
          $html .= '<p class="noahs_page_builder-cards-grid--text">' . $element->slideshow_text->text . '</p>';

        }
        if (!empty($url)) {
          $html .= '<div class="btn-container mt-4">
            <a class="btn btn-link btn-link-grid-card" href="' . $url . '">
              <span>' . (!empty($element->button_title->text) ? $element->button_title->text : t('Read more')) . '</span>
            </a>
          </div>';
        }

        $html .= '</div>';
        $html .= '</div>';
        $html .= '
                     </div>
                     </div>
                  </div>
            </div>';

        $index++;
      }
    }

    $html .= '</div>';

    if ($settings->carousel_type === 'slide') {
      $html .= '<div class="swiper-pagination"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>';
    }
    $html .= '</div>
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
