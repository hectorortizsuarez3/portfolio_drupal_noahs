<?php

namespace Drupal\noahs_page_builder\Plugin\Widget;

use Drupal\image\Entity\ImageStyle;
use Drupal\media\Entity\Media;

/**
 * @WidgetPlugin(
 *   id = "noahs_carousel",
 *   label = @Translation("Carusel")
 * )
 */
class WidgetNoahsCarousel extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function data() {
    return [
      'icon' => '<svg id="fi_8103689" height="512" viewBox="0 0 60 60" width="512" xmlns="http://www.w3.org/2000/svg"><path d="m19 15a3 3 0 1 0 -3-3 3 3 0 0 0 3 3zm0-4a1 1 0 1 1 -1 1 1 1 0 0 1 1-1z"></path><path d="m36.495 25.673a2.062 2.062 0 0 0 -2.989 0l-6.549 7.366-2.543-2.539a2.047 2.047 0 0 0 -2.828 0l-4.707 4.7a2.98 2.98 0 0 0 -.879 2.123v1.677a2 2 0 0 0 2 2h24a2 2 0 0 0 2-2v-3.745a3 3 0 0 0 -.758-1.992zm5.505 13.327h-24v-1.677a1.007 1.007 0 0 1 .293-.707l4.707-4.707 2.544 2.544a2.154 2.154 0 0 0 1.472.584 2.011 2.011 0 0 0 1.436-.671l6.548-7.366 6.747 7.591a1 1 0 0 1 .253.664z"></path><path d="m19.5 29a3.5 3.5 0 1 0 -3.5-3.5 3.5 3.5 0 0 0 3.5 3.5zm0-5a1.5 1.5 0 1 1 -1.5 1.5 1.5 1.5 0 0 1 1.5-1.5z"></path><path d="m14 45h32a4 4 0 0 0 4-4v-32a4 4 0 0 0 -4-4h-32a4 4 0 0 0 -4 4v32a4 4 0 0 0 4 4zm32-2h-32a2 2 0 0 1 -2-2v-22h36v22a2 2 0 0 1 -2 2zm-32-36h32a2 2 0 0 1 2 2v8h-36v-8a2 2 0 0 1 2-2z"></path><path d="m14 51a4 4 0 1 0 4-4 4 4 0 0 0 -4 4zm6 0a2 2 0 1 1 -2-2 2 2 0 0 1 2 2z"></path><path d="m26 51a4 4 0 1 0 4-4 4 4 0 0 0 -4 4zm6 0a2 2 0 1 1 -2-2 2 2 0 0 1 2 2z"></path><path d="m38 51a4 4 0 1 0 4-4 4 4 0 0 0 -4 4zm6 0a2 2 0 1 1 -2-2 2 2 0 0 1 2 2z"></path><path d="m26 11h8a1 1 0 0 0 0-2h-8a1 1 0 0 0 0 2z"></path><path d="m26 15h5a1 1 0 0 0 0-2h-5a1 1 0 0 0 0 2z"></path><path d="m5.318 31.731a1 1 0 0 0 1.364-1.462l-4.582-4.269 4.585-4.269a1 1 0 0 0 -1.364-1.462l-4.741 4.411a1.792 1.792 0 0 0 0 2.64z"></path><path d="m54.682 20.269a1 1 0 0 0 -1.364 1.462l4.582 4.269-4.585 4.269a1 1 0 1 0 1.364 1.462l4.741-4.411a1.792 1.792 0 0 0 0-2.64z"></path></svg>',
      'title' => 'Carousel',
      'description' => 'Carusel of images with lightbox option.',
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
      'title' => t('Carousel'),
    ];

    $form['gallery_add_button'] = [
      'type' => 'html',
      'title' => t('Select your images'),
      'tab' => 'section_content',
      'value' => '<br><button class="btn btn-secondary btn-labeled add_multiple_images_field mb-3" data-element-id="gallery-images-wrapper"><span class="btn-label"><i class="fa-solid fa-circle-plus"></i></span>' . t('Add new Item') . '</button>',
    ];

    $form['gallery_items'] = [
      'type'    => 'noahs_gallery',
      'title'   => t('Gallery Items'),
      'tab' => 'section_content',
      'wrapper' => FALSE,
    ];

    $form['gallery_image_style_thumbnails'] = [
      'type'    => 'select',
      'title'   => t('Thumnails Style'),
      'tab' => 'section_content',
      'options' => $image_styles,
      'attributes' => [
        'class' => 'noahs-regenerate-design',
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
    $form['remove_fancybox'] = [
      'type'    => 'checkbox',
      'title'   => t('Remove Fancybox'),
      'tab' => 'section_content',
      'value' => TRUE,
      'default_value' => FALSE,
      'attributes' => [
        'class' => 'noahs-regenerate-design',
      ],
    ];
    $form['grey_effect'] = [
      'type'    => 'checkbox',
      'title'   => t('Grey effect'),
      'tab' => 'section_content',
      'value' => 'grey_effect',
      'default_value' => FALSE,
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
      'wrapper'  => FALSE,
      'default_value' => '4',
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
      'attributes' => [
        'class' => 'noahs-regenerate-design',
      ],
    ];

    $form['carousel_type_columns_tablet'] = [
      'type'    => 'select',
      'title'   => t('Show Elements (Tablet)'),
      'tab' => 'section_content',
      'group' => 'group_item_show',
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
      'attributes' => [
        'class' => 'noahs-regenerate-design',
      ],

    ];

    $form['carousel_type_columns_mobile'] = [
      'type'    => 'select',
      'title'   => t('Show Elements (Mobile)'),
      'tab' => 'section_content',
      'group' => 'group_item_show',
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
      'attributes' => [
        'class' => 'noahs-regenerate-design',
      ],
    ];

    $form['carousel_space'] = [
      'type'    => 'number',
      'title'   => t('Items Space'),
      'tab' => 'section_content',
      'style_type'      => 'attribute',
      'style_selector'  => '.noahs_page_builder-carousel',
      'attribute_type'  => 'data-space',
      'default_value' => '20px',
    ];

    $form['slideshow_content_width'] = [
      'type'    => 'text',
      'title'   => t('Slide Width'),
      'tab' => 'section_content',
      'placeholder'     => t('Width'),
      'style_type' => 'style',
      'style_selector' => '.noahs_page_builder-carousel',
      'style_css' => 'max-width',
      'default_value' => '100%',
    ];
    $form['image_width'] = [
      'type'    => 'noahs_width',
      'title'   => ('Image Width'),
      'style_type' => 'style',
      'style_selector' => 'img',
      'style_css' => 'width',
      'tab' => 'section_content',
      'responsive' => TRUE,
      'placeholder' => 'use as 10%, 100px, 100vw...',
    ];

    $form['horizontal_align'] = [
      'type'    => 'select',
      'title'   => t('Horizontal Align'),
      'tab' => 'section_content',
      'style_type' => 'style',
      'style_selector' => '.widget-wrapper',
      'style_css' => 'justify-content',
      'responsive' => TRUE,
      'options' => [
        'center' => 'Center',
        'flex-start' => 'Start',
        'flex-end' => 'End',
      ],
    ];

    $form['swipers_controls_outside'] = [
      'type'        => 'checkbox',
      'title'       => t(' Controls Outside'),
      'tab'     => 'section_content',
      'style_type' => 'class',      
      'defalt_value' => 0,
      'value' => 'controls-outside',
      'style_selector' => '.swiper-out-container',
    ];

    $form['section_styles'] = [
      'type' => 'tab',
      'title' => t('Styles'),
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
    $form['border'] = [
      'type' => 'noahs_border',
      'title' => t('Border'),
      'tab' => 'section_styles',
      'style_type' => 'style',
      'style_selector' => '.gallery-item .item',
      'style_css' => 'border',
    ];
    $form['box_shadows'] = [
      'type'    => 'noahs_shadows',
      'title'   => t('Shadow'),
      'tab' => 'section_styles',
      'style_type' => 'style',
      'style_selector' => '.gallery-item .item',
    ];
    $form['border-radius'] = [
      'type'    => 'noahs_radius',
      'title'   => t('Border Radius'),
      'tab' => 'section_styles',
      'style_type' => 'style',
      'style_selector' => '.gallery-item .item',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function template($settings) {

    $image = '/' . NOAHS_PAGE_BUILDER_PATH . '/assets/img/widget-image.jpg';
    $items = $settings->element->gallery_items ?? [];
    $thumbnails_image_style = !empty($settings->element->gallery_image_style_thumbnails) ? $settings->element->gallery_image_style_thumbnails : 'thumbnail';
    $image_style = !empty($settings->element->gallery_image_style) ? $settings->element->gallery_image_style : 'noahs_1024_768';
    $carousel_columns = !empty($settings->element->carousel_type_columns) ? $settings->element->carousel_type_columns : '4';
    $remove_fancybox = !empty($settings->element->remove_fancybox) ? $settings->element->remove_fancybox : FALSE;
    $grey_effect = !empty($settings->element->grey_effect) ? $settings->element->grey_effect : FALSE;
    $item_desktop = !empty($settings->element->carousel_type_columns) ? $settings->element->carousel_type_columns : '4';
    $item_tablet = !empty($settings->element->carousel_type_columns_tablet) ? $settings->element->carousel_type_columns_tablet : '2';
    $item_mobile = !empty($settings->element->carousel_type_columns_mobile) ? $settings->element->carousel_type_columns_mobile : '1';
    $thumbnail_image = $image;

    $output = '<div class="swiper-out-container">';
    $output .= '<div class="noahs_page_builder-carousel swiper ' . $grey_effect . '"
         data-show-items-desktop="' . $item_desktop . '"
         data-show-items-tablet="' . $item_tablet . '"
         data-show-items-mobile="' . $item_mobile . '">';
    $output .= '<div class="swiper-wrapper">';

    if (!empty($items)) {

      foreach ($items as $i => $item) {

        if (isset($item->fid)) {
          $media = Media::load($item->fid);
          $media_bundle = 'noahs_image';
          if (\Drupal::entityTypeManager()->getStorage('media_type')->load('image')) {
            if (!\Drupal::entityTypeManager()->getStorage('media_type')->load('noahs_image')) {
              $media_bundle = 'image';
            }
          }
          if ($media && $media->bundle() === $media_bundle) {
      
            $media_field_name = 'field_media_image';
            if ($media->hasField($media_field_name) && !$media->get($media_field_name)->isEmpty()) {
              $file = $media->get($media_field_name)->entity;
              $file_uri = $file->getFileUri();

              if (!empty($file) && !empty($thumbnails_image_style) && !empty(ImageStyle::load($thumbnails_image_style))) {

                if( $thumbnails_image_style !== 'original'){
                  $thumbnail_image = ImageStyle::load($thumbnails_image_style)->buildUrl($file_uri);
                }
                if( $image_style !== 'original'){
                  $image = ImageStyle::load($image_style)->buildUrl($file_uri);
                }   
      
              }
              elseif (!empty($file)) {
                $thumbnail_image = $this->fileUrlGenerator->generateAbsoluteString($file_uri);
                $image = $this->fileUrlGenerator->generateAbsoluteString($file_uri);
              }
            }
          }
        }

        $description = !empty($item->description) ? $item->description : NULL;
        $url = '';

        if (isset($item->url)) {
          if (!empty($item->node_id)) {
            $url = $this->aliasManager->getAliasByPath('/node/' . $item->node_id);
          }
          elseif (filter_var($item->url, FILTER_VALIDATE_URL)) {
            $url = $item->url;
          }
        }

        $output .= '<div class="swiper-slide gallery-item gallery-item-' . $i . '" data-delta="' . $i . '">';
        $output .= '<div class="item">';
        if (!empty($url) || !$remove_fancybox) {
          $output .= '<div class="noahs_page_builder-carousel--actions">';
          if (!empty($url)) {
            $output .= '<a href="' . $url . '"><i class="fa-solid fa-link"></i></a>';
          }
          if (!$remove_fancybox) {
            $output .= '<a data-fancybox="gallery" href="' . $image . '"><i class="fa-solid fa-expand"></i></a>';
          }
          $output .= '</div>';
        }
        if ($description) {
          $output .= '<div class="gallery-description">' . $description . '</div>';
        }
        $output .= '<img class="gallery-image-src" src="' . $thumbnail_image . '">';
        $output .= '</div>';
        $output .= '</div>';
      }
    }
    else {
      // If there are no items, fallback to default slides.
      for ($i = 0; $i < 6; $i++) {
        $output .= '<div class="swiper-slide">';
        $output .= '<div class="noahs_page_builder-carousel--actions">';
        $output .= '<a href=""><i class="fa-solid fa-link"></i></a>';
        $output .= '<a data-fancybox="carousel" href="' . $image . '"><i class="fa-solid fa-expand"></i></a>';
        $output .= '</div>';
        $output .= '<img class="carousel-image-src img-fluid" src="' . $image . '">';
        $output .= '</div>';
      }
    }

    $output .= '</div>';
    $output .= '<div class="swiper-pagination"></div>';
    $output .= '<div class="swiper-button-prev"></div>';
    $output .= '<div class="swiper-button-next"></div>';
    $output .= '</div>';
    $output .= '</div>';

    return $output;
  }

  /**
   * {@inheritdoc}
   */
  public function renderContent($element, $content = NULL) {
    return $this->wrapper($element, $this->template($element->settings));
  }

}
