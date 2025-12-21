<?php

use Drupal\Core\Form\FormStateInterface;

/**
 * Implements hook_form_system_theme_settings_alter().
 */
function noahs_theme_form_system_theme_settings_alter(&$form, FormStateInterface $form_state) {
  // No activar #tree en la raíz; puede interferir con el submit core (logo, favicon).
  // Mantendremos #tree únicamente en nuestros grupos personalizados.

  $form['info_text'] = [
    '#type' => 'markup',
    '#markup' => t('<p>There are more options available in Noahs Settings, please check the admin interface <br><a class="button button--primary" href="/admin/structure/noahs/settings#tab-theme-tab"  target="_blank">Check it now</a></p>'),
    '#weight' => -100,
  ];
  // ================= Header =================
  $form['noahs_header'] = [
    '#type' => 'details',
    '#title' => t('Header'),
    '#open' => TRUE,
  '#tree' => TRUE,
  ];

  $form['noahs_header']['container'] = [
    '#type' => 'checkbox',
    '#title' => t('Container'),
    '#default_value' => theme_get_setting('noahs_header.container') ?? 0,
    '#weight' => -10,
  ];
  $form['noahs_header']['general_header_sticky'] = [
    '#type' => 'checkbox',
    '#title' => t('Header sticky'),
    '#default_value' => theme_get_setting('noahs_header.general_header_sticky') ?? 1,
  ];
    $form['noahs_header']['general_hide_top_header_sticky'] = [
    '#type' => 'checkbox',
    '#title' => t('Hide top header on sticky'),
    '#default_value' => theme_get_setting('noahs_header.general_hide_top_header_sticky') ?? 0,
  ];


  // ================= General =================
  $form['noahs_general'] = [
    '#type' => 'details',
    '#title' => t('General'),
    '#open' => FALSE,
  '#tree' => TRUE,
  ];
  
  $form['noahs_general']['animate_on_load'] = [
    '#type' => 'checkbox',
    '#title' => t('Enable animations on load'),
    '#default_value' => theme_get_setting('noahs_general.animate_on_load') ?? 0,
  ];
  
  // ================= Footer =================
  $form['noahs_footer'] = [
    '#type' => 'details',
    '#title' => t('Footer'),
    '#open' => FALSE,
  '#tree' => TRUE,
  ];
  $form['noahs_footer']['container'] = [
    '#type' => 'checkbox',
    '#title' => t('Container'),
    '#default_value' => theme_get_setting('noahs_footer.container') ?? 0,
  ];

  $form['noahs_footer']['footer_columns'] = [
    '#type' => 'select',
    '#title' => t('Columns'),
    '#options' => [
      'cols-2' => t('2 Columns'),
      'cols-3' => t('3 Columns'),
      'cols-4' => t('4 Columns'),
      'cols-5' => t('5 Columns'),
      'cols-6' => t('6 Columns'),
    ],
    '#default_value' => theme_get_setting('noahs_footer.footer_columns') ?? 'cols-4',
  ];

}

