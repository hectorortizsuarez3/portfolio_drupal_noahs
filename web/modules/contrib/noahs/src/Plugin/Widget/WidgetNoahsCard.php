<?php

namespace Drupal\noahs_page_builder\Plugin\Widget;

use Drupal\image\Entity\ImageStyle;
use Drupal\media\Entity\Media;

/**
 * @WidgetPlugin(
 *   id = "noahs_card",
 *   label = @Translation("Card")
 * )
 */
class WidgetNoahsCard extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function data() {
    return [
      'icon' => '<svg id="fi_3596091" enable-background="new 0 0 24 24" height="512" viewBox="0 0 24 24" width="512" xmlns="http://www.w3.org/2000/svg"><g><path d="m21.5 21h-19c-1.378 0-2.5-1.122-2.5-2.5v-13c0-1.378 1.122-2.5 2.5-2.5h19c1.378 0 2.5 1.122 2.5 2.5v13c0 1.378-1.122 2.5-2.5 2.5zm-19-17c-.827 0-1.5.673-1.5 1.5v13c0 .827.673 1.5 1.5 1.5h19c.827 0 1.5-.673 1.5-1.5v-13c0-.827-.673-1.5-1.5-1.5z"></path></g><g><path d="m7.5 12c-1.378 0-2.5-1.122-2.5-2.5s1.122-2.5 2.5-2.5 2.5 1.122 2.5 2.5-1.122 2.5-2.5 2.5zm0-4c-.827 0-1.5.673-1.5 1.5s.673 1.5 1.5 1.5 1.5-.673 1.5-1.5-.673-1.5-1.5-1.5z"></path></g><g><path d="m11.5 17c-.276 0-.5-.224-.5-.5v-1c0-.827-.673-1.5-1.5-1.5h-4c-.827 0-1.5.673-1.5 1.5v1c0 .276-.224.5-.5.5s-.5-.224-.5-.5v-1c0-1.378 1.122-2.5 2.5-2.5h4c1.378 0 2.5 1.122 2.5 2.5v1c0 .276-.224.5-.5.5z"></path></g><g><path d="m20.5 9h-6c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h6c.276 0 .5.224.5.5s-.224.5-.5.5z"></path></g><g><path d="m20.5 13h-6c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h6c.276 0 .5.224.5.5s-.224.5-.5.5z"></path></g><g><path d="m20.5 17h-6c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h6c.276 0 .5.224.5.5s-.224.5-.5.5z"></path></g></svg>',
      'title' => 'Card',
  'description' => 'Content card with image, title, and text.',
      'group' => 'General',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildWidgetForm(array $form) {
    

    $form['section_content'] = [
      'type' => 'tab',
      'title' => t('Content'),
    ];
    $form['card_style'] = [
      'type'      => 'select',
      'tab'     => 'section_content',
      'title'     => ('Cart Style'),
      'options' => [
        'vertical' => 'Vertical',
        'horizontal' => 'Horizontal',
        'overlay' => 'Image overlays',
        'flipped' => 'Flip',
      ],
      'attributes' => [
        'class' => 'noahs-regenerate-design',
      ],
    ];

    $form['image'] = [
      'type'    => 'noahs_image',
      'title'   => ('Image'),
      'tab' => 'section_content',
      'update_selector' => '.card-img-top',
    ];

    $form['hremove_cover_image'] = [
      'type'    => 'checkbox',
      'title'   => t('Remove Cover image'),
      'tab' => 'section_content',
      'value' => TRUE,
      'default_value' => FALSE,
      'wrapper' => FALSE,
      'attributes' => [
        'class' => 'noahs-regenerate-design',
      ],

    ];
    $form['card_group_text'] = [
      'type' => 'group',
      'title' => t('Content'),
    ];
    $form['card_title'] = [
      'type'    => 'text',
      'title'   => t('Title'),
      'tab' => 'section_content',
      'group' => 'card_group_text',
      'update_selector' => '.card-title > *',
      'wrapper' => FALSE,
      'translate_ai' => TRUE,
      'default_value' => 'Card Title Here',
    ];
    $form['card_tag'] = [
      'type'    => 'text',
      'title'   => t('Tag'),
      'tab' => 'section_content',
      'group' => 'card_group_text',
      'update_selector' => '.card-tag-div',
      'wrapper' => FALSE,
      'translate_ai' => TRUE,
      'default_value' => 'Tag',
    ];

    $form['heading_type'] = [
      'type'      => 'select',
      'tab'     => 'section_content',
      'title'     => ('Type'),
      'options' => [
        '' => 'Default',
        'h1' => 'H1',
        'h2' => 'H2',
        'h3' => 'H3',
        'h4' => 'H4',
        'h5' => 'H5',
        'h6' => 'H6',
      ],
      'update_selector_html' => '.card-title > *',
      'group' => 'card_group_text',
      'wrapper' => FALSE,
    ];

    $form['text'] = [
      'type'    => 'textarea',
      'title'   => t('Text'),
      'tab' => 'section_content',
      'group' => 'card_group_text',
      'update_selector' => '.card-text',
      'wrapper' => FALSE,
      'translate_ai' => TRUE,
      'default_value' => 'This is the card text, please write here',
    ];

    $form['group_link'] = [
      'type' => 'group',
      'title' => t('Link'),
    ];
    $form['link_text'] = [
      'type'    => 'text',
      'title'   => t('Link Title'),
      'tab' => 'section_content',
      'group' => 'group_link',
      'update_selector' => '.btn',
      'wrapper' => FALSE,
      'translate_ai' => TRUE,
      'default_value' => 'Button',

    ];
    $form['link_url'] = [
      'type'    => 'noahs_url',
      'title'   => t('Link'),
      'tab' => 'section_content',
      'group' => 'group_link',
      'autocomplete' => 'url_autocomplete',
      'wrapper' => FALSE,
    ];

    $form['stretched_link'] = [
      'type'    => 'checkbox',
      'title'   => t('Stretched-link'),
      'tab' => 'section_content',
      'group' => 'group_link',
      'value' => 'stretched-link',
      'default_value' => '',
      'style_type' => 'class',
      'style_selector' => '.btn',
      'update_selector' => '.btn',
      'wrapper' => FALSE,

    ];
    $form['hide_link'] = [
      'type'    => 'checkbox',
      'title'   => t('Hide link'),
      'tab' => 'section_content',
      'group' => 'group_link',
      'value' => 'hidden',
      'default_value' => '',
      'style_type' => 'class',
      'style_selector' => '.btn-container',
      'update_selector' => '.btn-container',
      'wrapper' => FALSE,
    ];

    $form['horizontal_align'] = [
      'type'    => 'select',
      'title'   => t('Horizontal Align'),
      'tab' => 'section_content',
      'group' => 'group_link',
      'style_type' => 'style',
      'style_selector' => '.btn-container',
      'style_css' => 'justify-content',
      'responsive' => TRUE,
      'options' => [
        '' => 'Por defecto',
        'flex-start' => 'Start',
        'center' => 'Center',
        'flex-end' => 'End',
      ],
    ];
    $form['button_target'] = [
      'type'    => 'select',
      'title'   => t('Target'),
      'tab' => 'section_content',
      'group' => 'group_link',
      'style_type'      => 'attribute',
      'style_selector'  => '.btn',
      'attribute_type'  => 'target',
      'options' => [
        '' => 'Opens in the same frame as it was clicked',
        '_blank' => 'Opens in a new window or tab',
        '_parent' => 'Opens in the parent frame',
        '_top' => 'Opens in the full body of the window',
        'framename' => 'Opens in the named iframe',
      ],
    ];

    // Section Styles.
    $form['section_styles'] = [
      'type' => 'tab',
      'title' => t('Styles'),
    ];

    $form['image_style_group'] = [
      'type' => 'group',
      'title' => t('Image'),
    ];

    $form['image_background_color'] = [
      'type' => 'noahs_color',
      'title' => t('Background Color'),
      'tab' => 'section_styles',
      'group' => 'image_style_group',
      'style_type' => 'style',
      'style_selector' => '.widget-image-src',
      'style_css' => 'background-color',
      'style_hover' => TRUE,
    ];

    $form['image_border'] = [
      'type' => 'noahs_border',
      'title' => t('Border'),
      'tab' => 'section_styles',
      'group' => 'image_style_group',
      'style_type' => 'style',
      'style_selector' => '.widget-image-src',
      'style_css' => 'border',
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];

    $form['image_margin'] = [
      'type' => 'noahs_margin',
      'title' => t('Margin'),
      'tab' => 'section_styles',
      'group' => 'image_style_group',
      'style_type' => 'style',
      'style_selector' => '.widget-image-src',
      'style_css' => 'margin',
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];

    $form['image_padding'] = [
      'type' => 'noahs_padding',
      'title' => t('Padding'),
      'tab' => 'section_styles',
      'group' => 'image_style_group',
      'style_type' => 'style',
      'style_selector' => '.widget-image-src',
      'style_css' => 'padding',
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];

    $form['image_shadows'] = [
      'type'    => 'noahs_shadows',
      'title'   => t('Image Shadow'),
      'tab' => 'section_styles',
      'group' => 'image_style_group',
      'style_type' => 'style',
      'style_selector' => '.widget-image-src',
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];
    $form['image_radius'] = [
      'type'    => 'noahs_radius',
      'title'   => t('Border Radius'),
      'tab' => 'section_styles',
      'group' => 'image_style_group',
      'style_type' => 'style',
      'style_selector' => '.widget-image-src',
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];
    $form['title_group'] = [
      'type' => 'group',
      'title' => t('Title'),
      'tab' => 'section_styles',
    ];

    $form['title_font'] = [
      'type' => 'noahs_font',
      'title' => t('Font'),
      'group' => 'title_group',
      'tab' => 'section_styles',
      'style_type' => 'style',
      'style_selector' => '.card-title > *',
      'responsive' => TRUE,
    ];

    $form['title_align'] = [
      'type'    => 'select',
      'title'   => t('Text Align'),
      'tab' => 'section_styles',
      'group' => 'title_group',
      'style_type' => 'style',
      'style_selector' => '.card-title',
      'style_css' => 'text-align',
      'options' => [
        '' => 'Left',
        'center' => 'Center',
        'right' => 'Right',
      ],
    ];

    $form['title_margin'] = [
      'type' => 'noahs_margin',
      'title' => t('Margin'),
      'tab' => 'section_styles',
      'group' => 'title_group',
      'style_type' => 'style',
      'style_selector' => '.card-title',
      'style_css' => 'margin',
      'responsive' => TRUE,
    ];

    $form['description_group'] = [
      'type' => 'group',
      'title' => t('Description'),
      'tab' => 'section_styles',
    ];

    $form['description_font'] = [
      'type' => 'noahs_font',
      'title' => t('Font'),
      'group' => 'description_group',
      'tab' => 'section_styles',
      'style_type' => 'style',
      'style_selector' => '.card-text',
      'responsive' => TRUE,
    ];

    $form['description_margin'] = [
      'type' => 'noahs_margin',
      'title' => t('Margin'),
      'tab' => 'section_styles',
      'group' => 'description_group',
      'style_type' => 'style',
      'style_selector' => '.card-text',
      'style_css' => 'margin',
      'responsive' => TRUE,
    ];

    $form['button_group'] = [
      'type' => 'group',
      'title' => t('Button'),
    ];
    $form['button_font'] = [
      'type' => 'noahs_font',
      'title' => t('Font'),
      'group' => 'button_group',
      'tab' => 'section_styles',
      'style_type' => 'style',
      'style_selector' => '.btn',
      'responsive' => TRUE,
    ];
    $form['background_color'] = [
      'type' => 'noahs_color',
      'title' => t('Background Color'),
      'tab' => 'section_styles',
      'group' => 'button_group',
      'style_type' => 'style',
      'style_selector' => '.btn',
      'style_css' => 'background-color',
      'style_hover' => TRUE,
    ];

    $form['border'] = [
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

    $form['button_shadows'] = [
      'type'    => 'noahs_shadows',
      'title'   => t('Shadow'),
      'tab' => 'section_styles',
      'group' => 'button_group',
      'style_type' => 'style',
      'style_selector' => '.btn',
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];
    $form['button_radius'] = [
      'type'    => 'noahs_radius',
      'title'   => t('Border Radius'),
      'tab' => 'section_styles',
      'group' => 'button_group',
      'style_type' => 'style',
      'style_selector' => '.btn',
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];

    $form['box_group'] = [
      'type' => 'group',
      'title' => t('Background box Size'),
    ];

    $form['car_background_color'] = [
      'type' => 'noahs_color',
      'title' => t('Background Color'),
      'tab' => 'section_styles',
      'group' => 'box_group',
      'style_type' => 'style',
      'style_selector' => '.card',
      'style_css' => 'background-color',
      'style_hover' => TRUE,
    ];

    $form['car_border'] = [
      'type' => 'noahs_border',
      'title' => t('Border'),
      'tab' => 'section_styles',
      'group' => 'box_group',
      'style_type' => 'style',
      'style_selector' => '.card',
      'style_css' => 'border',
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];

    $form['card_margin'] = [
      'type' => 'noahs_margin',
      'title' => t('Margin'),
      'tab' => 'section_styles',
      'group' => 'box_group',
      'style_type' => 'style',
      'style_selector' => '.card',
      'style_css' => 'margin',
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];

    $form['card_padding'] = [
      'type' => 'noahs_padding',
      'title' => t('Padding'),
      'tab' => 'section_styles',
      'group' => 'box_group',
      'style_type' => 'style',
      'style_selector' => '.card',
      'style_css' => 'padding',
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];

    $form['card_shadows'] = [
      'type'    => 'noahs_shadows',
      'title'   => t('Image Shadow'),
      'tab' => 'section_styles',
      'group' => 'box_group',
      'style_type' => 'style',
      'style_selector' => '.card',
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];
    $form['card_radius'] = [
      'type'    => 'noahs_radius',
      'title'   => t('Border Radius'),
      'tab' => 'section_styles',
      'group' => 'box_group',
      'style_type' => 'style',
      'style_selector' => '.card',
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

    $image = '/' . NOAHS_PAGE_BUILDER_PATH . '/assets/img/widget-image.jpg';

    if (!empty($settings->image->fid)) {
      $media = Media::load($settings->image->fid);
      if ($media && $media->bundle() === 'image') {
        $media_field_name = 'field_media_image';
        if ($media->hasField($media_field_name) && !$media->get($media_field_name)->isEmpty()) {
          $file = $media->get($media_field_name)->entity;
          if (!empty($file)) {
            $file_uri = $file->getFileUri();
            if (!empty($settings->image->image_style) && $settings->image->image_style != 'original' ) {
              $image = ImageStyle::load($settings->image->image_style)->buildUrl($file_uri);
            }
            else {
              $image = $this->fileUrlGenerator->generateAbsoluteString($file_uri);
            }
          }

        }
      }
    }

    if (!empty($settings->image->token_media)) {
      $token_service = $this->token;
      $token = $settings->image->token_media;
      $route_match = $this->routeMatch;

      $node = $route_match->getParameter('node');
      if (!empty($node)) {
        $image = $token_service->replace($token, [
          $node->getEntityTypeId() => $node,
        ]);
      }
    }

    $card_style = !empty($settings->card_style) ? $settings->card_style : 'vertical';

    $html = '';

    if ($card_style == 'overlay') {
      $html .= '   <div class="card card-olverlay h-100 bg-dark text-white">';
    }
    elseif ($card_style == 'flipped') {
      $html .= '   <div class="card card-' . $card_style . '"">';
    }
    else {
      $html .= '   <div class="card w-100 h-100 card-' . $card_style . '">';
    }

    $cover_class = empty($settings->hremove_cover_image) ? 'object-fit-cover img-fluid' : 'object-fit-none';

    if ($card_style == 'horizontal') {

      $html .= '      <div class="row h-100 g-0">';
      $html .= '        <div class="col-md-6 col-left position-relative">';
      $html .= '        <a class="image" href="' . (!empty($settings->link_url->url) ? $settings->link_url->url : '#') . '">';
      $html .= '         <img class="' . $cover_class . ' position-relative widget-image-src" src="' . $image . '">';
      $html .= '        </a>';
      $html .= '        </div>';
      $html .= '        <div class="col-md-6 col-right">';
      $html .= '          <div class="card-body">';
      $html .= '           <div class="card-title mb-4"><' . ($settings->heading_type ?? 'h5') . '>';
      $html .= '            ' . ($settings->card_title->text ?? 'Card Title Here') . '</' . ($settings->heading_type ?? 'h5') . '>';
      $html .= '           </div>';
      $html .= '           <div class="card-text mb-4">' . ($settings->text ?? 'This is the card text, please write here') . '</div>';
      if (!empty($settings->link_text->text)) {
        $html .= '           <div class="btn-container">';
        $html .= '              <a href="' . (!empty($settings->link_url->url) ? $settings->link_url->url : '#') . '" class="btn">';
        $html .= '               ' . ($settings->link_text->text ?? 'Button') . '</a>';
        $html .= '           </div>';
      }
      $html .= '         </div>';
      $html .= '        </div>';
      $html .= '      </div>';
    }
    elseif ($card_style == 'overlay') {
      $html .= '      <img class="card-img widget-image-src" src="' . $image . '">';
      $html .= '      <div class="card-body card-img-overlay" style="--bs-bg-opacity: .5;">';
      $html .= '         <div class="card-title"><' . ($settings->heading_type ?? 'h5') . '>';
      $html .= '            ' . ($settings->card_title->text ?? 'Card Title Here') . '</' . ($settings->heading_type ?? 'h5') . '>';
      $html .= '         </div>';
      $html .= '         <div class="card-content-bottom">';
      $html .= '         <div class="card-title-2"><' . ($settings->heading_type ?? 'h5') . '>';
      $html .= '            ' . ($settings->card_title->text ?? 'Card Title Here') . '</' . ($settings->heading_type ?? 'h5') . '>';
      $html .= '         </div>';
      $html .= '         <div class="card-text">' . ($settings->text ?? 'This is the card text, please write here') . '</div>';
      if (!empty($settings->link_text->text)) {
        $html .= '           <div class="btn-container">';
        $html .= '              <a href="' . (!empty($settings->link_url->url) ? $settings->link_url->url : '#') . '" class="btn">';
        $html .= '               <span>' . ($settings->link_text->text ?? 'Button') . '</span></a>';
        $html .= '           </div>';
        $html .= '         </div>';
      }
      $html .= '      </div>';
    }
    elseif ($card_style == 'flipped') {
      $html .= '<div class="card-content">';
      $html .= '<div class="front">';
      $html .= '      <img class="card-img widget-image-src" src="' . $image . '">';
      $html .= '         <div class="card-title"><' . ($settings->heading_type ?? 'h5') . '>';
      $html .= '            ' . ($settings->card_title->text ?? 'Card Title Here') . '</' . ($settings->heading_type ?? 'h5') . '>';
      $html .= '         </div>';
      $html .= '</div>';
      $html .= '<div class="back">';
      $html .= '     <div class="card-content-bottom">';
      $html .= '       <div class="card-title-2"><' . ($settings->heading_type ?? 'h4') . '>';
      $html .= '            ' . ($settings->card_title->text ?? 'Card Title Here') . '</' . ($settings->heading_type ?? 'h4') . '>';
      $html .= '        </div>';
      $html .= '        <div class="card-text">' . ($settings->text ?? 'This is the card text, please write here') . '</div>';
      if (!empty($settings->link_text->text)) {
        $html .= '        <div class="btn-container">';
        $html .= '              <a href="' . (!empty($settings->link_url->url) ? $settings->link_url->url : '#') . '" class="btn">';
        $html .= '               <span>' . ($settings->link_text->text ?? 'Button') . '</span></a>';
        $html .= '         </div>';
      }
      $html .= '         </div>';
      $html .= '      </div>';
      $html .= '      </div>';
    }
    else {
      $html .= '      <img class="' . $cover_class . ' position-relative card-img-top widget-image-src" src="' . $image . '">';
      if (!empty($settings->card_tag->text)) {
        $html .= '      <div class="card-tag-div position-absolute badge bg-principal-color p-2 m-2">' . $settings->card_tag->text . '</div>';
      }
      $html .= '      <div class="card-body d-flex flex-column">';
      $html .= '         <div class="card-title mb-4"><' . ($settings->heading_type ?? 'h5') . '>';
      $html .= '            ' . ($settings->card_title->text ?? 'Card Title Here') . '</' . ($settings->heading_type ?? 'h5') . '>';
      $html .= '         </div>';
      $html .= '         <div class="card-text mb-4">' . ($settings->text ?? 'This is the card text, please write here') . '</div>';
      if (!empty($settings->link_text->text)) {
        $html .= '           <div class="btn-container mt-auto">';
        $html .= '              <a href="' . (!empty($settings->link_url->url) ? $settings->link_url->url : '#') . '" class="btn"><span>';
        $html .= '               ' . ($settings->link_text->text ?? 'Button') . '</span></a>';
        $html .= '           </div>';
      }
      $html .= '      </div>';
    }

    $html .= '</div>';
    return $html;
  }

  /**
   * {@inheritdoc}
   */
  public function renderContent($element, $content = NULL) {
    return $this->wrapper($element, $this->template($element->settings));
  }

}
