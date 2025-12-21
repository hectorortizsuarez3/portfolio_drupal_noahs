<?php

namespace Drupal\noahs_page_builder\Plugin\Widget;

use Drupal\image\Entity\ImageStyle;
use Drupal\media\Entity\Media;

/**
 * @WidgetPlugin(
 *   id = "naohs_slideshow",
 *   label = @Translation("Slideshow")
 * )
 */
class WidgetNoahsSlideshow extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function data() {
    return [
      'icon' => '<svg height="682pt" viewBox="-21 -90 682.66669 682" width="682pt" xmlns="http://www.w3.org/2000/svg" id="fi_1700577"><path d="m625.625 50.75h-70v-40.625c0-7.925781-6.449219-14.375-14.375-14.375h-341.152344c-5.179687 0-9.375 4.1992188-9.375 9.375 0 5.175781 4.195313 9.375 9.375 9.375h336.777344v271.203125c0 5.175781 4.199219 9.375 9.375 9.375s9.375-4.199219 9.375-9.375v-216.203125h65.625v331.25h-181.25v-36.25h101.25c7.925781 0 14.375-6.449219 14.375-14.375v-23.011719c0-5.175781-4.199219-9.375-9.375-9.375s-9.375 4.199219-9.375 9.375v18.636719h-433.75v-331.25h56.585938c5.175781 0 9.375-4.199219 9.375-9.375 0-5.1757812-4.199219-9.375-9.375-9.375h-60.960938c-7.925781 0-14.375 6.449219-14.375 14.375v40.625h-70c-7.925781 0-14.375 6.449219-14.375 14.375v340c0 7.925781 6.449219 14.375 14.375 14.375h25.335938c5.175781 0 9.375-4.199219 9.375-9.375s-4.199219-9.375-9.375-9.375h-20.960938v-331.25h65.625v280.625c0 7.925781 6.449219 14.375 14.375 14.375h101.25v36.25h-119.902344c-5.179687 0-9.375 4.199219-9.375 9.375s4.195313 9.375 9.375 9.375h124.277344c7.925781 0 14.375-6.449219 14.375-14.375v-40.625h202.5v40.625c0 7.925781 6.449219 14.375 14.375 14.375h190c7.925781 0 14.375-6.449219 14.375-14.375v-340c0-7.925781-6.449219-14.375-14.375-14.375zm0 0"></path><path d="m127.835938 243.273438c0 15.515624 12.617187 28.125 28.125 28.125h328.023437c15.507813 0 28.125-12.609376 28.125-28.125 0-15.507813-12.617187-28.125-28.125-28.125h-22.324219l-58.085937-80.535157c-3.511719-4.867187-9.191407-7.769531-15.183594-7.769531-6 0-11.675781 2.90625-15.191406 7.773438l-22.167969 30.734374-52.550781-72.085937c-3.632813-4.980469-9.488281-7.960937-15.652344-7.960937-6.167969 0-12.015625 2.980468-15.65625 7.960937l-88.855469 121.890625h-22.347656c-15.515625-.007812-28.132812 12.609375-28.132812 28.117188zm365.519531 0c0 5.171874-4.207031 9.375-9.375 9.375h-328.019531c-5.164063 0-9.375-4.203126-9.375-9.375 0-5.164063 4.210937-9.375 9.375-9.375h328.023437c5.164063 0 9.371094 4.210937 9.371094 9.375zm-104.988281-97.6875 50.179687 69.5625h-51.207031l-24.691406-33.859376zm-106.042969-41.269532c.058593-.085937.183593-.261718.503906-.261718.316406 0 .4375.175781.496094.261718l80.808593 110.832032h-44.21875c-.050781 0-.101562 0-.148437 0h-118.246094zm0 0"></path><path d="m245 433.25c-15.507812 0-28.125 12.617188-28.125 28.125s12.617188 28.125 28.125 28.125 28.125-12.617188 28.125-28.125-12.617188-28.125-28.125-28.125zm0 37.5c-5.171875 0-9.375-4.203125-9.375-9.375s4.203125-9.375 9.375-9.375 9.375 4.203125 9.375 9.375-4.203125 9.375-9.375 9.375zm0 0"></path><path d="m395 433.25c-15.507812 0-28.125 12.617188-28.125 28.125s12.617188 28.125 28.125 28.125 28.125-12.617188 28.125-28.125-12.617188-28.125-28.125-28.125zm0 37.5c-5.171875 0-9.375-4.203125-9.375-9.375s4.203125-9.375 9.375-9.375 9.375 4.203125 9.375 9.375-4.203125 9.375-9.375 9.375zm0 0"></path><path d="m320 425.75c-19.644531 0-35.625 15.980469-35.625 35.625s15.980469 35.625 35.625 35.625 35.625-15.980469 35.625-35.625-15.980469-35.625-35.625-35.625zm0 52.5c-9.304688 0-16.875-7.566406-16.875-16.875 0-9.304688 7.570312-16.875 16.875-16.875s16.875 7.570312 16.875 16.875c0 9.308594-7.570312 16.875-16.875 16.875zm0 0"></path></svg>',
      'title' => 'Slideshow',
      'description' => 'Slideshow of images with titles, text and link.',
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
    $form['slideshow_items'] = [
      'type'    => 'noahs_multiple_elements',
      'title'   => t('Slideshow Items'),
      'tab' => 'section_content',
      'fields' => [
        'slideshow_content' => [
          'type' => 'tab',
          'title' => t('Slide Content'),
        ],
        'single_slideshow_image' => [
          'type'    => 'noahs_image',
          'title'   => ('Image'),
          'tab' => 'slideshow_content',
          'update_selector' => '.multipart-item_element_[index] .noahs_page_builder-slideshow--image',
        ],
        'slideshow_title' => [
          'title' => 'Title',
          'type' => 'text',
          'placeholder' => 'This is a h2',
          'tab' => 'slideshow_content',
          'default_value' => 'This is a h2',
          'update_selector' => '.multipart-item_element_[index] .noahs_page_builder-slideshow--title',
          'wrapper' => FALSE,
          'translate_ai' => TRUE,
        ],
        'slideshow_text' => [
          'title' => 'Text',
          'type' => 'textarea',
          'tab' => 'slideshow_content',
          'default_value' => 'In dignissim eget mauris ac consectetur. Fusce at auctor urna. Mauris in ex porta, blandit felis id, blandit diam.',
          'update_selector' => '.multipart-item_element_[index] .noahs_page_builder-slideshow--text',
          'wrapper' => FALSE,
          'translate_ai' => TRUE,
        ],
        'slideshow_image' => [
          'type'     => 'noahs_background_image',
          'title'    => ('Background Image'),
          'tab'     => 'slideshow_content',
          'style_type' => 'style',
          'style_selector' => '.multipart-item_element_[index]',
        ],
        'bg_image_overlay' => [
          'type'     => 'noahs_background_overlay',
          'title'    => ('Background Overlay'),
          'tab'     => 'slideshow_content',
          'style_type' => 'style',
          'style_selector' => '.multipart-item_element_[index]:before',
        ],
        'background_color' => [
          'type' => 'noahs_color',
          'title' => t('Background Color'),
          'tab' => 'slideshow_content',
          'style_type' => 'style',
          'style_selector' => '.multipart-item_element_[index]',
          'style_css' => 'background-color',
        ],
        'slideshow_link_text' => [
          'title' => 'Link Title',
          'type' => 'text',
          'tab' => 'slideshow_content',
          'default_value' => 'My button',
          'update_selector' => '.multipart-item_element_[index] .noahs_page_builder-slideshow--button a',
        ],
        'slideshow_url' => [
          'title' => 'Url',
          'type' => 'noahs_url',
          'tab' => 'slideshow_content',
          'autocomplete' => 'url_autocomplete',
          'placeholder' => t('Intertal/External URL'),
          'description' => t('If external use https://'),
        ],
        'button_target' => [
          'type'    => 'select',
          'title'   => t('Target'),
          'tab' => 'slideshow_content',
          'style_type'      => 'attribute',
          'style_selector'  => '.multipart-item_element_[index] .btn',
          'attribute_type'  => 'target',
          'options' => [
            '' => 'Opens in the same frame as it was clicked',
            '_blank' => 'Opens in a new window or tab',
            '_parent' => 'Opens in the parent frame',
            '_top' => 'Opens in the full body of the window',
            'framename' => 'Opens in the named iframe',
          ],
        ],
        'content_text_align' => [
          'type'    => 'select',
          'title'   => t('Text Align'),
          'tab' => 'slideshow_content',
          'style_type' => 'style',
          'style_selector' => '.multipart-item_element_[index] .noahs_page_builder-slideshow--content',
          'style_css' => 'text-align',
          'wrapper' => FALSE,
          'options' => [
            'center' => 'Center',
            'left' => 'Left',
            'right' => 'Right',
          ],
        ],
        'content_horizontal_align' => [
          'type'    => 'select',
          'title'   => t('Horizontal Align'),
          'tab' => 'slideshow_content',
          'style_type' => 'style',
          'style_selector' => '.multipart-item_element_[index] .noahs_page_builder-slideshow--container',
          'style_css' => 'justify-content',
          'wrapper' => FALSE,
          'options' => [
            'center' => 'Center',
            'flex-start' => 'Start',
            'flex-end' => 'End',
          ],
        ],
           // Indivildual styles.
        'slideshow_styles' => [
          'type' => 'tab',
          'title' => t('Indivildual Style'),
        ],
        'individual_heading_font' => [
          'type'        => 'noahs_font',
          'title'       => t('Heading Font'),
          'tab'     => 'slideshow_styles',
          'style_type' => 'style',
          'style_selector' => '.multipart-item_element_[index] .noahs_page_builder-slideshow--content > h2',
          'responsive' => TRUE,
        ],
        'individual_text_font' => [
          'type'        => 'noahs_font',
          'title'       => t('Text Font'),
          'tab'     => 'slideshow_styles',
          'style_type' => 'style',
          'style_selector' => '.multipart-item_element_[index] .noahs_page_builder-slideshow--text',
          'responsive' => TRUE,
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
        'individual_btn_font' => [
          'type' => 'noahs_font',
          'title' => t('Button Font'),
          'tab' => 'slideshow_styles',
          'style_type' => 'style',
          'style_selector' => '.multipart-item_element_[index] .btn',
          'responsive' => TRUE,
          'style_hover' => TRUE,
        ],
      ],
    ];

    $form['slideshow_height'] = [
      'type'    => 'text',
      'title'   => t('Height'),
      'tab' => 'section_content',
      'placeholder'     => t('Height'),
      'style_type' => 'style',
      'style_selector' => '.swiper-slide',
      'style_css' => 'min-height',
      'default_value' => '450px',
    ];

    $form['slideshow_container'] = [
      'type'    => 'text',
      'title'   => t('Container Width'),
      'tab' => 'section_content',
      'placeholder'     => t('Width'),
      'style_type' => 'style',
      'style_selector' => '.noahs_page_builder-slideshow--container',
      'style_css' => 'max-width',
      'default_value' => '650px',
    ];
    $form['slideshow_content_width'] = [
      'type'    => 'text',
      'title'   => t('Content Width'),
      'tab' => 'section_content',
      'placeholder'     => t('Width'),
      'style_type' => 'style',
      'style_selector' => '.noahs_page_builder-slideshow--content',
      'style_css' => 'max-width',
      'default_value' => '650px',
    ];

    $form['horizontal_align'] = [
      'type'    => 'select',
      'title'   => t('Horizontal Align'),
      'tab' => 'section_content',
      'style_type' => 'style',
      'style_selector' => '.noahs_page_builder-slideshow--container',
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
      'style_selector' => '.noahs_page_builder-slideshow--title',
      'responsive' => TRUE,
    ];

    $form['text_font'] = [
      'type'        => 'noahs_font',
      'title'       => t('Text Font'),
      'tab'     => 'section_styles',
      'style_type' => 'style',
      'style_selector' => '.noahs_page_builder-slideshow--text',
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

    $form['button_group'] = [
      'type' => 'group',
      'title' => t('Button'),
      'tab' => 'section_styles',
    ];

    $form['btn_background_color'] = [
      'type' => 'noahs_color',
      'title' => t('Background Color'),
      'tab' => 'section_styles',
      'group' => 'button_group',
      'style_type' => 'style',
      'style_selector' => '.btn',
      'style_css' => 'background-color',
      'style_hover' => TRUE,
    ];

    $form['btn_font'] = [
      'type' => 'noahs_font',
      'title' => t('Font'),
      'tab' => 'section_styles',
      'group' => 'button_group',
      'style_type' => 'style',
      'style_selector' => '.btn',
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];

    $form['btn_border'] = [
      'type' => 'noahs_border',
      'title' => t('Border'),
      'tab' => 'section_styles',
      'group' => 'button_group',
      'style_type' => 'style',
      'style_selector' => '.btn',
      'style_css' => 'border',
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];

    $form['btn_margin'] = [
      'type' => 'noahs_margin',
      'title' => t('Margin'),
      'tab' => 'section_styles',
      'group' => 'button_group',
      'style_type' => 'style',
      'style_selector' => '.btn',
      'style_css' => 'margin',
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];

    $form['btn_padding'] = [
      'type' => 'noahs_padding',
      'title' => t('Padding'),
      'tab' => 'section_styles',
      'group' => 'button_group',
      'style_type' => 'style',
      'style_selector' => '.btn',
      'style_css' => 'padding',
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];
    $form['bg_image_overlay'] = [
      'type'     => 'noahs_background_overlay',
      'title'    => ('Background Overlay'),
      'tab'     => 'section_styles',
      'style_type' => 'style',
      'style_selector' => '.swiper-slide:before',
    ];
    return $form;
  }

  /**
   * Template.
   *
   * @param array $settings
   *   The settings.
   *
   * @return string
   *   The output.
   */
  public function template($settings) {
    $elements = !empty($settings->element->slideshow_items) ? $settings->element->slideshow_items : [];

    $html = '<div class="swiper noahs_page_builder-slideshow">
        <div class="swiper-wrapper multipart-item">';

    if (!empty($elements)) {
      $index = 0;
      foreach ($elements as $k => $element) {

        // Bckground image.
        $bg_image = NULL;

        if (!empty($element->slideshow_image->fid)) {
          $media = Media::load($element->slideshow_image->fid);
          if ($media && $media->bundle() === 'image') {
            $media_field_name = 'field_media_image';
            if ($media->hasField($media_field_name) && !$media->get($media_field_name)->isEmpty()) {
              $file = $media->get($media_field_name)->entity;
              if (!empty($file)) {
                $file_uri = $file->getFileUri();
                if (!empty($element->slideshow_image->image_style)) {
                  $image = ImageStyle::load($element->slideshow_image->image_style)->buildUrl($file_uri);
                }
                else {
                  $image = $this->fileUrlGenerator->generateAbsoluteString($file_uri);
                }
              }
            }
          }
        }

        $url = !empty($element->slideshow_url->url) ? $element->slideshow_url->url : '';
        if (!empty($element->slideshow_url->text)) {
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
                if (!empty($element->single_slideshow_image->image_style)) {
                  $image = ImageStyle::load($element->single_slideshow_image->image_style)->buildUrl($file_uri);
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

        $html .= '<div class="swiper-slide swiper-slide_' . $k . ' multipart-item_' . $k . '">';

        if (!empty($bg_image)) {
          $html .= '<img class="object-fit-cover" src="' . $bg_image . '">';
        }

        $html .= '<div class="noahs_page_builder-slideshow--wrapper">
                     <div class="noahs_page_builder-slideshow--container">
                        <div class="noahs_page_builder-slideshow--content">';

        if ($image) {
          $html .= '<div class="noahs_page_builder-slideshow--image"><img src="' . $image . '"></div>';
        }
        if (!empty($element->slideshow_title->text)) {
          $html .= '<h2 class="noahs_page_builder-slideshow--title">' . $element->slideshow_title->text . '</h2>';
        }

        if (!empty($element->slideshow_text)) {
          $html .= '<div class="noahs_page_builder-slideshow--text">' . $element->slideshow_text . '</div>';
        }

        if (!empty($element->slideshow_url->text)) {
          $html .= '<div class="noahs_page_builder-slideshow--button mt-5">
                        <a class="btn" href="' . $url . '" role="button">' . ($element->slideshow_link_text->text ?? 'Button Title') . '</a>
                     </div>';
        }

        $html .= '</div>
                     </div>
                  </div>
            </div>';

        $index++;
      }
    }

    $html .= '</div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
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
