<?php

namespace Drupal\noahs_page_builder\Plugin\Widget;

use Drupal\file\Entity\File;

/**
 * @WidgetPlugin(
 *   id = "noahs_button",
 *   label = @Translation("Button")
 * )
 */
class WidgetNoahsButton extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function data() {
    return [
      'icon' => '<svg id="fi_4321133" enable-background="new 0 0 512 512" height="512" viewBox="0 0 512 512" width="512" xmlns="http://www.w3.org/2000/svg"><g><path d="m108.533 155.743c-1.344-3.267-4.493-5.375-8.025-5.375-.003 0-.007 0-.011 0-3.536.004-6.685 2.122-8.022 5.395-.023.056-.045.112-.066.168l-19.517 51.243c-1.475 3.871.468 8.204 4.339 9.678 3.87 1.474 8.204-.469 9.678-4.339l3.021-7.932h21.004l2.985 7.91c1.134 3.003 3.987 4.854 7.019 4.854.879 0 1.775-.156 2.646-.485 3.875-1.462 5.832-5.79 4.369-9.665l-19.339-51.246c-.026-.069-.052-.138-.081-.206zm-12.889 33.837 4.837-12.701 4.793 12.701z"></path><path d="m408.418 216.398c3.509-1.096 5.776-4.357 5.776-8.379l-.486-50.224c-.04-4.142-3.405-7.487-7.572-7.427-4.142.04-7.467 3.43-7.427 7.572l.275 28.401-22.54-32.638c-1.865-2.7-5.269-3.875-8.403-2.898s-5.268 3.878-5.268 7.16v51.878c0 4.142 3.358 7.5 7.5 7.5s7.5-3.358 7.5-7.5v-27.82l21.408 31c2.165 3.127 5.791 4.453 9.237 3.375z"></path><path d="m256.439 157.867v51.975c0 4.142 3.358 7.5 7.5 7.5s7.5-3.358 7.5-7.5v-51.975c0-4.142-3.358-7.5-7.5-7.5s-7.5 3.358-7.5 7.5z"></path><path d="m167.809 165.367c3.706 0 7.278 1.09 10.331 3.153 3.432 2.318 8.094 1.417 10.413-2.016 2.319-3.432 1.417-8.094-2.016-10.413-5.542-3.744-12.018-5.724-18.729-5.724-18.465 0-33.488 15.022-33.488 33.488 0 18.465 15.022 33.488 33.488 33.488 7.408 0 14.065-2.441 19.25-7.059 1.016-.904 1.98-1.899 2.868-2.958 2.662-3.174 2.247-7.904-.926-10.566-3.174-2.662-7.904-2.247-10.566.927-.422.503-.876.972-1.351 1.395-2.43 2.164-5.55 3.261-9.275 3.261-10.194 0-18.488-8.294-18.488-18.488s8.295-18.488 18.489-18.488z"></path><path d="m223.169 217.343c4.142 0 7.5-3.358 7.5-7.5v-44.475h6.91c4.142 0 7.5-3.358 7.5-7.5s-3.358-7.5-7.5-7.5h-28.704c-4.142 0-7.5 3.358-7.5 7.5s3.358 7.5 7.5 7.5h6.794v44.475c0 4.142 3.358 7.5 7.5 7.5z"></path><path d="m283.79 183.855c0 18.465 15.022 33.488 33.487 33.488s33.488-15.022 33.488-33.488c0-18.465-15.022-33.488-33.488-33.488-18.465 0-33.487 15.023-33.487 33.488zm51.975 0c0 10.194-8.293 18.488-18.488 18.488-10.194 0-18.487-8.294-18.487-18.488s8.293-18.488 18.487-18.488c10.195 0 18.488 8.294 18.488 18.488z"></path><path d="m508.788 314.3-116.157-80.948c-2.386-1.663-5.519-1.796-8.038-.342s-3.97 4.234-3.723 7.132l12.024 141.069c.237 2.787 2.006 5.211 4.588 6.286s5.548.625 7.695-1.169l27.219-22.756 28.189 56.118c.927 1.845 2.574 3.226 4.551 3.818.705.211 1.429.315 2.15.315 1.304 0 2.6-.34 3.75-1.005l34.71-20.041c1.788-1.032 3.071-2.756 3.548-4.765.476-2.009.103-4.125-1.031-5.851l-34.504-52.472 33.316-12.193c2.627-.961 4.5-3.305 4.86-6.079.362-2.774-.852-5.518-3.147-7.117zm-49.073 14.557c-2.151.787-3.825 2.515-4.543 4.69-.719 2.175-.404 4.56.854 6.474l35.338 53.741-20.943 12.092-28.871-57.474c-1.028-2.047-2.936-3.512-5.179-3.977-.506-.105-1.016-.156-1.523-.156-1.743 0-3.449.608-4.811 1.746l-23.422 19.583-9.442-110.773 91.211 63.564z"></path><path d="m358.938 264.532h-319.374c-13.544 0-24.564-11.019-24.564-24.564v-112.226c0-13.545 11.02-24.564 24.564-24.564h416.839c13.545 0 24.564 11.02 24.564 24.564v112.226c0 6.748-2.74 13.062-7.716 17.778-3.006 2.849-3.133 7.596-.284 10.603 2.85 3.007 7.597 3.134 10.603.284 7.994-7.578 12.397-17.758 12.397-28.665v-112.226c0-21.816-17.749-39.564-39.564-39.564h-416.839c-21.815 0-39.564 17.748-39.564 39.564v112.226c0 21.816 17.749 39.564 39.564 39.564h319.373c4.142 0 7.5-3.358 7.5-7.5s-3.357-7.5-7.499-7.5z"></path></g></svg>',
      'title' => 'Button',
  'description' => 'Customizable button for links or actions.',
      'group' => 'primary',
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

    $form['button_title'] = [
      'type' => 'text',
      'title' => t('Button Title'),
      'tab' => 'section_content',
      'placeholder' => t('Title'),
      'default_value' => 'My button',
      'update_selector' => '.btn > span',
      'wrapper' => FALSE,
      'translate_ai' => TRUE,
    ];
    
    $form['button_url'] = [
      'type' => 'noahs_url',
      'title' => t('URL'),
      'autocomplete' => 'url_autocomplete',
      'tab' => 'section_content',
      'placeholder' => t('Internal/External URL'),
      'description' => t('If external use https://'),
      'open' => TRUE,
    ];
    
    $form['button_style'] = [
      'type'    => 'select',
      'title'   => t('Predefined style'),
      'tab' => 'section_content',
      'style_type' => 'class',
      'style_selector' => '.btn',
      'options' => [
        '' => 'Por defecto',
        'btn-style-1' => 'Style 1',
        'btn-style-2' => 'Style 2',
        'btn-style-3' => 'Style 3',
        'btn-style-4' => 'Style 4',
      ],
    ];

    $form['hide_title'] = [
      'type'    => 'checkbox',
      'title'   => t('Hide Title'),
      'tab' => 'section_content',
      'value' => TRUE,
      'default_value' => FALSE,
      'wrapper' => FALSE,
      'attributes' => [
        'class' => 'noahs-regenerate-design',
      ],
    ];

    $form['group_icon'] = [
      'type' => 'group',
      'title' => t('Icon'),
      'tab' => 'section_content',
    ];

    $form['button_icon'] = [
      'type'    => 'noahs_icon',
      'title'   => t('Icon'),
      'tab' => 'section_content',
      'group' => 'group_icon',
    ];

    $form['icon_size'] = [
      'type'    => 'text',
      'title'   => t('Icon Size'),
      'placeholder'   => t('20px, 2rem, etc...'),
      'tab' => 'section_content',
      'responsive' => TRUE,
      'style_type' => 'style',
      'style_css' => 'font-size',
      'style_selector' => '.btn i',
      'group' => 'group_icon',
    ];
    $form['icon_space'] = [
      'type' => 'text',
      'title' => t('Icon space'),
      'tab' => 'section_content',
      'style_type' => 'style',
      'style_selector' => '.btn',
      'style_css' => 'gap',
      'responsive' => TRUE,
      'style_hover' => TRUE,
      'group' => 'group_icon',
    ];

    $form['icon_direction'] = [
      'type'    => 'select',
      'title'   => t('Icon direction'),
      'tab' => 'section_content',
      'style_type' => 'style',
      'style_selector' => '.btn',
      'style_css' => 'flex-direction',
      'group' => 'group_icon',
      'options' => [
        '' => t('Right'),
        'row-reverse' => 'Left',

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
      'style_selector' => '.btn svg',
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
      'style_selector' => '.btn svg',
    ];


    $form['button_class'] = [
      'type'    => 'text',
      'title'   => ('Custom CSS classes'),
      'style_type' => 'class',
      'style_selector' => '.btn',
      'tab' => 'section_content',
      'placeholder' => 'Multiple classes should be separated with SPACE.',
    ];

    $form['button_target'] = [
      'type'    => 'select',
      'title'   => t('Target'),
      'tab' => 'section_content',
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

    $form['modal_settings'] = [
      'tab' => 'section_content',
      'type' => 'group',
      'title' => t('Modal'),
    ];

    $form['modal_type'] = [
      'type'    => 'select',
      'title'   => t('Type'),
      'tab' => 'section_content',
      'group' => 'modal_settings',
      'style_type'      => 'attribute',
      'style_selector'  => '.btn',
      'attribute_type'  => 'data-dialog-type',
      'wrapper' => FALSE,
      'options' => [
        '' => t('Select'),
        'modal' => 'Modal',
        'dialog' => 'Dialog',
      ],
    ];

    $form['modal_type_settings'] = [
      'type'    => 'text',
      'title'   => ('Modal Settings'),
      'group' => 'modal_settings',
      'style_type'      => 'attribute',
      'attribute_type'  => 'data-dialog-options',
      'style_selector' => '.btn',
      'wrapper' => FALSE,
      'tab' => 'section_content',
      'format' => 'json',
      'description' => 'E.g.: {"width":400}',
    ];

    $form['button_horizontal_align'] = [
      'type'    => 'select',
      'title'   => t('Horizontal Align'),
      'tab' => 'section_content',
      'style_type' => 'style',
      'style_selector' => '.widget-wrapper',
      'style_css' => 'justify-content',
      'responsive' => TRUE,
      'options' => [
        '' => 'Por defecto',
        'flex-start' => 'Start',
        'center' => 'Center',
        'flex-end' => 'End',
        'space-between' => 'Space Betwenn',
        'space-around' => 'Space Around',
        'space-evenly' => 'Space Evenly',
      ],
    ];

    $form['section_styles'] = [
      'type' => 'tab',
      'title' => t('Styles'),
    ];

    $form['background_color'] = [
      'type' => 'noahs_color',
      'title' => t('Background Color'),
      'tab' => 'section_styles',
      'style_type' => 'style',
      'style_selector' => '.btn',
      'style_css' => 'background-color',
      'style_hover' => TRUE,
    ];

    $form['font'] = [
      'type' => 'noahs_font',
      'title' => t('Font'),
      'tab' => 'section_styles',
      'style_type' => 'style',
      'style_selector' => '.btn',
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];
    $form['svg_color'] = [
      'type'     => 'noahs_color',
      'title'    => ('SVG Color'),
      'tab'     => 'section_styles',
      'style_type' => 'style',
      'style_selector' => '.btn svg',
      'style_css' => 'fill',
    ];
    $form['svg_color_hover'] = [
      'type'     => 'noahs_color',
      'title'    => ('Hover SVG Color'),
      'tab'     => 'section_styles',
      'style_type' => 'style',
      'style_selector' => '.btn:hover svg',
      'style_css' => 'fill',
    ];

    $form['border'] = [
      'type' => 'noahs_border',
      'title' => t('Border'),
      'tab' => 'section_styles',
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
      'style_type' => 'style',
      'style_selector' => '.btn',
      'style_css' => 'padding',
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];
    $form['button_shadows'] = [
      'type'    => 'noahs_shadows',
      'title'   => t('Image Shadow'),
      'tab' => 'section_styles',
      'style_type' => 'style',
      'style_selector' => '.btn',
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];
    $form['button_border'] = [
      'type' => 'noahs_border',
      'title' => t('Border'),
      'tab' => 'section_styles',
      'style_type' => 'style',
      'style_selector' => '.btn',
      'style_css' => 'border',
      'style_hover' => TRUE,
    ];
    $form['button_radius'] = [
      'type'    => 'noahs_radius',
      'title'   => t('Border Radius'),
      'tab' => 'section_styles',
      'style_type' => 'style',
      'style_selector' => '.btn',
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
    $output = '';
    $url = '';
    $icon = '';
    $class = [];

    if (!empty($settings->button_icon->fid)) {
      $file = File::load($settings->button_icon->fid);

      $svg_url = $file->getFileUri();
      $icon = file_get_contents($svg_url);
    }
    elseif (!empty($settings->button_icon->class)) {
      $icon = '<i class="' . $settings->button_icon->class . '"></i>';
    }
    if (!empty($settings->button_url->node_id)) {
      $url = $this->aliasManager->getAliasByPath('/node/' . $settings->button_url->node_id);
    }
    elseif (!empty($settings->button_url->text)) {
      // Buscar un número entre paréntesis en el texto
      if (preg_match('/\((\d+)\)/', $settings->button_url->text, $matches)) {
        $node_id = $matches[1];
        $url = $this->aliasManager->getAliasByPath('/node/' . $node_id);
      }
      else {
        $url = $settings->button_url->text;
      }
    }
    if (!empty($settings->button_url->url_params)) {
      $url = $url . $settings->button_url->url_params;
    }
    if (!empty($settings->attribute->modal_type)) {
      $class[] = 'use-ajax';
    }
    $title = NULL;
    if (empty($settings->hide_title) && !empty($settings->button_title->text)) {
      $title = $settings->button_title->text;
    }

    $output .= '<div class="btn-container">';
    $output .= '<a href="' . $url . '" class="btn ' . implode("", $class) . '"><span>' . $title . '</span>' . $icon . '</a>';
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
