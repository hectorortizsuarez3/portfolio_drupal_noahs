<?php

namespace Drupal\noahs_page_builder\Form;

use Drupal\file\Entity\File;
use Drupal\commerce_product\Entity\ProductType;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\node\Entity\NodeType;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\noahs_page_builder\Controller\NoahsController;
use Drupal\noahs_page_builder\Service\ControlServices;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\noahs_page_builder\Fonts;
use Drupal\editor\Entity\Editor;
use Drupal\taxonomy\Entity\Vocabulary;

/**
 * Defines a form that configures noahs_page_builder settings.
 */
class NoahsSettingsForm extends ConfigFormBase {

  use StringTranslationTrait;

  /**
   * Control services.
   *
   * @var \Drupal\noahs_page_builder\Service\ControlServices
   */
  protected $controlService;

  /**
   * Fonts.
   *
   * @var bool
   */
  protected $fonts = FALSE;

  /**
   * NoahsSaveStylesController constructor.
   *
   * @param \Drupal\noahs_page_builder\Service\ControlServices $control_service
   *   The control service.
   */
  public function __construct(ControlServices $control_service) {
    $this->controlService = $control_service;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('noahs_page_builder.control_service')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'noahs_page_builder_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['noahs_page_builder.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $settings = $this->config('noahs_page_builder.settings');
    $querys = $this->controlService->getMediaQuery();

    $form['#attached']['library'][] = 'noahs_page_builder/noahs_page_builder.assets.settings';
    $form['#attached']['library'][] = 'noahs_page_builder/noahs_page_builder.bootstrap';
    $pallete_color = [];
    $pallete_color[] = $settings->get('principal_color') ?? '#2389ab';
    $pallete_color[] = $settings->get('secondary_color') ?? '#4a4a4a';

    $custom_colors = $settings->get('custom_color') ?? [];

    foreach ($custom_colors as $color) {
      if (!empty($color['hex'])) {
        // Solo añadimos el HEX.
        $pallete_color[] = $color['hex'];
      }
    }

    $form['#attached']['drupalSettings']['noahs_page_builder']['pallete_color'] = $pallete_color;

    $node_types = NodeType::loadMultiple();
    $node_types_options = [];

    foreach ($node_types as $node_type) {
      $node_types_options[$node_type->id()] = $node_type->label();
    }

    $vocabularies = Vocabulary::loadMultiple();

    $vbo_options = [];

    foreach ($vocabularies as $vbo) {
      $vbo_options[$vbo->id()] = $vbo->label();
    }

    $commerce_options = [];
    if (is_module_installed('commerce')) {
      $commerce_types = ProductType::loadMultiple();
      foreach ($commerce_types as $product_type) {
        $commerce_options[$product_type->id()] = $product_type->label();
      }
    }
    $editors = Editor::loadMultiple();

    $editors_options = [];

    foreach ($editors as $k => $editor_type) {
      $editors_options[$k] = $k;
    }

    $form['custom_link'] = [
      '#type' => 'markup',
      '#markup' => $this->t('<a href=":url" class="button button--primary">Start creating general styles</a>', [
        ':url' => Url::fromRoute('noahs_page_builder.noahs_settings_styles', [], ['absolute' => TRUE])->toString(),
      ]),
      '#allowed_tags' => ['a'],
    ];

    /* =========================   General  ========================= */
    $form['general'] = [
      '#type' => 'details',
      '#title' => $this->t('General'),
      '#group' => 'tabs',
    ];

    $form['general']['develop_mode'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Develop mode'),
      '#default_value' => $settings->get('develop_mode') ? $settings->get('develop_mode') : '',
      '#description' => $this->t("Not save css cache"),
    ];

    $form['general']['use_editor'] = [
      '#type' => 'select',
      '#title' => $this->t('Select your CKEDITOR'),
      '#options' => $editors_options,
      '#default_value' => $settings->get('use_editor') ?? [],
      '#required' => TRUE,
    ];

    $form['general']['use_in_ctype'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Use in content type'),
      '#options' => $node_types_options,
      '#default_value' => $settings->get('use_in_ctype') ?? [],
    ];

    $form['general']['use_in_vtype'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Use in Vocabulary type'),
      '#options' => $vbo_options,
      '#default_value' => $settings->get('use_in_vtype') ?? [],
    ];

    $form['general']['use_in_products'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Use in Products type'),
      '#options' => $commerce_options,
      '#default_value' => $settings->get('use_in_products') ?? [],
    ];

    /* =========================   Container  ========================= */
    $form['style'] = [
      '#type' => 'details',
      '#title' => $this->t('Container & breackpoints'),
      '#group' => 'tabs',
    ];

    $form['style']['container_width'] = [
      '#type' => 'number',
      '#title' => 'Content Width',
      '#default_value' => $settings->get('container_width') ?? '',
      '#placeholder' => 1320,
      '#field_suffix' => 'px',
      '#description' => $this->t("Sets the default width of the content area (Default: 1320px)"),
    ];

    $form['style']['container_small'] = [
      '#type' => 'number',
      '#title' => 'Small Container Width',
      '#default_value' => $settings->get('container_small') ?? 720,
      '#placeholder' => 720,
      '#field_suffix' => 'px',
      '#description' => $this->t("Sets the small container width (Default: 720px)"),
    ];

    $form['style']['container_large'] = [
      '#type' => 'number',
      '#title' => 'Large Container Width',
      '#default_value' => $settings->get('container_large') ?? 960,
      '#placeholder' => 960,
      '#field_suffix' => 'px',
      '#description' => $this->t("Sets the large container width (Default: 960px)"),
    ];

    $form['style']['container_extra_large'] = [
      '#type' => 'number',
      '#title' => 'Extra Large Container Width',
      '#default_value' => $settings->get('container_extra_large') ?? 1140,
      '#placeholder' => 1140,
      '#field_suffix' => 'px',
      '#description' => $this->t("Sets the extra large container width (Default: 1140px)"),
    ];

    $form['style']['info'] = [
      '#type' => 'markup',
      '#markup' => '<h4>' . $this->t('Container & Breakpoints') . '</h4><p>' . $this->t("Set the container widths and breakpoints for responsive design.") . '</p>',
    ];

    $form['style']['viewport_tablet'] = [
      '#type' => 'number',
      '#title' => 'Tablet Breakpoint',
      '#default_value' => $settings->get('viewport_tablet') ?? 959,
      '#placeholder' => 959,
      '#field_suffix' => 'px',
      '#description' => $this->t("Sets the breakpoint to tablet devices (Default: 959px)."),
    ];

    $form['style']['viewport_mobile'] = [
      '#type' => 'number',
      '#title' => 'Mobile Breakpoint',
      '#default_value' => $settings->get('viewport_md') ?? 767,
      '#placeholder' => 767,
      '#field_suffix' => 'px',
      '#description' => $this->t("Sets the breakpoint to tablet devices (Default: 767px)."),
    ];


    /* =========================   Fonts  ========================= */
    $form['fonts'] = [
      '#type' => 'details',
      '#title' => $this->t('Fonts'),
      '#group' => 'tabs',
    ];

    $noahs_page_builder_fonts = Fonts::getFonts();
    $google_font_api = $settings->get('google_font_api') ? $settings->get('google_font_api') : '';
    $google_fonts = $this->getGoogleFonts($google_font_api);
    $available_fonts = Fonts::getFontsAvailables();


    $fonts = array_merge($noahs_page_builder_fonts, $google_fonts);

    // $form['fonts']['google_font_api'] = [
    //   '#type' => 'textfield',
    //   '#title' => $this->t('Google Font API'),
    //   '#default_value' => $google_font_api,
    //   '#description' => $this->t("Paste here your google font api. <a href='https://developers.google.com/fonts/docs/developer_api' target='_blank'>Get your API here</a>"),
    // ];
    // Lista de todas las fuentes disponibles como grupo de checkboxes, en columnas.
    
    $default_fonts = $settings->get('available_fonts') ?? [];  
    $default_fonts = array_filter($default_fonts, static function ($value) {
      return is_string($value);
    });
       // Quita valores vacíos
    $default_fonts = array_map('strval', $default_fonts); // Forzar strings

    if (empty($default_fonts)) {
      if (!empty($settings->get('heading_font')) && in_array($settings->get('heading_font'), $fonts)) {
        $default_fonts[] = $settings->get('heading_font');
      }

      if (!empty($settings->get('general_font')) && in_array($settings->get('general_font'), $fonts)) {
        $default_fonts[] = $settings->get('general_font');
      }
    }

    $form['fonts']['available_fonts'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Available fonts'),
      '#description' => $this->t('Select multiple fonts to use. These fonts will be available in the font selection dropdowns.'),
      '#options' => $fonts,
      '#default_value' => $default_fonts,
      '#prefix' => '<div class="noahs-checkbox-columns">',
      '#suffix' => '</div>',
    ];  


    $form['fonts']['heading_font'] = [
      '#type' => 'select',
      '#title' => $this->t('Headings front'),
      '#default_value' => $settings->get('heading_font') ?? 'Playfair Display',
      '#description' => $this->t("Set font to h1 - h2 - h3 - h4 - h5 - h6"),
      '#options' => $available_fonts,
      '#attributes' => ['class' => ['chosen-select']],
    ];

    $form['fonts']['general_font'] = [
      '#type' => 'select',
      '#title' => $this->t('General front'),
      '#default_value' => $settings->get('general_font') ?? 'Playfair Display',
      '#description' => $this->t("Set font to general body/html"),
      '#options' => $available_fonts,
      '#attributes' => ['class' => ['chosen-select']],
    ];

    // ============== Custom Fonts (multiple) ==============
    $form['fonts']['custom_fonts'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Custom Fonts'),
      '#tree' => TRUE,
      '#prefix' => '<div id="custom-fonts-wrapper">',
      '#suffix' => '</div>',
      '#description' => $this->t('Add your own fonts. Provide a display name, upload .woff/.woff2 files, and optional CSS. The CSS provided will be appended to the generated stylesheet.'),
    ];

    // Cargar fuentes personalizadas existentes desde config o state.
    $custom_fonts_state = $form_state->get('custom_fonts');
    if ($custom_fonts_state === NULL) {
      $custom_fonts_state = $settings->get('custom_fonts') ?? [];
      $form_state->set('custom_fonts', $custom_fonts_state);
    }

    // Asegurar que los selects de fuentes incluyan también los nombres añadidos
    // en esta sesión, antes del submit definitivo.
    // if (!empty($custom_fonts_state)) {
    //   $custom_font_names = [];
    //   foreach ($custom_fonts_state as $fdef) {
    //     if (!empty($fdef['name'])) {
    //       $custom_font_names[$fdef['name']] = $fdef['name'];
    //     }
    //   }
    //   if (!empty($custom_font_names)) {
    //     $fonts = $fonts + $custom_font_names; // unión que preserva claves existentes
    //     // Actualizar opciones de selects ya definidas.
    //     $form['fonts']['heading_font']['#options'] = $fonts;
    //     $form['fonts']['general_font']['#options'] = $fonts;
    //   }
    // }

    foreach ($custom_fonts_state as $idx => $fdef) {
      $form['fonts']['custom_fonts'][$idx] = [
        '#type' => 'fieldset',
        '#title' => $this->t('Font @num', ['@num' => $idx + 1]),
        '#attributes' => ['class' => ['noahs-custom-font']],
      ];
      $form['fonts']['custom_fonts'][$idx]['name'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Font Name (display name)'),
        '#default_value' => $fdef['name'] ?? '',
        '#required' => TRUE,
      ];
      $form['fonts']['custom_fonts'][$idx]['files'] = [
        '#type' => 'managed_file',
        '#title' => $this->t('Font files (.woff, .woff2)'),
        '#multiple' => TRUE,
        '#upload_location' => 'public://noahs/fonts',
        '#default_value' => isset($fdef['files']) && is_array($fdef['files']) ? array_values(array_filter($fdef['files'])) : [],
        '#upload_validators' => [
          'file_validate_extensions' => ['woff woff2'],
        ],
        '#description' => $this->t('Upload one or more font files to include.'),
      ];
      $form['fonts']['custom_fonts'][$idx]['css'] = [
        '#type' => 'textarea',
        '#title' => $this->t('Additional CSS (@font-face, etc.)'),
        '#default_value' => $fdef['css'] ?? '',
        '#description' => $this->t('Paste custom @font-face rules or overrides. This will be appended to the generated stylesheet.'),
        '#rows' => 5,
        '#attributes' => ['class' => ['noahs_page_builder_codemirror']],

      ];
      $form['fonts']['custom_fonts'][$idx]['remove'] = [
        '#type' => 'submit',
        '#value' => $this->t('Remove'),
        '#name' => 'remove_font_' . $idx,
        '#submit' => ['::removeFontCallback'],
        '#limit_validation_errors' => [],
        '#ajax' => [
          'callback' => '::updateFontPalette',
          'wrapper' => 'custom-fonts-wrapper',
        ],
      ];
    }
    $form['fonts']['custom_fonts']['add_font'] = [
      '#type' => 'submit',
      '#value' => $this->t('Add Font'),
      '#submit' => ['::addFontCallback'],
      '#limit_validation_errors' => [],
      '#ajax' => [
        'callback' => '::updateFontPalette',
        'wrapper' => 'custom-fonts-wrapper',
      ],
    ];

    /* =========================   Colors  ========================= */

    $form['colors'] = [
      '#type' => 'details',
      '#title' => $this->t('Default Colors'),
      '#group' => 'tabs',
    ];

    $form['colors']['palette'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Colors'),
      '#group' => 'colors',
    ];

    $form['colors']['palette']['principal_color'] = [
      '#type' => 'textfield',
      '#title' => 'Principal Color',
      '#default_value' => $settings->get('principal_color') ?? '',
      '#description' => $this->t("Set principal color, you can use this class .noahs-principal-color"),
      '#attributes' => ['class' => ['form-control-color']],
    ];

    $form['colors']['palette']['secondary_color'] = [
      '#type' => 'textfield',
      '#title' => 'Secondary Color',
      '#default_value' => $settings->get('secondary_color') ?? '',
      '#description' => $this->t("Set secondary color, you can use this class .noahs-secondary-color"),
      '#attributes' => ['class' => ['form-control-color']],
    ];

    // Contenedor para los colores dinámicos.
    $form['colors']['custom_color'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Custom Colors'),
      '#prefix' => '<div id="color-palette-wrapper">',
      '#suffix' => '</div>',
      '#description' => $this->t('Add your custom colors here. You can use these colors in the page builder. Use a class like .noahs-color- where "color-hex" is the name you set below, e.g., .noahs-color-ff5733'),
      '#tree' => TRUE,
    ];

    // Obtener colores desde el estado del formulario o configuración.
    $colors = $form_state->get('custom_color');
    if ($colors === NULL) {
      $colors = $settings->get('custom_color') ?? [];
      $form_state->set('custom_color', $colors);
    }

    // Agregar dinámicamente los colores guardados.
    foreach ($colors as $key => $color) {

      // 👈 El índice debe estar directamente aquí
      $form['colors']['custom_color'][$key] = [
        '#type' => 'fieldset',
        '#attributes' => ['class' => ['noahs-custom-colors']],
      ];

      $form['colors']['custom_color'][$key]['name'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Color Name'),
        '#default_value' => $color['name'] ?? '',
        '#required' => TRUE,
      ];

      $form['colors']['custom_color'][$key]['hex'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Color'),
        '#default_value' => $color['hex'] ?? '',
        '#required' => TRUE,
        '#attributes' => ['class' => ['form-control-color']],
      ];

      $form['colors']['custom_color'][$key]['remove'] = [
        '#type' => 'submit',
        '#value' => $this->t('Remove'),
        '#name' => 'remove_' . $key,
        '#submit' => ['::removeColorCallback'],
        '#limit_validation_errors' => [],
        '#ajax' => [
          'callback' => '::updateColorPalette',
          'wrapper' => 'color-palette-wrapper',
        ],
      ];
    }

    // Botón para agregar más colores.
    $form['colors']['custom_color']['add_color'] = [
      '#type' => 'submit',
      '#value' => $this->t('Add Color'),
      '#submit' => ['::addColorCallback'],
      '#limit_validation_errors' => [],
      '#ajax' => [
        'callback' => '::updateColorPalette',
        'wrapper' => 'color-palette-wrapper',
      ],
    ];

    /* =========================   Custom Css  ========================= */

    $form['custom_css'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Custom Css'),
      '#attributes' => ['style' => ['margin-top:25px']],
    ];

    $form['custom_css']['noahs_page_builder_custom_css'] = [
      '#type' => 'textarea',
      '#rows' => 15,
      '#cols' => 30,
      '#title' => $this->t('CSS Code'),
      '#default_value' => $settings->get('noahs_page_builder_custom_css'),
      '#description' => $this->t('Please enter custom scripts without  <b> @style </b> tag.', ["@style" => '<style>']) ,
      '#attributes' => ['class' => ['noahs_page_builder_codemirror']],
    // '#group' => 'custom_css',
    ];

    $form['custom_js'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Custom Js'),
      '#attributes' => ['style' => ['margin-top:25px']],
    ];

    $form['custom_js']['noahs_page_builder_custom_js'] = [
      '#type' => 'textarea',
      '#rows' => 15,
      '#cols' => 30,
      '#title' => $this->t('JS Code'),
      '#default_value' => $settings->get('noahs_page_builder_custom_js'),
      '#description' => $this->t('Please enter custom style without <b> @style </b> tag.', ["@style" => '<script>']) ,
      '#attributes' => ['class' => ['noahs_page_builder_codemirror_js']],
    // '#group' => 'custom_css',
    ];

    /* =========================   Theme  ========================= */
    $form['theme'] = [
      '#type' => 'details',
      '#title' => $this->t('Theme'),
      '#group' => 'tabs',
    ];

    // Header settings.
    $form['theme']['header'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Header'),
    ];

    // logo settings.
    $form['theme']['header']['logo_width'] = [
      '#type' => 'number',
      '#title' => $this->t('Logo width (px)'),
      '#default_value' => $settings->get('logo_width') ?? '',
    ];

    $form['theme']['header']['logo_mobile_width'] = [
      '#type' => 'number',
      '#title' => $this->t('Logo mobile width (px)'),
      '#default_value' => $settings->get('logo_mobile_width') ?? '',
    ];

    $form['theme']['header']['header_top_bg_color'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Top background color'),
      '#default_value' => $settings->get('header_top_bg_color') ?? '',
      '#attributes' => ['class' => ['form-control-color']],
    ];

    $form['theme']['header']['header_bg_color'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Background color'),
      '#default_value' => $settings->get('header_bg_color') ?? '',
      '#attributes' => ['class' => ['form-control-color']],
    ];

    $form['theme']['header']['header_text_color'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Text color'),
      '#default_value' => $settings->get('header_text_color') ?? '',
      '#attributes' => ['class' => ['form-control-color']],
    ];

    $form['theme']['header']['header_gap'] = [
      '#type' => 'number',
      '#title' => $this->t('Gap (px)'),
      '#default_value' => $settings->get('header_gap') ?? 16,
      '#field_suffix' => 'px',
    ];
    $form['theme']['header']['header_justify_content'] = [
      '#type' => 'select',
      '#title' => $this->t('Justify content'),
      '#options' => [
        'flex-start' => 'flex-start',
        'center' => 'center',
        'flex-end' => 'flex-end',
        'space-between' => 'space-between',
        'space-around' => 'space-around',
        'space-evenly' => 'space-evenly',
      ],
      '#default_value' => $settings->get('header_justify_content') ?? 'space-between',
    ];
    $form['theme']['header']['header_align_items'] = [
      '#type' => 'select',
      '#title' => $this->t('Align items'),
      '#options' => [
        'stretch' => 'stretch',
        'flex-start' => 'flex-start',
        'center' => 'center',
        'flex-end' => 'flex-end',
      ],
      '#default_value' => $settings->get('header_align_items') ?? 'center',
    ];

    // Footer settings.
    $form['theme']['footer'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Footer'),
    ];
    $form['theme']['footer']['footer_top_bg_color'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Top background color'),
      '#default_value' => $settings->get('footer_top_bg_color') ?? '',
      '#attributes' => ['class' => ['form-control-color']],
    ];
    $form['theme']['footer']['footer_bg_color'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Background color'),
      '#default_value' => $settings->get('footer_bg_color') ?? '',
      '#attributes' => ['class' => ['form-control-color']],
    ];
    
    $form['theme']['footer']['footer_text_color'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Text color'),
      '#default_value' => $settings->get('footer_text_color') ?? '',
      '#attributes' => ['class' => ['form-control-color']],
    ];

    $form['theme']['footer']['footer_column_gap'] = [
      '#type' => 'number',
      '#title' => $this->t('Column gap (px)'),
      '#default_value' => $settings->get('footer_column_gap') ?? 16,
      '#field_suffix' => 'px',
    ];

    $form['theme']['footer']['footer_justify_content'] = [
      '#type' => 'select',
      '#title' => $this->t('Justify content'),
      '#options' => [
        'flex-start' => 'flex-start',
        'center' => 'center',
        'flex-end' => 'flex-end',
        'space-between' => 'space-between',
        'space-around' => 'space-around',
        'space-evenly' => 'space-evenly',
      ],
      '#default_value' => $settings->get('footer_justify_content') ?? 'space-between',
    ];
    $form['theme']['footer']['footer_align_items'] = [
      '#type' => 'select',
      '#title' => $this->t('Align items'),
      '#options' => [
        'stretch' => 'stretch',
        'flex-start' => 'flex-start',
        'center' => 'center',
        'flex-end' => 'flex-end',
      ],
      '#default_value' => $settings->get('footer_align_items') ?? 'center',
    ];

    // Bootstrap tabs en lugar de vertical_tabs.
    unset($form['tabs']);

    $form['noahs_tabs'] = [
      '#type' => 'container',
      '#attributes' => [
        'class' => ['nav', 'nav-tabs'],
        'role' => 'tablist',
      ],
    ];
    $form['noahs_tabs']['tab_general'] = [
      '#markup' => '<a class="nav-link active" id="tab-general-tab" data-bs-toggle="tab" href="#tab-general" role="tab" aria-controls="tab-general" aria-selected="true">' . $this->t('General') . '</a>',
    ];
    $form['noahs_tabs']['tab_style'] = [
      '#markup' => '<a class="nav-link" id="tab-style-tab" data-bs-toggle="tab" href="#tab-style" role="tab" aria-controls="tab-style" aria-selected="false">' . $this->t('Container & breackpoints') . '</a>',
    ];
    $form['noahs_tabs']['tab_fonts'] = [
      '#markup' => '<a class="nav-link" id="tab-fonts-tab" data-bs-toggle="tab" href="#tab-fonts" role="tab" aria-controls="tab-fonts" aria-selected="false">' . $this->t('Fonts') . '</a>',
    ];
    $form['noahs_tabs']['tab_colors'] = [
      '#markup' => '<a class="nav-link" id="tab-colors-tab" data-bs-toggle="tab" href="#tab-colors" role="tab" aria-controls="tab-colors" aria-selected="false">' . $this->t('Default Colors') . '</a>',
    ];
    $form['noahs_tabs']['tab_theme'] = [
      '#markup' => '<a class="nav-link" id="tab-theme-tab" data-bs-toggle="tab" href="#tab-theme" role="tab" aria-controls="tab-theme" aria-selected="false">' . $this->t('Theme') . '</a>',
    ];
    $form['noahs_tabs']['tab_custom_css'] = [
      '#markup' => '<a class="nav-link" id="tab-custom-css-tab" data-bs-toggle="tab" href="#tab-custom-css" role="tab" aria-controls="tab-custom-css" aria-selected="false">' . $this->t('Custom Css') . '</a>',
    ];
    $form['noahs_tabs']['tab_custom_js'] = [
      '#markup' => '<a class="nav-link" id="tab-custom-js-tab" data-bs-toggle="tab" href="#tab-custom-js" role="tab" aria-controls="tab-custom-js" aria-selected="false">' . $this->t('Custom Js') . '</a>',
    ];


    $form['tab_content'] = [
      '#type' => 'container',
      '#attributes' => [
        'class' => ['tab-content', 'pt-3'],
      ],
    ];

    $groups = [
      'general' => 'tab-general',
      'style' => 'tab-style',
      'fonts' => 'tab-fonts',
      'colors' => 'tab-colors',
      'custom_css' => 'tab-custom-css',
      'custom_js' => 'tab-custom-js',
      'theme' => 'tab-theme',
    ];
    $first = TRUE;
    foreach ($groups as $key => $id) {
      if (isset($form[$key])) {
        $form['tab_content'][$key] = $form[$key];
        $form['tab_content'][$key]['#type'] = 'container';
        $form['tab_content'][$key]['#attributes']['class'] = $first ? ['tab-pane', 'fade', 'show', 'active'] : ['tab-pane', 'fade'];
        $form['tab_content'][$key]['#attributes']['id'] = $id;
        $form['tab_content'][$key]['#attributes']['role'] = 'tabpanel';
        $form['tab_content'][$key]['#attributes']['aria-labelledby'] = $id . '-tab';
        unset($form[$key]);
        $first = FALSE;
      }
    }

    return parent::buildForm($form, $form_state);
  }

  /**
   * Add color callback.
   *
   * @param array $form
   *   The form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The form state.
   */
  public function addColorCallback(array &$form, FormStateInterface $form_state) {
    // Obtener los colores actuales desde el estado del formulario.
    $colors = $form_state->get('custom_color') ?? [];

    // Agregar un nuevo color vacío.
    $colors[] = ['name' => '', 'hex' => '#000000'];

    // Guardar la nueva lista en el estado del formulario.
    $form_state->set('custom_color', $colors);

    // Forzar la reconstrucción del formulario.
    $form_state->setRebuild(TRUE);
  }

  /**
   * Remove color callback.
   *
   * @param array $form
   *   The form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The form state.
   */
  public function removeColorCallback(array &$form, FormStateInterface $form_state) {
    // Obtener el botón que fue presionado.
    $triggering_element = $form_state->getTriggeringElement();

    // Extraer el índice del color a eliminar.
    if (preg_match('/remove_(\d+)/', $triggering_element['#name'], $matches)) {
      $index = (int) $matches[1];

      // Obtener la lista de colores actual del estado del formulario.
      $colors = $form_state->get('custom_color') ?? [];

      // Eliminar el color si el índice es válido.
      if (isset($colors[$index])) {
        unset($colors[$index]);
        // Reindexar el array.
        $colors = array_values($colors);
      }

      // Guardar la lista actualizada de colores en el estado del formulario.
      $form_state->set('custom_color', $colors);

      // Marcar el formulario para ser reconstruido.
      $form_state->setRebuild(TRUE);
    }
  }

  /**
   * Update color palette.
   *
   * @param array $form
   *   The form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The form state.
   */
  public function updateColorPalette(array &$form, FormStateInterface $form_state) {
    // Cuando los grupos se mueven a tabs Bootstrap, el contenedor cambia de ruta.
    if (isset($form['tab_content']['colors']['custom_color'])) {
      return $form['tab_content']['colors']['custom_color'];
    }
    // Fallback por si no se han movido a tabs.
    return $form['colors']['custom_color'];
  }

  /**
   * AJAX: devuelve el wrapper de fuentes personalizadas.
   */
  public function updateFontPalette(array &$form, FormStateInterface $form_state) {
    if (isset($form['tab_content']['fonts']['custom_fonts'])) {
      return $form['tab_content']['fonts']['custom_fonts'];
    }
    return $form['fonts']['custom_fonts'];
  }

  /**
   * Añade una nueva fuente al estado.
   */
  public function addFontCallback(array &$form, FormStateInterface $form_state) {
    $fonts = $form_state->get('custom_fonts') ?? [];
    $fonts[] = ['name' => '', 'files' => [], 'css' => ''];
    $form_state->set('custom_fonts', $fonts);
    $form_state->setRebuild(TRUE);
  }

  /**
   * Elimina una fuente por índice.
   */
  public function removeFontCallback(array &$form, FormStateInterface $form_state) {
    $trigger = $form_state->getTriggeringElement();
    if (!empty($trigger['#name']) && preg_match('/remove_font_(\d+)/', $trigger['#name'], $m)) {
      $idx = (int) $m[1];
      $fonts = $form_state->get('custom_fonts') ?? [];
      if (isset($fonts[$idx])) {
        unset($fonts[$idx]);
        $fonts = array_values($fonts);
        $form_state->set('custom_fonts', $fonts);
      }
      $form_state->setRebuild(TRUE);
    }
  }

  /**
   * Get google fonts.
   *
   * @param string $api
   *   The api.
   *
   * @return array
   *   The options.
   */
  public function getGoogleFonts($api) {
    $options = [];
    $url = "https://www.googleapis.com/webfonts/v1/webfonts?key=" . $api;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_REFERER, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $result = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($result, TRUE);

    if (!$result['error']) {
      foreach ($result['items'] as $v) {

        $options[$v['family']] = $v['family'];
      }
    }

    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $container = $form_state->getValue('container_width') . 'px' ?? 'none';
    $styles = '';
    $pallete_color = '';
    $custom_colors = $form_state->getValue(['colors', 'custom_color']) ?? $form_state->getValue('custom_color') ?? [];
    
    
    foreach ($custom_colors as $color) {

      if (is_array($color) && !empty($color['hex'])) {
        $k = str_replace('#', '', $color['hex']);
        $pallete_color .= '--noahs_page_builder-' . $k . ': ' . $color['hex'] . ';';
        $styles .= '.noahs-color-' . $k . ' {background-color: ' . $color['hex'] . ' !important;}';
      }
    }

    $styles .= ':root {
      --noahs_page_builder-principal-color: ' . $form_state->getValue('principal_color') . ';
      --noahs_page_builder-secondary-color: ' . $form_state->getValue('secondary_color') . ';
      ' . $pallete_color . '
    }';
    // generamos clases de los colores personalizados

    $styles .= '.noahs-principal-color {background-color:' . $form_state->getValue('principal_color') . '!important;}';
    $styles .= '.noahs-secondary-color {background-color:' . $form_state->getValue('secondary_color') . '!important;}';

    // ===== Theme: Header & Footer =====
    $t_bg = $form_state->getValue('header_top_bg_color') ?? '';
    $h_bg = $form_state->getValue('header_bg_color') ?? '';
    $h_tx = $form_state->getValue('header_text_color') ?? '';
    $h_gap = (int) ($form_state->getValue('header_noahs_bottom_header') ?? 0);
    $h_just = $form_state->getValue('header_justify_content') ?? '';
    $h_align = $form_state->getValue('header_align_items') ?? '';

    $f_top_bg = $form_state->getValue('footer_top_bg_color') ?? '';
    $f_bg = $form_state->getValue('footer_bg_color') ?? '';
    $f_tx = $form_state->getValue('footer_text_color') ?? '';
    $f_gap = (int) ($form_state->getValue('footer_column_gap') ?? 0);
    $f_just = $form_state->getValue('footer_justify_content') ?? '';
    $f_align = $form_state->getValue('footer_align_items') ?? '';

    if (!empty($t_bg)) {
      $styles .= 'header.noahs-theme--header .noahs-top-header {background-color:' . $t_bg . ';}';
    }
    if (!empty($h_bg) || !empty($h_tx)) {
      $styles .= 'header.noahs-theme--header .noahs-bottom-header{';
      if (!empty($h_bg)) { $styles .= 'background-color:' . $h_bg . ';'; }
      if (!empty($h_tx)) { $styles .= 'color:' . $h_tx . ';'; }
      $styles .= '}';
    }
    if ($h_gap || $h_just || $h_align) {
      $styles .= 'header.noahs-theme--header .noahs-bottom-header{';
      if ($h_gap) { $styles .= 'gap:' . $h_gap . 'px;'; }
      if (!empty($h_just)) { $styles .= 'justify-content:' . $h_just . ';'; }
      if (!empty($h_align)) { $styles .= 'align-items:' . $h_align . ';'; }
      $styles .= '}';
    }
    if (!empty($f_top_bg)) {
      $styles .= 'footer .noahs-footer-top {background-color:' . $f_top_bg . ';}';
    }
    if (!empty($f_bg) || !empty($f_tx)) {
      $styles .= 'footer .noahs-footer-content{';
      if (!empty($f_bg)) { $styles .= 'background-color:' . $f_bg . ';'; }
      if (!empty($f_tx)) { $styles .= 'color:' . $f_tx . ';'; }
      $styles .= '}';
    }
    if ($f_gap || $f_just || $f_align) {
      $styles .= 'footer .noahs-footer-content{';
      if ($f_gap) { $styles .= 'gap:' . $f_gap . 'px;'; }
      if (!empty($f_just)) { $styles .= 'justify-content:' . $f_just . ';'; }
      if (!empty($f_align)) { $styles .= 'align-items:' . $f_align . ';'; }
      $styles .= '}';
    }

    $styles .= 'body{font-family:"' . $form_state->getValue('general_font') . '";}';
    $styles .= '.container{max-width:' . $container . ';}';
    $styles .= '.container-small{max-width:' . $form_state->getValue('container_small') . 'px !important;}';
    $styles .= '.container-large{max-width:' . $form_state->getValue('container_large') . 'px !important;}';
    $styles .= '.container-extra-large{max-width:' . $form_state->getValue('container_extra_large') . 'px !important;}';
    $styles .= 'h1, h2, h4, h4, h5, h6{';
    if (!empty($form_state->getValue('heading_color'))) {
      $styles .= 'color:' . $form_state->getValue('heading_color') . ';';
    }
    if (!empty($form_state->getValue('heading_font') || $form_state->getValue('general_font'))) {
      $styles .= 'font-family:"' . $form_state->getValue('heading_font') . '";' ?? $form_state->getValue('general_font') . '";';
    }
    $styles .= '}';
    
    $styles .= '.site-logo img {max-width:' . $form_state->getValue('logo_width') . 'px !important;}';
    $styles .= '@media (max-width: ' . $form_state->getValue('viewport_mobile') . 'px) {';
    $styles .= '.site-logo img {max-width:' . $form_state->getValue('logo_mobile_width') . 'px !important;}';
    $styles .= '}';


    // Fuentes personalizadas: marcar archivos permanentes, construir CSS si no se aporta, y guardar en config.
    $submitted_custom_fonts = $form_state->getValue(['fonts', 'custom_fonts']) ?? $form_state->getValue('custom_fonts') ?? [];
    $custom_fonts_to_save = [];
    foreach ($submitted_custom_fonts as $f) {
      // Evitar procesar valores no estructurados (botones, markup) que
      // pueden ser objetos TranslatableMarkup u otros tipos.
      if (!is_array($f)) {
        continue;
      }
      $name = trim($f['name'] ?? '');
      $fids = is_array($f['files'] ?? NULL) ? array_values(array_filter($f['files'])) : [];
      $css_extra = (string) ($f['css'] ?? '');
      $urls = [];
      foreach ($fids as $fid) {
        if ($file = File::load($fid)) {
          // Marcar permanente y registrar uso.
          if ($file->isTemporary()) {
            $file->setPermanent();
            $file->save();
          }
          \Drupal::service('file.usage')->add($file, 'noahs_page_builder', 'config', 0);
          $urls[] = \Drupal::service('file_url_generator')->generateAbsoluteString($file->getFileUri());
        }
      }
      // Si no hay CSS pero sí archivos, generamos una regla básica @font-face.
      if (empty($css_extra) && $name && !empty($urls)) {
        // Priorizar woff2 si existe.
        $srcParts = [];
        foreach ($urls as $u) {
          if (str_ends_with(strtolower($u), '.woff2')) {
            $srcParts[] = "url('{$u}') format('woff2')";
          }
        }
        foreach ($urls as $u) {
          if (str_ends_with(strtolower($u), '.woff')) {
            $srcParts[] = "url('{$u}') format('woff')";
          }
        }
        if (!empty($srcParts)) {
          $css_extra = "@font-face{font-family:'" . addslashes($name) . "';src:" . implode(',', $srcParts) . ";font-display:swap;}";
        }
      }
      if (!empty($css_extra)) {
        $styles .= "\n" . $css_extra . "\n";
      }
      $custom_fonts_to_save[] = [
        'name' => $name,
        'files' => $fids,
        'css' => $css_extra,
      ];
    }

    // CSS adicional del usuario.
    $styles .= $form_state->getValue('noahs_page_builder_custom_css');
    $js = $form_state->getValue('noahs_page_builder_custom_js');

    $theme = \Drupal::theme()->getActiveTheme()->getName();

    $noahsContrller = \Drupal::classResolver(NoahsController::class);
    $noahsContrller->saveCss('noahs_settings', 'noahs_general_settings', 'no_language', $styles);
    $noahsContrller->saveJs($js);

    $form_state->cleanValues();
    $values = $form_state->getValues();
    $config = $this->config('noahs_page_builder.settings');

    // Persistir custom_fonts explícitamente (estructura profunda).
    $this->config('noahs_page_builder.settings')->set('custom_fonts', $custom_fonts_to_save)->save();

    foreach ($values as $key => $value) {
      if (is_array($value)) {
        // Si es un array, se asume que son valores anidados.
        foreach ($value as $sub_key => $sub_value) {
          $config->set("$key.$sub_key", $sub_value);
        }
      }
      else {
        // Si no es un array, se asume un campo simple.
        $config->set($key, $value);
      }
    }

    $config->save();

    drupal_flush_all_caches();

    // drupal_flush_all_caches();
    return parent::submitForm($form, $form_state);
  }
}

