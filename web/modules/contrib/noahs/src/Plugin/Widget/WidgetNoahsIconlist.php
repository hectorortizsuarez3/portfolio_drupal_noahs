<?php

namespace Drupal\noahs_page_builder\Plugin\Widget;
use Drupal\file\Entity\File;
/**
 * @WidgetPlugin(
 *   id = "noahs_icon_list",
 *   label = @Translation("Icon List")
 * )
 */
class WidgetNoahsIconlist extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function data() {
    return [
      'icon' => '<svg xmlns="http://www.w3.org/2000/svg" id="fi_8632735" data-name="Layer 1" viewBox="0 0 64 64" width="512" height="512"><path d="M52,40.05V16.78A5.78,5.78,0,0,0,46.22,11H7.78A5.78,5.78,0,0,0,2,16.78V49.22A5.78,5.78,0,0,0,7.78,55h33A11,11,0,1,0,52,40.05ZM7.78,53A3.79,3.79,0,0,1,4,49.22V16.78A3.79,3.79,0,0,1,7.78,13H46.22A3.79,3.79,0,0,1,50,16.78V40.05a11,11,0,0,0-9.81,13ZM51,60a9,9,0,1,1,9-9A9,9,0,0,1,51,60Z"></path><path d="M47.9,53.57l-2.12-2.63L44.22,52.2,47,55.63a1,1,0,0,0,.69.37h.09a1,1,0,0,0,.65-.24l9.24-8-1.32-1.52Z"></path><path d="M12,27a4,4,0,0,0,3.86-3H47V22H15.86A4,4,0,1,0,12,27Zm0-6a2,2,0,1,1-2,2A2,2,0,0,1,12,21Z"></path><path d="M12,37a4,4,0,0,0,3.86-3H43V32H15.86A4,4,0,1,0,12,37Zm0-6a2,2,0,1,1-2,2A2,2,0,0,1,12,31Z"></path><path d="M12,39a4,4,0,1,0,3.86,5H39V42H15.86A4,4,0,0,0,12,39Zm0,6a2,2,0,1,1,2-2A2,2,0,0,1,12,45Z"></path></svg>',
      'title' => 'Icon List',
  'description' => 'List of icons with titles and styles.',
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
      'fields' => [
        'icon_content' => [
          'type' => 'tab',
          'title' => t('Title '),
        ],
        'icon_title' => [
          'title' => 'Title',
          'type' => 'text',
          'placeholder' => 'This is a h2',
          'tab' => 'icon_content',
          'update_selector' => '.multipart-item_element_[index] h5',
          'default_value' => 'Noah\'s Drupal Page Editor',
          'wrapper' => FALSE,
        ],
        'icon_text' => [
          'title' => 'Text',
          'type' => 'textarea',
          'placeholder' => 'This is a p',
          'tab' => 'icon_content',
          'update_selector' => '.multipart-item_element_[index] p',
          'wrapper' => FALSE,
        ],
        'icon' => [
          'type'    => 'noahs_icon',
          'title'   => t('Icon'),
          'tab' => 'icon_content',
          'default_value' => 'fa-solid fa-check',
          'wrapper' => FALSE,
        ],

      ],
    ];
    $form['heading_type'] = [
      'type'      => 'select',
      'tab'     => 'section_content',
      'title'     => t('Type'),
      'options' => [
        'h1' => 'H1',
        'h2' => 'H2',
        'h3' => 'H3',
        'h4' => 'H4',
        'h5' => 'H5',
        'h6' => 'H6',
        'div' => 'DIV',
      ],
      'default_value' => 'h5',
      'attributes' => [
        'class' => 'noahs-regenerate-design',
      ],
      'wrapper' => FALSE,
    ];
    $form['icon_list_numbered'] = [
      'type'    => 'checkbox',
      'title'   => t('Numbered'),
      'value' => 'true',
      'default_value' => 'false',
      'tab' => 'section_content',
      'wrapper' => FALSE,
      'attributes' => [
        'class' => 'noahs-regenerate-design',
      ],
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

    $form['section_styles'] = [
      'type' => 'tab',
      'title' => t('Styles'),
    ];

    $form['icon_size'] = [
      'type'    => 'text',
      'title'   => t('Icon Size'),
      'placeholder'   => t('20px, 2rem, etc...'),
      'tab' => 'section_styles',
      'responsive' => TRUE,
      'style_type' => 'style',
      'style_css' => 'font-size',
      'style_selector' => '.noahs-list-group i',
    ];
    $form['icon_color'] = [
      'type'     => 'noahs_color',
      'title'    => ('Icon Color'),
      'tab'     => 'section_styles',
      'style_type' => 'style',
      'style_selector' => '.noahs-list-group i',
      'style_css' => 'color',
      'style_hover' => TRUE,
    ];

    $form['font_title'] = [
      'type' => 'noahs_font',
      'title' => t('Title'),
      'tab' => 'section_styles',
      'style_type' => 'style',
      'style_selector' => '.noahs-list-group .heading',
      'responsive' => TRUE,
    ];
    $form['numbered_font_title'] = [
      'type' => 'noahs_font',
      'title' => t('Numbered font'),
      'tab' => 'section_styles',
      'style_type' => 'style',
      'style_selector' => '.noahs-list-group i',
      'responsive' => TRUE,
      'state' => [
        'visible' => [
          'icon_list_numbered' => ['value' => 'true'],
        ],
      ],
    ];

    $form['font_text'] = [
      'type' => 'noahs_font',
      'title' => t('Text'),
      'tab' => 'section_styles',
      'style_type' => 'style',
      'style_selector' => '.noahs-list-group p',
      'responsive' => TRUE,
    ];
    $form['bg_color'] = [
      'type'     => 'noahs_color',
      'title'    => ('Background Color'),
      'tab'     => 'section_styles',
      'style_type' => 'style',
      'style_css' => 'background-color',
      'style_selector' => 'widget',
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function template($settings) {
    $settings = $settings->element;
    $elements = !empty($settings->icon_list) ? $settings->icon_list : [];
    $list_orientation = !empty($settings->icon_list_vertical) ? 'noahs-list-group--horizontal' : 'noahs-list-group--vertival';

    $output = '';

    $output .= '
             <div class="widget-content">
         ';

    if (!empty($elements)) {

      $output .= '<div class="noahs-list-group multipart-item ' . $list_orientation . '">';
      $numbered = 0;
      foreach ($elements as $index => $element) {
        $numbered++;
        $svg_content = NULL;
        if (!empty($element->icon->fid)) {
          $file = File::load($element->icon->fid);
          if ($file) {
            $svg_url = $file->getFileUri();
            $svg_content = file_get_contents($svg_url);
          }
        }

        $text = '';
        if (!empty($element->icon_text) && empty($element->icon_text->text)) {
          $text = $element->icon_text;
        }
        elseif (!empty($element->icon_text->text)) {
          $text =$element->icon_text->text;
        }
        $output .= '<div class="noahs-list-group--item mb-3 multipart-item_' . $index . '">';
        if (!empty($settings->icon_list_numbered)) {
          $output .= ' <i class="numbered">' . $numbered . '</i>';
        }
        else {
           if (!empty($svg_content)) {
            $output .= '<div class="svg-content">' . $svg_content . '</div>';
           }else{
            $output .= ' <i class="' . $element->icon->class . '"></i>';
           }
          
        }
        $output .= '<div class="noahs-list-group--item-content">';
        if (isset($element->icon_title)) {
          $output .= '<' . ($settings->heading_type ?? 'h5') . ' class="heading">';
          $output .= $element->icon_title->text;
          $output .= '</' . ($settings->heading_type ?? 'h5') . '>';
        }
        if (isset($text)) {
          $output .=  $text;
        }
        $output .= '</div>
                           </div>';
      }
      $output .= '</div>';
    }
    else {
      $output .= '
                 <div class="noahs-list-group multipart-item">
                     <div class="noahs-list-group--item mb-3 multipart-item_element_0">
                         <i class="fa-solid fa-check"></i>
                         <div class="noahs-list-group--item-content">
                             <h5>Noah\'s Drupal Page Editor</h5>
                             <p>Nibh mauris cursus mattis molestie a iaculis at erat pellentesque.</p>
                         </div>
                     </div>
                     <div class="noahs-list-group--item mb-3">
                         <i class="fa-solid fa-check"></i>
                         <div class="noahs-list-group--item-content  multipart-item_element_1">
                             <h5>Noah\'s Drupal Page Editor</h5>
                             <p>Nibh mauris cursus mattis molestie a iaculis at erat pellentesque.</p>
                         </div>
                     </div>
                     <div class="noahs-list-group--item mb-3">
                         <i class="fa-solid fa-check"></i>
                         <div class="noahs-list-group--item-content multipart-item_element_2">
                             <h5>Noah\'s Drupal Page Editor</h5>
                             <p>Nibh mauris cursus mattis molestie a iaculis at erat pellentesque.</p>
                         </div>
                     </div>
                 </div>
             ';
    }

    $output .= '
             </div>
         ';

    return $output;
  }

  /**
   * {@inheritdoc}
   */
  public function renderContent($element, $content = NULL) {
    return $this->wrapper($element, $this->template($element->settings));
  }

}
