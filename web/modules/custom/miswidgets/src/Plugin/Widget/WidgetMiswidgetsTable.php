<?php

namespace Drupal\miswidgets\Plugin\Widget;

/**
 * @WidgetPlugin(
 *   id = "miswidgets_table",
 *   label = @Translation("Table")
 * )
 */
class WidgetMiswidgetsTable extends \Drupal\noahs_page_builder\Plugin\Widget\WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function data() {
    return [
      'icon' => '<svg height="512pt" viewBox="0 0 512 512" width="512pt" xmlns="http://www.w3.org/2000/svg" id="fi_1891294"><path d="m497.753906 66.054688c7.855469 0 14.246094-6.390626 14.246094-14.246094v-37.5625c0-7.855469-6.390625-14.246094-14.246094-14.246094h-37.5625c-7.855468 0-14.246094 6.390625-14.246094 14.246094v11.226562h-156.917968v-11.226562c0-7.855469-6.390625-14.246094-14.246094-14.246094h-37.5625c-7.855469 0-14.246094 6.390625-14.246094 14.246094v11.226562h-156.917968v-11.226562c0-7.855469-6.390626-14.246094-14.246094-14.246094h-37.5625c-7.855469 0-14.246094 6.390625-14.246094 14.246094v37.5625c0 7.855468 6.390625 14.246094 14.246094 14.246094h11.222656v156.917968h-11.222656c-7.855469 0-14.246094 6.390625-14.246094 14.246094v37.5625c0 7.855469 6.390625 14.246094 14.246094 14.246094h11.222656v156.917968h-11.222656c-7.855469 0-14.246094 6.390626-14.246094 14.246094v37.566406c0 7.851563 6.390625 14.242188 14.246094 14.242188h37.5625c7.855468 0 14.246094-6.390625 14.246094-14.246094v-11.226562h156.917968v11.226562c0 7.855469 6.390625 14.246094 14.246094 14.246094h37.5625c7.855469 0 14.246094-6.390625 14.246094-14.246094v-11.226562h156.917968v11.226562c0 7.855469 6.390626 14.246094 14.246094 14.246094h37.5625c7.855469 0 14.246094-6.390625 14.246094-14.246094v-37.5625c0-7.855468-6.390625-14.246094-14.246094-14.246094h-11.222656v-156.917968h11.222656c7.855469 0 14.246094-6.390625 14.246094-14.246094v-37.5625c0-7.855469-6.390625-14.246094-14.246094-14.246094h-11.222656v-156.917968zm-36.695312-50.941407h35.828125v35.828125h-35.828125zm-222.972656 0h35.828124v35.828125h-35.828124zm-222.972657 35.828125v-35.828125h35.828125v35.828125zm0 222.972656v-35.828124h35.828125v35.828124zm35.828125 222.972657h-35.828125v-35.828125h35.828125zm222.972656 0h-35.828124v-35.828125h35.828124zm222.972657-35.828125v35.828125h-35.828125v-35.828125zm0-187.144532h-35.828125v-35.828124h35.828125zm-25.472657-50.941406h-11.222656c-7.855468 0-14.246094 6.390625-14.246094 14.246094v37.5625c0 7.855469 6.390626 14.246094 14.246094 14.246094h11.222656v156.917968h-11.222656c-7.855468 0-14.246094 6.390626-14.246094 14.246094v11.222656h-156.917968v-11.222656c0-7.855468-6.390625-14.246094-14.246094-14.246094h-37.5625c-7.855469 0-14.246094 6.390626-14.246094 14.246094v11.222656h-156.917968v-11.222656c0-7.855468-6.390626-14.246094-14.242188-14.246094h-11.226562v-156.917968h11.222656c7.855468 0 14.246094-6.390625 14.246094-14.246094v-37.5625c0-7.855469-6.390626-14.246094-14.246094-14.246094h-11.222656v-156.917968h11.222656c7.855468 0 14.246094-6.390626 14.246094-14.246094v-11.222656h156.917968v11.222656c0 7.855468 6.390625 14.246094 14.246094 14.246094h37.5625c7.855469 0 14.246094-6.390626 14.246094-14.246094v-11.222656h156.917968v11.222656c0 7.855468 6.390626 14.246094 14.246094 14.246094h11.222656zm0 0"></path><path d="m382.183594 99.320312h-111.699219c-4.171875 0-7.554687 3.382813-7.554687 7.558594 0 4.171875 3.382812 7.554688 7.554687 7.554688h111.699219c15.808594 0 28.671875 12.863281 28.671875 28.671875v225.789062c0 15.808594-12.863281 28.671875-28.671875 28.671875h-252.367188c-15.808594 0-28.671875-12.863281-28.671875-28.671875v-225.789062c0-15.808594 12.863281-28.671875 28.671875-28.671875h107.171875c4.175781 0 7.558594-3.382813 7.558594-7.554688 0-4.175781-3.382813-7.558594-7.558594-7.558594h-107.171875c-24.144531 0-43.785156 19.640626-43.785156 43.785157v225.789062c0 24.144531 19.640625 43.785157 43.785156 43.785157h252.367188c24.144531 0 43.785156-19.640626 43.785156-43.785157v-225.789062c0-24.144531-19.640625-43.785157-43.785156-43.785157zm0 0"></path><path d="m157.28125 218.519531 2.742188-9.246093h28.144531l2.945312 9.246093c1.285157 3.726563 3.792969 5.589844 7.519531 5.589844 2.234376 0 4.128907-.679687 5.6875-2.035156 1.625-1.554688 2.4375-3.214844 2.4375-4.976563 0-1.761718-.269531-3.386718-.8125-4.875l-19.914062-54.152344c-2.234375-6.097656-6.195312-9.144531-11.886719-9.144531-5.753906 0-9.75 3.046875-11.988281 9.144531l-20.214844 54.046876c-.476562 1.21875-.710937 2.578124-.710937 4.066406 0 2.234375.777343 4.132812 2.335937 5.6875 1.554688 1.558594 3.488282 2.339844 5.792969 2.339844 4.128906 0 6.769531-1.898438 7.921875-5.691407zm16.863281-52.527343 9.042969 28.550781-18.488281-.101563zm0 0"></path><path d="m371.027344 153.902344h-137.480469c-4.175781 0-7.558594 3.382812-7.558594 7.558594 0 4.175781 3.382813 7.558593 7.558594 7.558593h137.480469c4.175781 0 7.558594-3.382812 7.558594-7.558593 0-4.175782-3.382813-7.558594-7.558594-7.558594zm0 0"></path><path d="m371.027344 202.710938h-137.480469c-4.175781 0-7.558594 3.382812-7.558594 7.554687 0 4.175781 3.382813 7.558594 7.558594 7.558594h137.480469c4.175781 0 7.558594-3.382813 7.558594-7.558594 0-4.171875-3.382813-7.554687-7.558594-7.554687zm0 0"></path><path d="m371.027344 251.515625h-225.589844c-4.171875 0-7.554688 3.382813-7.554688 7.558594 0 4.171875 3.382813 7.558593 7.554688 7.558593h225.59375c4.171875 0 7.554688-3.386718 7.554688-7.558593 0-4.175781-3.382813-7.558594-7.558594-7.558594zm0 0"></path><path d="m371.027344 300.324219h-95.304688c-4.175781 0-7.558594 3.382812-7.558594 7.554687 0 4.175782 3.382813 7.558594 7.558594 7.558594h95.304688c4.175781 0 7.558594-3.382812 7.558594-7.558594 0-4.171875-3.382813-7.554687-7.558594-7.554687zm0 0"></path><path d="m145.4375 364.242188h225.59375c4.171875 0 7.554688-3.382813 7.554688-7.554688 0-4.175781-3.382813-7.558594-7.554688-7.558594h-225.59375c-4.171875 0-7.554688 3.382813-7.554688 7.558594 0 4.171875 3.382813 7.554688 7.554688 7.554688zm0 0"></path><path d="m145.4375 315.4375h94.457031c4.171875 0 7.554688-3.382812 7.554688-7.558594 0-4.171875-3.382813-7.554687-7.554688-7.554687h-94.457031c-4.171875 0-7.554688 3.382812-7.554688 7.554687 0 4.175782 3.382813 7.558594 7.554688 7.558594zm0 0"></path></svg>',
      'title' => 'Table',
      'description' => 'Create tables with styles to show data, prices, etc',
      'group' => 'General',
    ];
  }

  /**
   * {@inheritdoc}
   */

  /*Función que define los controles del editor*/
  public function buildWidgetForm(array $form) {
    

    // Section Content.
    $form['section_content'] = [
      'type' => 'tab',
      'title' => t('Content'),
    ];

    //Panel multifield
    $form['table'] = [
      'type'    => 'noahs_multiple_elements',
      'title'   => t('Table Items'),
      'tab'     => 'section_content',
      'open'    => TRUE,
      'update_selector' => '.widget-content',

      //datos por defecto en la tabla
      'default_value' => [ 
        [
          'header_text' => ["text" => 'Header 1'],
          'cell_text'   => ["text" => 'Cell 1'],
        ],
        [
          'header_text' => ["text" => 'Header 2'],
          'cell_text'   => ["text" => 'Cell 2'], // Añadido para que haya coherencia
        ],
        [
          'header_text' => ["text" => 'Header 3'],
          'cell_text'   => ["text" => 'Cell 3'], // Añadido para que haya coherencia
        ],
      ],

      //campos para cada columna
      'fields' => [
        'table_content' => [
          'type'  => 'tab',
          'title' => t('Table Content'),
        ],
        'header_text' => [
          'type'            => 'text',
          'title'           => t('Header'),
          'tab'             => 'table_content',
          'update_selector' => '.noahs--table--header table thead th.head--[index]',
        ],
        'cell_text' => [
          'title'           => t('Cell text'), 
          'type'            => 'text', 
          'tab'             => 'table_content', // Faltaba asignarlo a la pestaña en el código original de Julián
          'default_value'   => '', 
          'wrapper'         => FALSE, 
          'translate_ai'    => TRUE, 
          'update_selector' => '.noahs--table--body table tbody td.cell--[index]', // Importante para la previsualización [cite: 239]
        ],
      ],
    ];

    //pestaña de estilos
    $form['section_styles'] = [
      'type' => 'tab',
      'title' => t('Style'),
    ];

     //Agrupador visual dentro de la pestaña style
    $form['box_group'] = [
      'type' => 'group',
      'title' => t('Box styles'),
      'tab' => 'section_styles',
    ];
    
    /*  de momento suprimimos noahs_font, si la agregamos luego, debería apuntar a ty y td por separado
    $form['font'] = [
      'type'        => 'noahs_font',
      'title'       => t('Font'),
      'tab'     => 'section_styles',
      'style_type' => 'style',
      'style_selector' => '.widget-content',  //dejarlo así o cambiarlo a widget-content table ??
      'wrapper' => FALSE,
      'responsive' => TRUE,
      'open' => TRUE,
    ];
  */

    //car o card??
    $form['car_background_color'] = [
      'type' => 'noahs_color',
      'title' => t('Background Color'),
      'tab' => 'section_styles',
      'group' => 'box_group',
      'style_type' => 'style',
      'style_selector' => '.widget-content table',
      'style_css' => 'background-color',
      'style_hover' => TRUE,
    ];

    $form['car_border'] = [
      'type' => 'noahs_border',
      'title' => t('Border'),
      'tab' => 'section_styles',
      'group' => 'box_group',
      'style_type' => 'style',
      'style_selector' => '.widget-content table',
      'style_css' => 'border',
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];

    //no modificar
    $form['card_margin'] = [
      'type' => 'noahs_margin',
      'title' => t('Margin'),
      'tab' => 'section_styles',
      'group' => 'box_group',
      'style_type' => 'style',
      'style_selector' => '.widget-content',
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
      'style_selector' => '.widget-content td, .widget-content th',
      'style_css' => 'padding',
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];

    $form['card_shadows'] = [
      'type'    => 'noahs_shadows',
      'title'   => t('Shadow'),
      'tab' => 'section_styles',
      'group' => 'box_group',
      'style_type' => 'style',
      'style_selector' => '.widget-content',
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];
    $form['card_radius'] = [
      'type'    => 'noahs_radius',
      'title'   => t('Border Radius'),
      'tab' => 'section_styles',
      'group' => 'box_group',
      'style_type' => 'style',
      'style_selector' => '.widget-content',
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function template($settings) {
    // 1. Obtenemos los datos tal cual vienen (pueden ser array u objeto stdClass)
    $raw_table_items = $settings->element->table ?? [];

    // 2. LA MAGIA: Convertimos recursivamente todo a un array asociativo.
    // Así nos aseguramos de que el código de abajo NUNCA falle, venga como venga el dato.
    $table_items = json_decode(json_encode($raw_table_items), TRUE);

    $output = '';

    // Solo dibujamos la tabla si hay elementos
    if (!empty($table_items)) {
      $output .= '<div class="noahs--table--container">'; 
      $output .= '<table class="table">'; 

      // --- PARTE 1: ENCABEZADOS (thead) ---
      $output .= '<thead>';
      $output .= '<tr>';
      foreach ($table_items as $key => $value) {
        $header_text = !empty($value['header_text']['text']) ? $value['header_text']['text'] : '';
        $output .= '<th class="head--' . $key . '">' . $header_text . '</th>';
      }
      $output .= '</tr>';
      $output .= '</thead>';

      // --- PARTE 2: CELDAS DE CONTENIDO (tbody) ---
      $output .= '<tbody>';
      $output .= '<tr>';
      foreach ($table_items as $key => $value) {
        $cell_text = !empty($value['cell_text']['text']) ? $value['cell_text']['text'] : '';
        $output .= '<td class="cell--' . $key . '">' . $cell_text . '</td>';
      }
      $output .= '</tr>';
      $output .= '</tbody>';

      $output .= '</table>';
      $output .= '</div>';
    } else {
      $output = '<div class="noahs-placeholder">' . t('Add items to the table to see the content.') . '</div>';
    }

    return $output;
  }

  /**
   * {@inheritdoc}
   */

  /*Función que devuelve el html final del widget (interno + wrapper)*/
  /*-------------------------------------------No necesario editar------------------*/
  public function renderContent($element, $content = NULL) {
    return $this->wrapper($element, $this->template($element->settings));
  }

}
