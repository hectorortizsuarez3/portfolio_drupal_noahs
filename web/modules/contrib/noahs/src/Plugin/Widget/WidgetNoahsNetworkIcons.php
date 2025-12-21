<?php

namespace Drupal\noahs_page_builder\Plugin\Widget;

/**
 * @WidgetPlugin(
 *   id = "noahs_network_icons",
 *   label = @Translation("Social Icons")
 * )
 */
class WidgetNoahsNetworkIcons extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function data() {
    return [
      'icon' => '<svg xmlns="http://www.w3.org/2000/svg" id="fi_8632735" data-name="Layer 1" viewBox="0 0 64 64" width="512" height="512"><path d="M52,40.05V16.78A5.78,5.78,0,0,0,46.22,11H7.78A5.78,5.78,0,0,0,2,16.78V49.22A5.78,5.78,0,0,0,7.78,55h33A11,11,0,1,0,52,40.05ZM7.78,53A3.79,3.79,0,0,1,4,49.22V16.78A3.79,3.79,0,0,1,7.78,13H46.22A3.79,3.79,0,0,1,50,16.78V40.05a11,11,0,0,0-9.81,13ZM51,60a9,9,0,1,1,9-9A9,9,0,0,1,51,60Z"></path><path d="M47.9,53.57l-2.12-2.63L44.22,52.2,47,55.63a1,1,0,0,0,.69.37h.09a1,1,0,0,0,.65-.24l9.24-8-1.32-1.52Z"></path><path d="M12,27a4,4,0,0,0,3.86-3H47V22H15.86A4,4,0,1,0,12,27Zm0-6a2,2,0,1,1-2,2A2,2,0,0,1,12,21Z"></path><path d="M12,37a4,4,0,0,0,3.86-3H43V32H15.86A4,4,0,1,0,12,37Zm0-6a2,2,0,1,1-2,2A2,2,0,0,1,12,31Z"></path><path d="M12,39a4,4,0,1,0,3.86,5H39V42H15.86A4,4,0,0,0,12,39Zm0,6a2,2,0,1,1,2-2A2,2,0,0,1,12,45Z"></path></svg>',
      'title' => 'Social Icons',
  'description' => 'Display social network icons with links.',
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

    $form['icon_list'] = [
      'type'    => 'noahs_multiple_elements',
      'title'   => t('Icon List'),
      'tab' => 'section_content',
      'default_items' => 3,
      'default_value' => [
        'fields' => [
          [
            'icon_title' => [
              'text' => 'Facebook',
            ],
            'icon' => [
              'class' => 'fa-brands fa-facebook',
            ],
            'url' => [
              'text' => '',
              'url' => '',
            ],
          ],
          [
            'icon_title' => [
              'text' => 'Twitter',
            ],
            'icon' => [
              'class' => 'fa-brands fa-twitter',
            ],
            'url' => [
              'text' => '',
              'url' => '',
            ],
          ],
          [
            'icon_title' => [
              'text' => 'Instagram',
            ],
            'icon' => [
              'class' => 'fa-brands fa-instagram',
            ],
            'url' => [
              'text' => '',
              'url' => '',
            ],
          ],
        ]
      ],
      'fields' => [
        'icon_content' => [
          'type' => 'tab',
          'title' => t('Title '),
        ],
        'icon_title' => [
          'title' => 'Title',
          'type' => 'text',
          'placeholder' => 'Social name',
          'tab' => 'icon_content',
          'update_selector' => '.multipart-item_element_[index] span',
          'wrapper' => FALSE,
        ],
        'icon' => [
          'type'    => 'noahs_icon',
          'title'   => t('Icon'),
          'tab' => 'icon_content',
          'default_value' => 'fa-brands fa-facebook',
          'wrapper' => FALSE,
        ],
        'url' => [
          'title' => 'Url',
          'type' => 'noahs_url',
          'tab' => 'icon_content',
          'autocomplete' => 'url_autocomplete',
          'placeholder' => t('Intertal/External URL'),
          'description' => t('If external use https://'),
          'wrapper' => FALSE,
        ],

      ],
    ];

    $form['hide_title_icon'] = [
      'type'    => 'select',
      'title'   => t('Hide/Show Title'),
      'value' => 'true',
      'tab' => 'section_content',
      'wrapper' => FALSE,
      'options' => [
        '' => t('Show'),
        'none' => t('Hide'),
      ],
      'style_type' => 'style',
      'style_selector' => '.noahs-nwtworks-list-group--item-title',
      'style_css' => 'display', 
    ];

    $form['icon_list_vertical'] = [
      'type'    => 'checkbox',
      'title'   => t('Horizontal'),
      'value' => 'true',
      'default_value' => 'false',
      'tab' => 'section_content',
      'wrapper' => FALSE,
      'attributes' => [
        'class' => 'noahs-regenerate-design',
      ],
    ];

    $form['horizontal_align'] = [
      'type'    => 'select',
      'title'   => t('Horizontal Align'),
      'tab' => 'section_content',
      'style_type' => 'style',
      'style_selector' => '.widget-wrapper',
      'style_css' => 'justify-content',
      'options' => [
        '' => 'Por defecto',
        'flex-start' => 'Start',
        'center' => 'Center',
        'flex-end' => 'End',
      ],
      'wrapper' => FALSE,
    ];
    $form['section_styles'] = [
      'type' => 'tab',
      'title' => t('Styles'),
    ];
    $form['elements_gap'] = [
      'type'    => 'text',
      'title'   => t('Elements Space'),
      'style_type' => 'style',
      'style_selector' => '.noahs-nwtworks-list-group',
      'style_css' => 'gap',
      'tab' => 'section_styles',
      'responsive' => TRUE,
      'placeholder' => 'use as 10%, 100px, 100vw...',
    ];
    $form['icon_size'] = [
      'type'    => 'text',
      'title'   => t('Icon Size'),
      'placeholder'   => t('20px, 2rem, etc...'),
      'tab' => 'section_styles',
      'responsive' => TRUE,
      'style_type' => 'style',
      'style_css' => 'font-size',
      'style_selector' => '.noahs-nwtworks-list-group i',
    ];
    $form['icon_color'] = [
      'type'     => 'noahs_color',
      'title'    => ('Icon Color'),
      'tab'     => 'section_styles',
      'style_type' => 'style',
      'style_selector' => '.noahs-nwtworks-list-group i',
      'style_css' => 'color',
      'style_hover' => TRUE,
    ];

    $form['font_title'] = [
      'type' => 'noahs_font',
      'title' => t('Title'),
      'tab' => 'section_styles',
      'style_type' => 'style',
      'style_selector' => '.noahs-nwtworks-list-group--item-content',
      'responsive' => TRUE,
      'style_hover' => TRUE,
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
    $settings = $settings->element;
    $elements = !empty($settings->icon_list) ? $settings->icon_list : [];
    $list_orientation = !empty($settings->icon_list_vertical) ? 'noahs-nwtworks-list-group--horizontal' : 'noahs-nwtworks-list-group--vertival';
    $output = '';
    $url = '';

    if (!empty($elements)) {
      $output .= '
                 <div class="noahs-nwtworks-list-group multipart-item ' . $list_orientation . '">
             ';

      foreach ($elements as $index => $element) {

        if (!empty($element->url->url)) {
          $url = $settings->url->url;
        }
        elseif (!empty($element->url->text)) {
          $url = $element->url->text;
        }
        $output .= '
                     <div class="noahs-nwtworks-list-group--item multipart-item_' . $index . '">
                        <a href="' . $url . '" target="_blank">
                         <i class="' . $element->icon->class . '"></i>
                         <div class="noahs-nwtworks-list-group--item-content">
                 ';
        $output .= '<span class="noahs-nwtworks-list-group--item-title">';
        if (isset($element->icon_title)) {
          $output .= $element->icon_title->text;
        }
        $output .= '</span>';

        $output .= '</div>
                         </a>
                     </div>
                 ';
      }

      $output .= '
                 </div>
             ';
    }
    else {
      $output .= '
                 <div class="noahs-nwtworks-list-group multipart-item">
                     <div class="noahs-nwtworks-list-group--item multipart-item_element_0">
                        <a class="noahs-nwtworks-list-group--item">
                           <i class="fa-brands fa-facebook"></i>
                           <div class="noahs-nwtworks-list-group--item-content">
                              <span>Social Name</span>
                           </div>
                        </a>
                     </div>
                 </div>
             ';
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
