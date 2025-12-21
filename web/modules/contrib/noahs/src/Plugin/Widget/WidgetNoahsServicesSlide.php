<?php

namespace Drupal\noahs_page_builder\Plugin\Widget;

use Drupal\file\Entity\File;
use Drupal\image\Entity\ImageStyle;
use Drupal\media\Entity\Media;

/**
 * @WidgetPlugin(
 *   id = "noahs_services_slide",
 *   label = @Translation("Services Slide")
 * )
 */
class WidgetNoahsServicesSlide extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function data() {
    return [
      'icon' => '<svg height="682pt" viewBox="-21 -90 682.66669 682" width="682pt" xmlns="http://www.w3.org/2000/svg" id="fi_1700577"><path d="m625.625 50.75h-70v-40.625c0-7.925781-6.449219-14.375-14.375-14.375h-341.152344c-5.179687 0-9.375 4.1992188-9.375 9.375 0 5.175781 4.195313 9.375 9.375 9.375h336.777344v271.203125c0 5.175781 4.199219 9.375 9.375 9.375s9.375-4.199219 9.375-9.375v-216.203125h65.625v331.25h-181.25v-36.25h101.25c7.925781 0 14.375-6.449219 14.375-14.375v-23.011719c0-5.175781-4.199219-9.375-9.375-9.375s-9.375 4.199219-9.375 9.375v18.636719h-433.75v-331.25h56.585938c5.175781 0 9.375-4.199219 9.375-9.375 0-5.1757812-4.199219-9.375-9.375-9.375h-60.960938c-7.925781 0-14.375 6.449219-14.375 14.375v40.625h-70c-7.925781 0-14.375 6.449219-14.375 14.375v340c0 7.925781 6.449219 14.375 14.375 14.375h25.335938c5.175781 0 9.375-4.199219 9.375-9.375s-4.199219-9.375-9.375-9.375h-20.960938v-331.25h65.625v280.625c0 7.925781 6.449219 14.375 14.375 14.375h101.25v36.25h-119.902344c-5.179687 0-9.375 4.199219-9.375 9.375s4.195313 9.375 9.375 9.375h124.277344c7.925781 0 14.375-6.449219 14.375-14.375v-40.625h202.5v40.625c0 7.925781 6.449219 14.375 14.375 14.375h190c7.925781 0 14.375-6.449219 14.375-14.375v-340c0-7.925781-6.449219-14.375-14.375-14.375zm0 0"></path><path d="m127.835938 243.273438c0 15.515624 12.617187 28.125 28.125 28.125h328.023437c15.507813 0 28.125-12.609376 28.125-28.125 0-15.507813-12.617187-28.125-28.125-28.125h-22.324219l-58.085937-80.535157c-3.511719-4.867187-9.191407-7.769531-15.183594-7.769531-6 0-11.675781 2.90625-15.191406 7.773438l-22.167969 30.734374-52.550781-72.085937c-3.632813-4.980469-9.488281-7.960937-15.652344-7.960937-6.167969 0-12.015625 2.980468-15.65625 7.960937l-88.855469 121.890625h-22.347656c-15.515625-.007812-28.132812 12.609375-28.132812 28.117188zm365.519531 0c0 5.171874-4.207031 9.375-9.375 9.375h-328.019531c-5.164063 0-9.375-4.203126-9.375-9.375 0-5.164063 4.210937-9.375 9.375-9.375h328.023437c5.164063 0 9.371094 4.210937 9.371094 9.375zm-104.988281-97.6875 50.179687 69.5625h-51.207031l-24.691406-33.859376zm-106.042969-41.269532c.058593-.085937.183593-.261718.503906-.261718.316406 0 .4375.175781.496094.261718l80.808593 110.832032h-44.21875c-.050781 0-.101562 0-.148437 0h-118.246094zm0 0"></path><path d="m245 433.25c-15.507812 0-28.125 12.617188-28.125 28.125s12.617188 28.125 28.125 28.125 28.125-12.617188 28.125-28.125-12.617188-28.125-28.125-28.125zm0 37.5c-5.171875 0-9.375-4.203125-9.375-9.375s4.203125-9.375 9.375-9.375 9.375 4.203125 9.375 9.375-4.203125 9.375-9.375 9.375zm0 0"></path><path d="m395 433.25c-15.507812 0-28.125 12.617188-28.125 28.125s12.617188 28.125 28.125 28.125 28.125-12.617188 28.125-28.125-12.617188-28.125-28.125-28.125zm0 37.5c-5.171875 0-9.375-4.203125-9.375-9.375s4.203125-9.375 9.375-9.375 9.375 4.203125 9.375 9.375-4.203125 9.375-9.375 9.375zm0 0"></path><path d="m320 425.75c-19.644531 0-35.625 15.980469-35.625 35.625s15.980469 35.625 35.625 35.625 35.625-15.980469 35.625-35.625-15.980469-35.625-35.625-35.625zm0 52.5c-9.304688 0-16.875-7.566406-16.875-16.875 0-9.304688 7.570312-16.875 16.875-16.875s16.875 7.570312 16.875 16.875c0 9.308594-7.570312 16.875-16.875 16.875zm0 0"></path></svg>',
      'title' => 'Slideshow Services',
      'description' => 'Slideshow of services with icons and images.',
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
      'title'   => t('Slideshow Items'),
      'tab' => 'section_content',
      'default_items' => 6,
      'fields' => [
        'slideshow_content' => [
          'type' => 'tab',
          'title' => t('Slide Content'),
        ],
        'single_slideshow_icon' => [
          'type'    => 'noahs_icon',
          'title'   => ('Icon'),
          'tab' => 'slideshow_content',
          'update_selector' => '.multipart-item_[index] .noahs-icon-wrapper',
        ],
        'single_slideshow_image' => [
          'type'    => 'noahs_image',
          'title'   => ('Image'),
          'tab' => 'slideshow_content',
          'update_selector' => '.multipart-item_[index] .gallery-image-src',
        ],
        'slideshow_title' => [
          'title' => 'Title',
          'type' => 'text',
          'placeholder' => 'This is a h2',
          'tab' => 'slideshow_content',
          'default_value' => 'This is a h2',
          'update_selector' => '.multipart-item_[index] .noahs_page_builder-slideshow-services--title',
          'translate_ai' => TRUE,
        ],

        'slideshow_url' => [
          'title' => 'Url',
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
          'style_selector' => '.multipart-item_[index] .noahs_page_builder-slideshow-services--content',
          'style_css' => 'text-align',
          'wrapper' => FALSE,
          'options' => [
            'center' => 'Center',
            'left' => 'Left',
            'right' => 'Right',
          ],
        ],

           // Indivildual styles.
        'slideshow_styles' => [
          'type' => 'tab',
          'title' => t('Indivildual Style'),
        ],

        'individual_btn_background_color' => [
          'type' => 'noahs_color',
          'title' => t('Button Background Color'),
          'tab' => 'slideshow_styles',
          'style_type' => 'style',
          'style_selector' => '.multipart-item_[index] .btn',
          'style_css' => 'background-color',
          'style_hover' => TRUE,
        ],

      ],
    ];
    $form['gallery_image_style'] = [
      'type'    => 'select',
      'title'   => t('Image Style'),
      'tab' => 'section_content',
      'options' => $image_styles,
      'attributes' => [
        'class' => 'noahs-regenerate-design',
      ],
    ];
    $form['group_item_show'] = [
      'type' => 'group',
      'tab'     => 'section_styles',
      'title' => t('Items to show'),
    ];

    $form['carousel_type_columns'] = [
      'type'    => 'select',
      'title'   => t('Show Elements (Desktop)'),
      'tab' => 'section_content',
      'group' => 'group_item_show',
      'style_type'      => 'attribute',
      'style_selector'  => '.noahs_page_builder-slideshow-services',
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
      'style_selector'  => '.noahs_page_builder-slideshow-services',
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
      'style_selector'  => '.noahs_page_builder-slideshow-services',
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
      'style_selector'  => '.noahs_page_builder-slideshow-services',
      'attribute_type'  => 'data-space',
      'default_value' => '20px',
    ];
    $form['slideshow_container'] = [
      'type'    => 'text',
      'title'   => t('Container Width'),
      'tab' => 'section_content',
      'placeholder'     => t('Width'),
      'style_type' => 'style',
      'style_selector' => '.noahs_page_builder-slideshow-services--container',
      'style_css' => 'max-width',
      'default_value' => '650px',
    ];
    $form['slideshow_content_width'] = [
      'type'    => 'text',
      'title'   => t('Content Width'),
      'tab' => 'section_content',
      'placeholder'     => t('Width'),
      'style_type' => 'style',
      'style_selector' => '.noahs_page_builder-slideshow-services--content',
      'style_css' => 'max-width',
      'default_value' => '650px',
    ];

    $form['horizontal_align'] = [
      'type'    => 'select',
      'title'   => t('Horizontal Align'),
      'tab' => 'section_content',
      'style_type' => 'style',
      'style_selector' => '.noahs_page_builder-slideshow-services--container',
      'style_css' => 'justify-content',
      'responsive' => TRUE,
      'options' => [
        'center' => 'Center',
        'flex-start' => 'Start',
        'flex-end' => 'End',
      ],
    ];

    $form['section_styles'] = [
      'type' => 'tab',
      'title' => t('Styles'),
    ];

    $form['heading_font'] = [
      'type'        => 'noahs_font',
      'title'       => t('Heading Font'),
      'tab'     => 'section_styles',
      'style_type' => 'style',
      'style_selector' => '.noahs_page_builder-slideshow-services--title',
      'responsive' => TRUE,
    ];

    $form['svg_group'] = [
      'type' => 'group',
      'title' => t('Icon styles'),
      'tab'     => 'section_styles',
    ];

    $form['color'] = [
      'type'     => 'noahs_color',
      'title'    => ('Icon class color'),
      'tab'     => 'section_styles',
      'group' => 'svg_group',
      'style_type' => 'style',
      'style_selector' => '.widget-wrapper i',
      'style_css' => 'color',
      'style_hover' => TRUE,
    ];

    $form['svg_color'] = [
      'type'     => 'noahs_color',
      'title'    => ('SVG color'),
      'tab'     => 'section_styles',
      'group' => 'svg_group',
      'style_type' => 'style',
      'style_selector' => '.widget-wrapper svg',
      'style_css' => 'fill',
      'style_hover' => TRUE,
    ];
    $form['svg_width'] = [
      'type'    => 'text',
      'title'   => t('Width'),
      'placeholder'   => t('20px, 2rem, etc...'),
      'tab' => 'section_styles',
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
      'tab' => 'section_styles',
      'group' => 'svg_group',
      'responsive' => TRUE,
      'style_type' => 'style',
      'style_css' => 'height',
      'style_selector' => '.noahs-icon-wrapper svg',
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
      'style_selector' => '.noahs_page_builder-slideshow-services--box',
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
      'style_selector' => '.noahs_page_builder-slideshow-services--box',
    ];

    $form['box_background_color'] = [
      'type' => 'noahs_color',
      'title' => t('Background Color'),
      'tab' => 'section_styles',
      'group' => 'box_group',
      'style_type' => 'style',
      'style_selector' => '.noahs_page_builder-slideshow-services--box',
      'style_css' => 'background-color',
      'style_hover' => TRUE,
    ];

    $form['box_border'] = [
      'type' => 'noahs_border',
      'title' => t('Border'),
      'tab' => 'section_styles',
      'group' => 'box_group',
      'style_type' => 'style',
      'style_selector' => '.noahs_page_builder-slideshow-services--box',
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
      'style_selector' => '.noahs_page_builder-slideshow-services--box',
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
      'style_selector' => '.noahs_page_builder-slideshow-services--box',
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
      'style_selector' => '.noahs_page_builder-slideshow-services--box',
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];
    $form['box_border_radius'] = [
      'type'    => 'noahs_radius',
      'title'   => t('Border Radius'),
      'tab' => 'section_styles',
      'group' => 'box_group',
      'style_type' => 'style',
      'style_selector' => '.noahs_page_builder-slideshow-services--box',
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];

    $form['icon_box_group'] = [
      'type' => 'group',
      'title' => t('Background box Size'),
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
      'title'   => t('Image Shadow'),
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

    $html = '<div class="noahs-services-slide-container w-100"><div class="swiper noahs_page_builder-slideshow-services">
        <div class="swiper-wrapper multipart-item">';
    $image = '/' . NOAHS_PAGE_BUILDER_PATH . '/assets/img/widget-image.jpg';
    $thumbnail_image = '/' . NOAHS_PAGE_BUILDER_PATH . '/assets/img/widget-image.jpg';
    $thumbnails_image_style_general = !empty($settings->element->gallery_image_style) ? $settings->element->gallery_image_style : 'noahs_800_600';

    if (!empty($elements)) {
      $index = 0;

      foreach ($elements as $element) {

        $thumbnails_image_style = !empty($element->single_slideshow_image->image_style) ? $element->single_slideshow_image->image_style : $thumbnails_image_style_general;
        $thumbnails_image_style = ($thumbnails_image_style === 'original') ? $thumbnails_image_style_general : $thumbnails_image_style;
        $icon = !empty($element->single_slideshow_icon->class) ? $element->single_slideshow_icon->class : 'fa-solid fa-check';
        $svg_content = NULL;

        if (!empty($element->single_slideshow_icon->fid)) {
          $file = File::load($element->single_slideshow_icon->fid);
          $svg_url = $file->getFileUri();
          $svg_content = file_get_contents($svg_url);
        }

        $url = !empty($element->slideshow_url->url) ? $element->slideshow_url->url : '';
        if (!empty($element->slideshow_url->text) && filter_var($element->slideshow_url->text, FILTER_VALIDATE_URL)) {
          $url = $element->slideshow_url->text;
        }
        if (!empty($element->slideshow_url->node_id)) {
          $url = $this->aliasManager->getAliasByPath('/node/' . $element->slideshow_url->node_id);
        }

        // Single Image.
        $image = NULL;
        if (!empty($element->single_slideshow_image->fid)) {
          $media = Media::load($element->single_slideshow_image->fid);
          if ($media && $media->bundle() === 'image') {
            $media_field_name = 'field_media_image';
            if ($media->hasField($media_field_name) && !$media->get($media_field_name)->isEmpty()) {
              $file = $media->get($media_field_name)->entity;
              if (!empty($file)) {
                $file_uri = $file->getFileUri();
                if (!empty($settings->element->gallery_image_style) && $settings->element->gallery_image_style != 'original') {
                  $image = ImageStyle::load($settings->element->gallery_image_style)->buildUrl($file_uri);
                }
                else {
                  $image = $this->fileUrlGenerator->generateAbsoluteString($file_uri);
                }
              }
            }
          }
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
        $mid = !empty($element->single_slideshow_image->fid) ? $element->single_slideshow_image->fid : NULL;

        $html .= '<div class="swiper-slide swiper-slide_' . $index . ' multipart-item_' . $index . '">';

        $html .= '<div class="noahs_page_builder-slideshow-services--wrapper">
                     <div class="noahs_page_builder-slideshow-services--container">
                        <div class="noahs_page_builder-slideshow-services--content">
                        <div class="noahs_page_builder-slideshow-services--box">
                           <a href="' . $url . '" role="button">';
        if (!empty($svg_content)) {
          $html .= '<div class="noahs-icon-wrapper noahs-icon-svg d-flex justify-content-center align-items-center element-transition">' . $svg_content . '</div>';
        }
        else {
          $html .= '<div class="noahs-icon-wrapper d-flex justify-content-center align-items-center element-transition"><i class="' . $icon . '"></i></div>';
        }

        if (!empty($element->slideshow_title->text)) {
          $html .= '<h4 class="noahs_page_builder-slideshow-services--title">' . $element->slideshow_title->text . '</h4>';
        }
        $html .= '</a>
                              </div>';

        $html .= '<div class="noahs_page_builder-slideshow-services--item">';
        $html .= '<div class="noahs_page_builder-slideshow-services--actions">';
        if (!empty($url)) {
          $html .= '<a href="' . $url . '"><i class="fa-solid fa-link"></i></a>';
        }
        $html .= '<a data-fancybox="gallery" aria-label="Open image" href="' . $image . '"><i class="fa-solid fa-magnifying-glass"></i></a>';
        $html .= '</div>';
        $html .= $this->getMediaImage($mid, $thumbnails_image_style);
        $html .= '</div>

                     </div>
                     </div>
                  </div>
            </div>';

        $index++;
      }
    }
    else {
      $html .= '<div class="swiper-slide swiper-slide_0 multipart-item_0" ><div class="noahs_page_builder-slideshow-services--wrapper">
                     <div class="noahs_page_builder-slideshow-services--container">
                        <div class="noahs_page_builder-slideshow-services--content">
                        <div class="noahs_page_builder-slideshow-services--box">
                           <a href="" role="button"><div class="noahs-icon-wrapper d-flex justify-content-center align-items-center element-transition"><i class="fa-solid fa-cube"></i></div></a><h4 class="noahs_page_builder-slideshow-services--title"><a href="" role="button">This is a h2</a></h4>
                              </div><div class="noahs_page_builder-slideshow-services--item"><div class="noahs_page_builder-slideshow-services--actions"><a data-fancybox="gallery" href="/modules/custom/noahs_page_builder/assets/img/widget-image.jpg"><i class="fa-solid fa-magnifying-glass"></i></a></div><img class="gallery-image-src" src="' . $thumbnail_image . '"></div>

                     </div>
                     </div>
                  </div>
            </div>
            <div class="swiper-slide swiper-slide_1 multipart-item_1" ><div class="noahs_page_builder-slideshow-services--wrapper">
                     <div class="noahs_page_builder-slideshow-services--container">
                        <div class="noahs_page_builder-slideshow-services--content">
                        <div class="noahs_page_builder-slideshow-services--box">
                           <a href="" role="button"><div class="noahs-icon-wrapper d-flex justify-content-center align-items-center element-transition"><i class="fa-solid fa-cube"></i></div></a><h4 class="noahs_page_builder-slideshow-services--title"><a href="" role="button">This is a h2</a></h4>
                              </div><div class="noahs_page_builder-slideshow-services--item"><div class="noahs_page_builder-slideshow-services--actions"><a data-fancybox="gallery" href="/modules/custom/noahs_page_builder/assets/img/widget-image.jpg"><i class="fa-solid fa-magnifying-glass"></i></a></div><img class="gallery-image-src" src="' . $thumbnail_image . '"></div>

                     </div>
                     </div>
                  </div>
            </div>
            <div class="swiper-slide swiper-slide_2 multipart-item_2" ><div class="noahs_page_builder-slideshow-services--wrapper">
                     <div class="noahs_page_builder-slideshow-services--container">
                        <div class="noahs_page_builder-slideshow-services--content">
                        <div class="noahs_page_builder-slideshow-services--box">
                           <a href="" role="button"><div class="noahs-icon-wrapper d-flex justify-content-center align-items-center element-transition"><i class="fa-solid fa-cube"></i></div></a><h4 class="noahs_page_builder-slideshow-services--title"><a href="" role="button">This is a h2</a></h4>
                              </div><div class="noahs_page_builder-slideshow-services--item"><div class="noahs_page_builder-slideshow-services--actions"><a data-fancybox="gallery" href="/modules/custom/noahs_page_builder/assets/img/widget-image.jpg"><i class="fa-solid fa-magnifying-glass"></i></a></div><img class="gallery-image-src" src="' . $thumbnail_image . '"></div>

                     </div>
                     </div>
                  </div>
            </div>
            <div class="swiper-slide swiper-slide_3 multipart-item_3" ><div class="noahs_page_builder-slideshow-services--wrapper">
                     <div class="noahs_page_builder-slideshow-services--container">
                        <div class="noahs_page_builder-slideshow-services--content">
                        <div class="noahs_page_builder-slideshow-services--box">
                           <a href="" role="button"><div class="noahs-icon-wrapper d-flex justify-content-center align-items-center element-transition"><i class="fa-solid fa-cube"></i></div></a><h4 class="noahs_page_builder-slideshow-services--title"><a href="" role="button">This is a h2</a></h4>
                              </div><div class="noahs_page_builder-slideshow-services--item"><div class="noahs_page_builder-slideshow-services--actions"><a data-fancybox="gallery" href="/modules/custom/noahs_page_builder/assets/img/widget-image.jpg"><i class="fa-solid fa-magnifying-glass"></i></a></div><img class="gallery-image-src" src="' . $thumbnail_image . '"></div>

                     </div>
                     </div>
                  </div>
            </div>';
    }

    $html .= '</div>
            <!-- If we need pagination -->
            <div class="swiper-pagination"></div>

            <!-- If we need navigation buttons -->
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
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
