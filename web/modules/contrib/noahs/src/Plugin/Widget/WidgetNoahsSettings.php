<?php

namespace Drupal\noahs_page_builder\Plugin\Widget;

/**
 * @WidgetPlugin(
 *   id = "noahs_settings",
 *   label = @Translation("Noahs Settings")
 * )
 */
class WidgetNoahsSettings extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function data() {
    return [
      'icon' => '<svg id="fi_8089962" enable-background="new 0 0 512 512" height="512" viewBox="0 0 512 512" width="512" xmlns="http://www.w3.org/2000/svg"><g><path d="m464.5 27.26h-417c-26.191 0-47.5 21.309-47.5 47.5v376.082c0 18.691 15.207 33.897 33.897 33.897h338.69c4.143 0 7.5-3.358 7.5-7.5s-3.357-7.5-7.5-7.5h-338.69c-10.42 0-18.897-8.477-18.897-18.897v-333.646h82.576c4.143 0 7.5-3.358 7.5-7.5s-3.357-7.5-7.5-7.5h-82.576v-27.436c0-17.921 14.58-32.5 32.5-32.5h417c17.921 0 32.5 14.579 32.5 32.5v27.436h-359.424c-4.143 0-7.5 3.358-7.5 7.5s3.357 7.5 7.5 7.5h359.424v333.646c0 10.42-8.478 18.897-18.897 18.897h-65.515c-4.143 0-7.5 3.358-7.5 7.5s3.357 7.5 7.5 7.5h65.515c18.691 0 33.897-15.206 33.897-33.897v-376.082c0-26.191-21.309-47.5-47.5-47.5z"></path><path d="m456.425 82.735c4.143 0 7.5-3.358 7.5-7.5s-3.357-7.5-7.5-7.5h-90.724c-4.143 0-7.5 3.358-7.5 7.5s3.357 7.5 7.5 7.5z"></path><path d="m435.863 336.221c13.729 0 24.898-11.169 24.898-24.898 0-11.12-7.329-20.559-17.41-23.745.002-.074.011-.146.011-.22v-93.791c10.075-3.19 17.398-12.625 17.398-23.741 0-13.729-11.169-24.898-24.898-24.898-11.116 0-20.551 7.323-23.741 17.398h-312.243c-3.19-10.075-12.625-17.398-23.741-17.398-13.729 0-24.898 11.169-24.898 24.898 0 11.116 7.323 20.552 17.398 23.741v94.014c-10.075 3.19-17.398 12.625-17.398 23.741 0 13.729 11.169 24.898 24.898 24.898 11.116 0 20.552-7.323 23.741-17.398h312.244c3.19 10.076 12.625 17.399 23.741 17.399zm-352.226-48.639v-94.014c7.707-2.44 13.801-8.535 16.241-16.241h312.244c2.44 7.706 8.535 13.801 16.241 16.241v93.791c0 .074.009.146.011.22-7.712 2.438-13.811 8.535-16.252 16.245h-312.244c-2.44-7.708-8.535-13.802-16.241-16.242zm352.226 33.639c-5.457 0-9.897-4.44-9.897-9.898s4.44-9.898 9.897-9.898c5.458 0 9.898 4.44 9.898 9.898s-4.44 9.898-9.898 9.898zm0-161.293c5.458 0 9.898 4.44 9.898 9.898s-4.44 9.898-9.898 9.898c-5.457 0-9.897-4.44-9.897-9.898s4.44-9.898 9.897-9.898zm-359.726 0c5.458 0 9.898 4.44 9.898 9.898s-4.44 9.898-9.898 9.898-9.898-4.44-9.898-9.898 4.44-9.898 9.898-9.898zm0 161.293c-5.458 0-9.898-4.44-9.898-9.898s4.44-9.898 9.898-9.898 9.898 4.44 9.898 9.898-4.441 9.898-9.898 9.898z"></path><path d="m321.759 264.457c-.015 0-.028 0-.043 0-4.991.028-10.345.048-14.474.052v-55.371c0-4.142-3.357-7.5-7.5-7.5s-7.5 3.358-7.5 7.5v62.818c0 3.653 2.633 6.775 6.233 7.392.544.093.962.165 7.84.165 3.362 0 8.269-.017 15.484-.057 4.142-.023 7.481-3.4 7.458-7.542-.022-4.127-3.375-7.457-7.498-7.457z"></path><path d="m197.761 201.639c-4.143 0-7.5 3.358-7.5 7.5v62.871c0 4.142 3.357 7.5 7.5 7.5s7.5-3.358 7.5-7.5v-62.871c0-4.142-3.357-7.5-7.5-7.5z"></path><path d="m384.127 264.223h-18.75v-16.148h16.814c4.143 0 7.5-3.358 7.5-7.5s-3.357-7.5-7.5-7.5h-16.814v-16.148h18.75c4.143 0 7.5-3.358 7.5-7.5s-3.357-7.5-7.5-7.5h-26.25c-4.143 0-7.5 3.358-7.5 7.5v62.297c0 4.142 3.357 7.5 7.5 7.5h26.25c4.143 0 7.5-3.358 7.5-7.5s-3.357-7.501-7.5-7.501z"></path><path d="m162.593 201.639h-34.721c-4.143 0-7.5 3.358-7.5 7.5s3.357 7.5 7.5 7.5h9.79v55.371c0 4.142 3.357 7.5 7.5 7.5s7.5-3.358 7.5-7.5v-55.371h9.931c4.143 0 7.5-3.358 7.5-7.5s-3.357-7.5-7.5-7.5z"></path><path d="m265.798 201.639h-34.722c-4.143 0-7.5 3.358-7.5 7.5s3.357 7.5 7.5 7.5h9.791v55.371c0 4.142 3.357 7.5 7.5 7.5s7.5-3.358 7.5-7.5v-55.371h9.931c4.143 0 7.5-3.358 7.5-7.5s-3.357-7.5-7.5-7.5z"></path><path d="m237.757 373.19h-161.62c-4.142 0-7.5 3.358-7.5 7.5s3.358 7.5 7.5 7.5h161.621c4.143 0 7.5-3.358 7.5-7.5s-3.358-7.5-7.501-7.5z"></path><path d="m237.757 410.414h-161.62c-4.142 0-7.5 3.358-7.5 7.5s3.358 7.5 7.5 7.5h161.621c4.143 0 7.5-3.358 7.5-7.5s-3.358-7.5-7.501-7.5z"></path><path d="m288.132 427.414h141.316c7.672 0 13.914-6.242 13.914-13.914v-28.396c0-7.672-6.242-13.914-13.914-13.914h-141.316c-7.672 0-13.914 6.242-13.914 13.914v28.396c0 7.672 6.242 13.914 13.914 13.914zm1.086-41.224h139.145v26.224h-139.145z"></path></g></svg>',
      'title' => 'Noahs Settings',
      'description' => 'Description',
      'group' => 'General',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildWidgetForm(array $form) {
    

    // Section Content.
    $form['section_fonts'] = [
      'type' => 'tab',
      'title' => t('Fonts'),
    ];

    $form['trigger_action'] = [
      'type' => 'hidden',
      'tab'  => 'section_fonts',
      'wrapper' => FALSE,
      'attributes' => [
        'class' => 'trigger-settings-action',
      ],
    ];

    $form['font_h1'] = [
      'type'        => 'noahs_font',
      'title'       => t('Headline H1'),
      'tab'     => 'section_fonts',
      'open' => TRUE,
      'style_type' => 'style',
      'style_selector' => 'h1',
      'responsive' => TRUE,
    ];

    $form['font_h2'] = [
      'type'        => 'noahs_font',
      'title'       => t('Headline H2'),
      'tab'     => 'section_fonts',
      'style_type' => 'style',
      'style_selector' => 'h2',
      'responsive' => TRUE,
    ];

    $form['font_h3'] = [
      'type'        => 'noahs_font',
      'title'       => t('Headline H3'),
      'tab'     => 'section_fonts',
      'style_type' => 'style',
      'style_selector' => 'h3',
      'responsive' => TRUE,
    ];

    $form['font_h4'] = [
      'type'        => 'noahs_font',
      'title'       => t('Headline H4'),
      'tab'     => 'section_fonts',
      'style_type' => 'style',
      'style_selector' => 'h4',
      'responsive' => TRUE,
    ];

    $form['font_h5'] = [
      'type'        => 'noahs_font',
      'title'       => t('Headline H5'),
      'tab'     => 'section_fonts',
      'style_type' => 'style',
      'style_selector' => 'h5',
      'responsive' => TRUE,
    ];

    $form['body'] = [
      'type'        => 'noahs_font',
      'title'       => t('Body'),
      'tab'     => 'section_fonts',
      'style_type' => 'style',
      'style_selector' => 'body',
      'responsive' => TRUE,
    ];

    $form['body_background_color'] = [
      'type' => 'noahs_color',
      'title' => t('Body background color'),
      'tab' => 'section_fonts',
      'style_type' => 'style',
      'style_selector' => 'body',
      'style_css' => 'background-color',
    ];

    // Section Buttons.
    $form['section_buttons'] = [
      'type' => 'tab',
      'title' => t('Buttons'),
    ];

    $form['button_style'] = [
      'type'    => 'select',
      'title'   => t('Button type style'),
      'description'   => t('You can add predefined styles to buttons to save time.'),
      'tab' => 'section_buttons',
      'wrapper' => FALSE,
      'skip' => TRUE,
      'options' => [
        '' => t('Por defecto'),
        '_style_1' => t('Style') . ' 1',
        '_style_2' => t('Style') . ' 2',
        '_style_3' => t('Style') . ' 3',
        '_style_4' => t('Style') . ' 4',
      ],
    ];

    // Selectores según el estilo
    $selectors = [
      '' => '.btn:not(.btn-admin), .btn-theme:not(.btn-admin), .button:not(.btn-admin)',
      '_style_1' => '.btn.btn-style-1',
      '_style_2' => '.btn.btn-style-2',
      '_style_3' => '.btn.btn-style-3',
      '_style_4' => '.btn.btn-style-4',
    ];

    // Campos de estilos disponibles
    $style_fields = [
      'background_color' => [
        'type' => 'noahs_color',
        'title' => t('Background Color'),
        'style_css' => 'background-color',
      ],
      'font' => [
        'type' => 'noahs_font',
        'title' => t('Font'),
        'responsive' => TRUE,
      ],
      'border' => [
        'type' => 'noahs_border',
        'title' => t('Border'),
        'style_css' => 'border',
        'responsive' => TRUE,
      ],
      'padding' => [
        'type' => 'noahs_padding',
        'title' => t('Padding'),
        'style_css' => 'padding',
        'responsive' => TRUE,
      ],
      'margin' => [
        'type' => 'noahs_margin',
        'title' => t('Margin'),
        'style_css' => 'margin',
        'responsive' => TRUE,
      ],
      'shadows' => [
        'type' => 'noahs_shadows',
        'title' => t('Shadow'),
        'responsive' => TRUE,
      ],
      'radius' => [
        'type' => 'noahs_radius',
        'title' => t('Border Radius'),
        'responsive' => TRUE,
      ],
    ];

    // Generar dinámicamente los fields
    foreach ($selectors as $style_key => $selector) {
      foreach ($style_fields as $field_key => $field) {
        $form['button_' . $field_key . $style_key] = [
          'type' => $field['type'],
          'title' => $field['title'],
          'tab' => 'section_buttons',
          'style_type' => 'style',
          'style_selector' => $selector,
          'style_hover' => TRUE,
          'state' => [
            'leave_value' => TRUE,
            'visible' => [
              'button_style' => ['value' => $style_key],
            ],
          ],
        ];

        // Añadir extras solo si existen en la definición
        if (isset($field['responsive'])) {
          $form['button_' . $field_key . $style_key]['responsive'] = $field['responsive'];
        }
        if (isset($field['style_css'])) {
          $form['button_' . $field_key . $style_key]['style_css'] = $field['style_css'];
        }
      }
    }

    /** Forms */
    $form['section_forms'] = [
      'type' => 'tab',
      'title' => t('Forms'),
    ];

    $input_selectors = "input:not(.element-admin), [type='checkbox'], [type='radio'], select:not(.element-admin), textarea:not(.element-admin), .form-email, .form-control:not(.element-admin)";

    $form['form_label_font'] = [
      'type' => 'noahs_font',
      'title' => t('Labl font'),
      'tab' => 'section_forms',
      'style_type' => 'style',
      'style_selector' => 'label',
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];

    $form['forms_input_background_color'] = [
      'type' => 'noahs_color',
      'title' => t('Background Color'),
      'tab' => 'section_forms',
      'style_type' => 'style',
      'style_selector' => $input_selectors,
      'style_css' => 'background-color',
      'style_hover' => TRUE,
    ];

    $form['form_inputs_font'] = [
      'type' => 'noahs_font',
      'title' => t('Font'),
      'tab' => 'section_forms',
      'style_type' => 'style',
      'style_selector' => $input_selectors,
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];

    $form['forms_input_border'] = [
      'type' => 'noahs_border',
      'title' => t('Border'),
      'tab' => 'section_forms',
      'style_type' => 'style',
      'style_selector' => $input_selectors,
      'style_css' => 'border',
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];

    $form['forms_input_padding'] = [
      'type' => 'noahs_padding',
      'title' => t('Padding'),
      'tab' => 'section_forms',
      'style_type' => 'style',
      'style_selector' => $input_selectors,
      'style_css' => 'padding',
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];

    $form['forms_input_margin'] = [
      'type' => 'noahs_margin',
      'title' => t('Margin'),
      'tab' => 'section_forms',
      'style_type' => 'style',
      'style_selector' => '.form-item',
      'style_css' => 'margin',
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];

    $form['forms_input_shadows'] = [
      'type'    => 'noahs_shadows',
      'title'   => t('Shadow'),
      'tab' => 'section_forms',
      'style_type' => 'style',
      'style_selector' => $input_selectors,
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];

    $form['forms_input_radius'] = [
      'type'    => 'noahs_radius',
      'title'   => t('Border Radius'),
      'tab' => 'section_forms',
      'style_type' => 'style',
      'style_selector' => $input_selectors,
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];

    $form['form_elements_display'] = [
      'type'    => 'select',
      'title'   => t('Display (flex by default)'),
      'tab' => 'section_forms',
      'style_type' => 'style',
      'style_selector' => '.form-item',
      'style_css' => 'display',
      'responsive' => TRUE,
      'options' => [
        'flex' => t('Flex (default)'),
        'block' => t('Block'),
        'inline-block' => t('Inline Block'),
        'inline' => t('Inline'),
        'none' => t('None')
      ],
    ];

    $form['form_elements_inline'] = [
      'type'    => 'select',
      'title'   => t('Elements orientation'),
      'tab' => 'section_forms',
      'style_type' => 'style',
      'style_selector' => '.form-item',
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

    $form['forms_btn_margin'] = [
      'type'    => 'noahs_margin',
      'title'   => t('Margin Button'),
      'tab' => 'section_forms',
      'style_type' => 'style',
      'style_selector' => 'form .btn, form .btn-theme, form .button',
      'responsive' => TRUE,
    ];


    // Swiper Controls
    $form['section_swiper_controls'] = [
      'type' => 'tab',
      'title' => t('Swiper Controls'),
    ];

    //set if the controls are outside the swiper container
    $form['swipers_controls_outside'] = [
      'type'        => 'checkbox',
      'title'       => t('Preview Controls Outside'),
      'description' => t('Check and uncheck to preview controls outside the swiper container.'),
      'tab'     => 'section_swiper_controls',
      'style_type' => 'class',      
      'defalt_value' => 0,
      'value' => 'controls-outside',
      'style_selector' => '.swiper-out-container',
    ];

    //outside padding
    $form['swipers_controls_outside_padding'] = [
      'type'        => 'text',
      'title'       => t('Outside Controls Padding'),
      'tab'     => 'section_swiper_controls',
      'style_type' => 'style',      
      'style_css' => 'padding',
      'style_selector' => '.controls-outside',
      'responsive' => TRUE,
    ];
    
    $form['swipers_controls_size'] = [
      'type'        => 'text',
      'title'       => t('Controls Size'),
      'tab'     => 'section_swiper_controls',
      'style_type' => 'style',      
      'style_css' => 'font-size',
      'style_selector' => '.swiper-button-next:after, .swiper-button-prev:after',
      'responsive' => TRUE,
    ];

    $form['swipers_controls_color'] = [
      'type'        => 'noahs_color',
      'title'       => t('Controls Color'),
      'tab'     => 'section_swiper_controls',
      'style_type' => 'style',      
      'style_css' => 'color',
      'style_selector' => '.swiper-button-next, .swiper-button-prev',
      'style_hover' => TRUE,
    ];

    $form['swipers_controls_background'] = [
      'type'        => 'noahs_color',
      'title'       => t('Controls Background Color'),
      'tab'     => 'section_swiper_controls',
      'style_type' => 'style',      
      'style_css' => 'background-color',
      'style_selector' => '.swiper-button-next, .swiper-button-prev',
      'style_hover' => TRUE,
    ];

    //height and width
    $form['swipers_controls_width'] = [
      'type'        => 'text',
      'title'       => t('Controls Width'),
      'tab'     => 'section_swiper_controls',
      'style_type' => 'style',      
      'style_css' => 'width',
      'style_selector' => '.swiper-button-next, .swiper-button-prev',
      'responsive' => TRUE,
    ];
    
    $form['swipers_controls_height'] = [
      'type'        => 'text',
      'title'       => t('Controls Height'),
      'tab'     => 'section_swiper_controls',
      'style_type' => 'style',      
      'style_css' => 'height',
      'style_selector' => '.swiper-button-next, .swiper-button-prev',
      'responsive' => TRUE,
    ];
    
      $form['swipers_controls_opacity'] = [
      'type'        => 'number',
      'title'       => t('Controls Opacity'),
      'tab'     => 'section_swiper_controls',
      'style_type' => 'style',      
      'style_css' => 'opacity',
      'style_selector' => '.swiper-button-next, .swiper-button-prev',
      'min' => 0,
      'max' => 1,
      'step' => 0.1,
      'style_hover' => TRUE,
    ];

    $form['swipers_controls_size_padding'] = [
      'type'        => 'text',
      'title'       => t('Controls Padding'),
      'tab'     => 'section_swiper_controls',
      'style_type' => 'style',      
      'style_css' => 'padding',
      'style_selector' => '.swiper-button-next, .swiper-button-prev',
      'responsive' => TRUE,
    ];

    $form['swipers_controls_radius'] = [
      'type'        => 'text',
      'title'       => t('Controls Border Radius'),
      'tab'     => 'section_swiper_controls',
      'style_type' => 'style',      
      'style_css' => 'border-radius',
      'style_selector' => '.swiper-button-next, .swiper-button-prev',
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];

    // pagination
    $form['swipers_pagination_size'] = [
      'type'        => 'text',
      'title'       => t('Pagination Size'),
      'tab'     => 'section_swiper_controls',
      'style_type' => 'style',      
      'style_css' => 'width',
      'style_selector' => '.swiper-pagination-bullet',
      'responsive' => TRUE,
    ];  

    $form['swipers_pagination_height'] = [
      'type'        => 'text',
      'title'       => t('Pagination Height'),
      'tab'     => 'section_swiper_controls',
      'style_type' => 'style',      
      'style_css' => 'height',
      'style_selector' => '.swiper-pagination-bullet',
      'responsive' => TRUE,
    ];

    $form['swiper_pagination_position_coordinates'] = [
      'type'    => 'noahs_coordinates',
      'fields'    => [
        'left' => [
          'title' => t('Left'),
          'property' => 'left',
        ],
        'top' => [
          'title' => t('Top'),
          'property' => 'top',
        ],
        'right' => [
          'title' => t('Right'),
          'property' => 'right',
        ],
        'bottom' => [
          'title' => t('Bottom'),
          'property' => 'bottom',
        ],
          // Left top right bottom.
      ],
      'title'   => ('Position Coordinates'),
      'tab' => 'section_swiper_controls',
      'style_type' => 'style',
      'style_selector' => '.swiper-pagination',
      'style_css' => 'position',
      'responsive' => TRUE,
    ];

    $form['swipers_pagination_separation'] = [
      'type'        => 'noahs_margin',
      'title'       => t('Pagination separation'),
      'tab'     => 'section_swiper_controls',
      'style_type' => 'style',      
      'style_css' => 'margin',
      'style_selector' => '.swiper-pagination-bullet',
      'responsive' => TRUE,
    ];
    
    $form['swipers_pagination_border'] = [
      'type'        => 'noahs_border',
      'title'       => t('Pagination Border'),
      'tab'     => 'section_swiper_controls',
      'style_type' => 'style',      
      'style_css' => 'border',
      'style_selector' => '.swiper-pagination-bullet',
      'responsive' => TRUE,
    ];

    $form['swipers_pagination_border_radius'] = [
      'type'        => 'text',
      'title'       => t('Pagination Border Radius'),
      'tab'     => 'section_swiper_controls',
      'style_type' => 'style',      
      'style_css' => 'border-radius',
      'style_selector' => '.swiper-pagination-bullet',
      'responsive' => TRUE,
    ];

    $form['swipers_pagination_background_color'] = [
      'type'        => 'noahs_color',
      'title'       => t('Pagination Background Color'),
      'tab'     => 'section_swiper_controls',
      'style_type' => 'style',      
      'style_css' => 'background-color',
      'style_selector' => '.swiper-pagination-bullet',
      'style_hover' => TRUE,
    ];






    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function template($settings) {
    $twig = $this->twig;
    $element_content = $twig->render(NOAHS_PAGE_BUILDER_PATH . '/templates/widgets/noahs_settings.twig', [
      'settings' => $settings,
    ]);
    return $element_content;
  }

  /**
   * {@inheritdoc}
   */
  public function renderContent($element, $content = NULL) {
    return $this->wrapper($element, $this->template($element->settings));
  }

}
