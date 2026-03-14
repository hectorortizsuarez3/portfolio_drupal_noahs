<?php

namespace Drupal\miswidgets\Plugin\Widget;

use Drupal\miswidgets\Traits\TextNormalizationTrait;

/**
 * @WidgetPlugin(
 *   id = "miswidgets_table",
 *   label = @Translation("Table")
 * )
 */
class WidgetMiswidgetsTable extends \Drupal\noahs_page_builder\Plugin\Widget\WidgetBase {
  use TextNormalizationTrait; //Normaliza cualquier valor (string/array/stdClass) a string de texto.

  public function data() {
    return [
      'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 0 1-1.125-1.125M3.375 19.5h7.5c.621 0 1.125-.504 1.125-1.125m-9.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-7.5A1.125 1.125 0 0 1 12 18.375m9.75-12.75c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125m19.5 0v1.5c0 .621-.504 1.125-1.125 1.125M2.25 5.625v1.5c0 .621.504 1.125 1.125 1.125m0 0h17.25m-17.25 0h7.5c.621 0 1.125.504 1.125 1.125M3.375 8.25c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m17.25-3.75h-7.5c-.621 0-1.125.504-1.125 1.125m8.625-1.125c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125M12 10.875v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 10.875c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125M13.125 12h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125M20.625 12c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5M12 14.625v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 14.625c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125m0 1.5v-1.5m0 0c0-.621.504-1.125 1.125-1.125m0 0h7.5" /></svg>',
      'title' => 'Table',
      'description' => 'Create tables with styles to show data, prices, etc',
      'group' => 'General',
    ];
  }

  //Definimos controles de la tabla
  public function buildWidgetForm(array $form) {

    // --- Content tab
    $form['section_content'] = [
      'type' => 'tab',
      'title' => t('Content'),
    ];

    // Select number of columns
    $form['columns_count'] = [
      'type' => 'select',
      'title' => t('Number of columns'),
      'tab' => 'section_content',
      'options' => [
        1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5',
        6 => '6',
      ],
      'default_value' => 3,
      'update_selector' => '.widget-content',
    ];

    // Header labels (fixed max 10)
    $form['headers_group'] = [
      'type' => 'group',
      'title' => t('Headers'),
      'tab' => 'section_content',
    ];

    for ($i = 1; $i <= 6; $i++) {
      $default_headers = [
        1 => 'Producto',
        2 => 'Precio',
        3 => 'Stock',
      ];
    
      $form['header_' . $i] = [
        'type' => 'text',
        'title' => t('Header @n', ['@n' => $i]),
        'tab' => 'section_content',
        'group' => 'headers_group',
        'default_value' => $default_headers[$i] ?? ' ',
        'wrapper' => FALSE,
        'translate_ai' => TRUE,
        // ojo: head--0 corresponde a header_1
        'update_selector' => '.head--' . ($i - 1),
      ];
    }

    // Rows repeater (each item is a row with up to 6 cells)
    $form['rows'] = [
      'type' => 'noahs_multiple_elements',
      'title' => t('Rows'),
      'tab' => 'section_content',
      'update_selector' => '.widget-content',
      'default_value' => [
        [
          'c1' => ['text' => 'Pan'],
          'c2' => ['text' => '1.20'],
          'c3' => ['text' => '24'],
        ],
        [
          'c1' => ['text' => 'Leche'],
          'c2' => ['text' => '0.90'],
          'c3' => ['text' => '18'],
        ],
      ],
      'fields' => [
        'row_tab' => [
          'type' => 'tab',
          'title' => t('Row'),
        ],
      ],
    ];

    // Add cells fields inside the row editor (fixed max 6)
    for ($i = 1; $i <= 6; $i++) {
      $form['rows']['fields']['c' . $i] = [
        'type' => 'text',
        'title' => t('Cell @n', ['@n' => $i]),
        'tab' => 'row_tab',
        'default_value' => ' ',
        'wrapper' => FALSE,
        'translate_ai' => TRUE,
        // [index] lo sustituye Noahs por 0,1,2... según la fila editada
        'update_selector' => '.row--[index] .cell--' . ($i - 1),
      ];
    }

    // --- Style tab
    $form['section_styles'] = [
      'type' => 'tab',
      'title' => t('Style'),
    ];

  //Text horizontal align
  $form['cell_text_align'] = [
  'type' => 'select',
  'title' => t('Text alignment'),
  'tab' => 'section_styles',
  'style_type' => 'style',
  'style_selector' => '.noahs--table--container th, .noahs--table--container td',
  'style_css' => 'text-align',
  'options' => [
    'left' => 'Left',
    'center' => 'Center',
    'right' => 'Right',
  ],
  'default_value' => 'left',
  'responsive' => TRUE,
  'style_hover' => FALSE,
  'update_selector' => '.widget-content',
];

    //Grupo background_color
    $form['background_group'] = [
      'type' => 'group',
      'title' => t('Background color'),
      'tab' => 'section_styles',
    ];
  
    $form['car_background_color_theader'] = [
      'type' => 'noahs_color',
      'title' => t('Header Background Color'),
      'tab' => 'section_styles',
      'group' => 'background_group',
      'style_type' => 'style',
      'style_selector' => '.noahs--table--container thead th',
      'style_css' => 'background-color',
      'style_hover' => TRUE,
    ];

    $form['car_background_color_tbody'] = [
      'type' => 'noahs_color',
      'title' => t('Table Body Background Color'),
      'tab' => 'section_styles',
      'group' => 'background_group',
      'style_type' => 'style',
      'style_selector' => '.noahs--table--container tbody td',
      'style_css' => 'background-color',
      'style_hover' => TRUE,
    ];
  
    //Borders group
    $form['borders_group'] = [
      'type' => 'group',
      'title' => t('Borders'),
      'tab' => 'section_styles',
    ];


    //Bordes exteriores
    $form['car_border'] = [
      'type' => 'noahs_border',
      'title' => t('Exterior border'),
      'tab' => 'section_styles',
      'group' => 'borders_group',
      'style_type' => 'style',
      'style_selector' => '.noahs--table--container table',
      'style_css' => 'border',
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];

    //Interior borders
    $form['car_cell_border'] = [
  'type' => 'noahs_border',
  'title' => t('Interior borders'),
  'tab' => 'section_styles',
  'group' => 'borders_group',
  'style_type' => 'style',
  'style_selector' => '.noahs--table--container th, .noahs--table--container td',
  'style_css' => 'border',
  'responsive' => TRUE,
  'style_hover' => TRUE,
];

// Border collapse vs separate
$form['car_border_collapse'] = [
  'type' => 'select',
  'title' => t('Border collapse'),
  'tab' => 'section_styles',
  'group' => 'borders_group',
  'style_type' => 'style',
  'style_selector' => '.noahs--table--container table',
  'style_css' => 'border-collapse',
  'options' => [
    'collapse' => 'collapse',
    'separate' => 'separate',
  ],
  'default_value' => 'collapse',
  'update_selector' => '.widget-content',
];

//Dejamos border-radius fuera: no funciona bien
/*
$form['card_radius'] = [
      'type' => 'noahs_radius',
      'title' => t('Border Radius'),
      'tab' => 'section_styles',
      'group' => 'borders_group',
      'style_type' => 'style',
      'style_selector' => '.noahs--table--container table',
      'responsive' => TRUE,
      'style_hover' => FALSE,
    ];
    */

    $form['card_margin'] = [
      'type' => 'noahs_margin',
      'title' => t('Margin'),
      'tab' => 'section_styles',
      'style_type' => 'style',
      'style_selector' => '.noahs--table--container',
      'style_css' => 'margin',
      'responsive' => TRUE,
      'style_hover' => FALSE,
    ];

    $form['card_padding'] = [
      'type' => 'noahs_padding',
      'title' => t('Padding'),
      'tab' => 'section_styles',
      'style_type' => 'style',
      'style_selector' => '.noahs--table--container th, .noahs--table--container td',
      'style_css' => 'padding',
      'responsive' => TRUE,
      'style_hover' => FALSE,
    ];

    $form['card_shadows'] = [
      'type' => 'noahs_shadows',
      'title' => t('Shadow'),
      'tab' => 'section_styles',
      'style_type' => 'style',
      'style_selector' => '.noahs--table--container table',
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];

    return $form;
  }

  //Function template: 1º) Prepare data, 2º) Process rows, 3º) Render HTML
  public function template($settings) {
  
    $element = $settings->element ?? new \stdClass();

    $columns_count = 3;  //3 columns as default value

    if (isset($element->columns_count)) {
      // Puede venir como stdClass/array/string; normalizamos.
      $columns_count_raw = $element->columns_count;
      $columns_count_txt = $this->normalizeText($columns_count_raw);
      $columns_count = (int) $columns_count_txt;
    }
    $columns_count = max(1, min(6, $columns_count));

    // Save header texts into array $headers[]
    $headers = [];
    for ($i = 1; $i <= $columns_count; $i++) {
      $prop = 'header_' . $i;
      $raw = $element->$prop ?? '';
      $headers[] = $this->normalizeText($raw);
    }

    // Rows repeater
    $raw_rows = $element->rows ?? NULL;
    if (empty($raw_rows)) {
      return '<div class="noahs-placeholder">' . t('Add rows to the table to see the content.') . '</div>';
    }

    // Convert stdClass -> array
    $rows_array = json_decode(json_encode($raw_rows), TRUE);


//--------------------------2º:process rows---------------------------------------------------------
    // Reindex items (element_0, element_1...) to 0, 1, etc. It is more convenient to process table rows
    $rows_items = [];
    foreach ($rows_array as $k => $item) {
      $rows_items[] = $item;
    }

    // $parsed_rows created: array of arrays: each row is an array which contains another array (all values of that row)
    $parsed_rows = [];
    foreach ($rows_items as $row) {
      $cells = [];
      $has_content = FALSE;

      for ($i = 1; $i <= $columns_count; $i++) {
        $key = 'c' . $i;  //build name of row (c1, c2, ...)
        $raw = $row[$key] ?? '';
        $val = $this->normalizeText($raw);

        if ($val !== '') {
          $has_content = TRUE;
        }
        $cells[] = $val;
      }

      if ($has_content) {
        $parsed_rows[] = $cells;
      }
    }

    if (empty($parsed_rows)) {
      return '<div class="noahs-placeholder">' . t('Fill at least one cell to display the table.') . '</div>';
    }

//-------------------3º: Render HTML-----------------------------------------------------
    $output  = '<div class="noahs--table--container">';
    $output .= '<table class="table">';

    // THEAD
    $output .= '<thead><tr>';
    for ($c = 0; $c < $columns_count; $c++) {
      $label = $headers[$c] ?? '';
      if ($label === '') {
        $label = ' ';
      }
      $output .= '<th class="head--' . $c . '">'
        . htmlspecialchars($label, ENT_QUOTES, 'UTF-8')
        . '</th>';
    }
    $output .= '</tr></thead>';

    // TBODY
    $output .= '<tbody>';
    foreach ($parsed_rows as $r_index => $cells) { 
      $output .= '<tr class="row--' . $r_index . '">';
      for ($c = 0; $c < $columns_count; $c++) { 
        $cell = $cells[$c] ?? ''; 
        $output .= '<td class="cell--' . $c . '">' 
        . htmlspecialchars($cell, ENT_QUOTES, 'UTF-8') . '</td>'; } 
        $output .= '</tr>'; 
        }
    $output .= '</tbody>';

    $output .= '</table></div>';

    return $output;
  }

  public function renderContent($element, $content = NULL, $entity = null) {
    return $this->wrapper($element, $this->template($element->settings));
  }

}