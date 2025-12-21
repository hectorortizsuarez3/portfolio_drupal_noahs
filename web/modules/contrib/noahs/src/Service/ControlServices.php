<?php

namespace Drupal\noahs_page_builder\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\Extension\ModuleHandlerInterface;

/**
 * Control services.
 */
class ControlServices {

  /**
   * The control plugin manager. 
   *
   * @var \Drupal\Core\Plugin\DefaultPluginManager
   */
  protected $controlManager;

  /**
   * The module handler service.
   *
   * @var \Drupal\Core\Extension\ModuleHandlerInterface
   */
  protected $moduleHandler;

  /**
   * Constructs a new ControlServices object.
   *
   * @param \Drupal\Core\Plugin\DefaultPluginManager $control_manager
   *   The control plugin manager.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler service.
   */
  public function __construct(DefaultPluginManager $control_manager, ModuleHandlerInterface $module_handler) {
    $this->controlManager = $control_manager;
    $this->moduleHandler = $module_handler;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('plugin.manager.control'),
      $container->get('module_handler'),
      );
  }

  /**
   * Get control by id.
   *
   * @param string $control_id
   *   The control id.
   *
   * @return \Drupal\noahs_page_builder\Plugin\Control\ControlInterface
   *   The control.
   */
  public function getControlById($control_id) {
    if ($this->controlManager->hasDefinition($control_id)) {

      $control = $this->controlManager->createInstance($control_id);

      return $control;
    }
  }

  /**
   * Generate html.
   *
   * @param array $data
   *   The data.
   * @param array $values
   *   The values.
   * @param string $name
   *   The name.
   * @param string $value
   *   The value.
   * @param string $wrapper
   *   The wrapper.
   * @param string $delta
   *   The delta.
   *
   * @return string
   *   The html.
   */
  public function generateHtml($data, $values, $name, $value, $wrapper, $delta = NULL) {
    if ($data) {
      $state = !empty($data['item']['state']) ? htmlspecialchars(json_encode($data['item']['state']), ENT_QUOTES, 'UTF-8') : NULL;

      $content = $this->getContent($data, $name, $value, $delta);
      $open = !empty($data['item']['open']) ? 'show' : '';
      $output = '';

      if (isset($data['item']['wrapper']) && $data['item']['wrapper'] === FALSE) {
        $output .= '<div class="noahs_page_builder_field field__' . $data['item']['type'] . ' noahs_page_builder_field__static without-wrapper" data-field-state="' . $state . '" data-field-name="' . $data['item_id'] . '">';
        if ($data['item']['type'] != 'checkbox') {
          if (!empty($data['item']['title'])) {
            $output .= '<label>' . $data['item']['title'] . '</label>';
          }
        }
        $output .= $content;
        $output .= '</div>';
      }
      else {
        $output .= '<div class="noahs_page_builder_field field__' . $data['item']['type'] . ' noahs_page_builder_field__static" data-field-state="' . $state . '" data-field-name="' . $data['item_id'] . '">';
        $output .= '<h5 class="d-flex justify-content-between expand-field" data-bs-toggle="collapse" href="#collapse_' . $data['item_id'] . $delta . '" role="button" aria-expanded="false" aria-controls="' . $data['item_id'] . $delta . '">';
        $output .= $data['item']['title'] . '<i class="fa-solid fa-caret-down"></i>';
        $output .= '</h5>';
        $output .= '<div class="collapse ' . $open . '" id="collapse_' . $data['item_id'] . $delta . '">';
        $output .= '<div class="field-static-wrapper">';
        $output .= $content;
        if (!empty($data['item']['description'])) {
          $output .= '<div class="nohas-field-description">' . $data['item']['description'] . '</div>';
        }
        $output .= '</div>';
        $output .= '</div>';

        $output .= '</div>';
      }

      return $output;
    }
  }

  /**
   * Get html controls.
   *
   * @param array $data
   *   The data.
   * @param array $values
   *   The values.
   * @param string $wrapper
   *   The wrapper.
   * @param string $delta
   *   The delta.
   *
   * @return string
   *   The html.
   */
  public function extractHtml($data, $values, $wrapper, $delta = NULL) {
    if ($data) {
       
      // Procesamos los sub field de un multple elemento.
      if ($data['item']['type'] === 'noahs_multiple_elements') {
        // dump($data);
        // dump($data['item']['type']);
        // dump($data['items']['fields']);
        // dump($values);
        // $values[$data['item_id']]['sub_elements'] = $values[$data['item_id']];
        // $values[$data['item_id']]['css'] = $data['values']['element']['css']['desktop']['hover'][$data['item_id']];
      }

      // dump($values['css']);
      $state = !empty($data['item']['state']) ? htmlspecialchars(json_encode($data['item']['state']), ENT_QUOTES, 'UTF-8') : NULL;
      $control_id = $data['item']['type'];

      $control = $this->getControlById($control_id);

      $name = 'element[' . $data['item_id'] . ']';
     
 
      if (isset($data['parent'])) {
        $value = !empty($data['values'][$data['item_id']]) ? $data['values'][$data['item_id']] : NULL;
        $name = 'element[' . $data['parent'] . '][element_' . $data['delta'] . '][' . $data['item_id'] . ']';
      }else{
        $value = !empty($values[$data['item_id']]) ? $values[$data['item_id']] : NULL;
      }

      $html = $this->generateHtml($data, $values, $name, $value, $wrapper, $data['delta']);

      if (!empty($data['item']['style_type'])) {

        if ($data['item']['style_type'] === 'style') {

          $name = 'element[css][desktop][default][' . $data['item_id'] . ']';
         
          if (isset($data['parent'])) {

            $name = 'element[css][desktop][default][' . $data['parent'] . '][' . $data['item_id'] . '][element_' . $data['delta'] . ']';
            $value = !empty($data['values']['css']['desktop']['default'][$data['parent']][$data['item_id']]['element_' . $data['delta']]) ? $data['values']['css']['desktop']['default'][$data['parent']][$data['item_id']]['element_' . $data['delta']] : NULL;

          }else{
             $value = !empty($values['css']['desktop']['default'][$data['item_id']]) ? $values['css']['desktop']['default'][$data['item_id']] : NULL;
          }
          $html = $this->generateHtml($data, $values, $name, $value, $wrapper, $data['delta']);

        }
        elseif ($data['item']['style_type'] === 'class') {
          $name = 'element[class][' . $data['item_id'] . ']';
          $value = !empty($values['class'][$data['item_id']]) ? $values['class'][$data['item_id']] : NULL;
          if (isset($data['parent'])) {
            $name = 'element[' . $data['parent'] . '][element_' . $data['delta'] . '][class][' . $data['item_id'] . ']';
            $value = !empty($values['class'][$data['item_id']]) ? $values['class'][$data['item_id']] : NULL;
          }
          $html = $this->generateHtml($data, $values, $name, $value, $wrapper, $data['delta']);

        }
        elseif ($data['item']['style_type'] === 'attribute') {
          $name = 'element[attribute][' . $data['item_id'] . ']';
          $value = $values['attribute'][$data['item_id']] ?? NULL;
          if (isset($data['parent'])) {
            $name = 'element[' . $data['parent'] . '][element_' . $data['delta'] . '][attribute][' . $data['item_id'] . ']';
            $value = !empty($values['attribute'][$data['item_id']]) ? $values['attribute'][$data['item_id']] : NULL;
          }
          $html = $this->generateHtml($data, $values, $name, $value, $wrapper, $data['delta']);
        }
      }

      if ($data['item']['type'] === 'info' || $data['item']['type'] === 'html' || $data['item']['type'] === 'noahs_page_builder_gallery') {
        $html = $this->getContent($data, $name, $value, $data['delta']);
      }

      if ($data['item']['type'] === 'textarea') {
        $name = 'element[' . $data['item_id'] . ']';

        if (isset($data['parent'])) {
          $name = 'element[' . $data['parent'] . '][element_' . $data['delta'] . '][' . $data['item_id'] . ']';
        }
        $html = $this->generateHtml($data, $values, $name, $value, $wrapper, $data['delta']);

      }

      $content = $this->getContent($data, $name, $value, $data['delta']);
      if (!empty($data['item']['responsive'])) {
        if (!empty($data['item']['style_hover'])) {
        

            return $this->hoverHtml($data, $content, $values, $wrapper);

          
        }
        else {
          return $this->responsiveHtml($data, $content, NULL, $values, TRUE, $wrapper);
        }
      }
      elseif (!empty($data['item']['style_hover'])) {

        return $this->hoverHtml($data, $content, $values, $wrapper);
      }

      return $html;
    }
  }

  /**
   * Get content.
   *
   * @param array $data
   *   The data.
   * @param string $name
   *   The name.
   * @param string $value
   *   The value.
   * @param string $delta
   *   The delta.
   * @param string $mediaquery
   *   The mediaquery.
   * @param string $hover
   *   The hover.
   *
   * @return string
   *   The content.
   */
  protected function getContent($data, $name, $value = NULL, $delta = NULL, $mediaquery = NULL, $hover = NULL) {

    if ($data) {

      $control_id = $data['item']['type'];
      $control = $this->getControlById($control_id);

      // $value = (!isset($value) && !empty($data['item']['default_value'])) ? $data['item']['default_value'] : $value;
      $value = !empty($value) ? $value : (!empty($data['item']['default_value']) ? $data['item']['default_value'] : NULL);

      $attributes = [];
      $attributes[] = !empty($data['item']['type']) ? 'data-control-type="' . $data['item']['type'] . '"' : '';
      $attributes[] = !empty($data['item']['style_type']) ? 'data-style-type="' . $data['item']['style_type'] . '"' : '';

      if (!empty($data['item']['style_selector'])) {
        if (strpos($data['item']['style_selector'], '[index]') !== FALSE) {
          $attr_selector = str_replace('[index]', $delta, $data['item']['style_selector']);
          $attributes[] = !empty($data['item']['style_selector']) ? 'data-style-selector="' . $attr_selector . '"' : '';
        }
        else {
          $attributes[] = !empty($data['item']['style_selector']) ? 'data-style-selector="' . $data['item']['style_selector'] . '"' : '';
        }
      }

      $attributes[] = !empty($data['item']['skip']) ? 'data-skip-field="true"' : '';
      $attributes[] = !empty($data['item']['style_css']) ? 'data-style-css="' . $data['item']['style_css'] . '"' : '';
      $attributes[] = !empty($data['item']['attribute_type']) ? 'data-attribute-type="' . $data['item']['attribute_type'] . '"' : '';
      $attributes[] = !empty($hover) ? 'data-style-hover="' . $hover . '"' : '';
      $attributes[] = !empty($mediaquery) ? 'data-responsive="' . $mediaquery . '"' : '';
      $attributes = implode(" ", $attributes);
      $content = '<div class="noahs-input--control-css" ' . $attributes . '>';

      $content .= $control->contentTemplate(
        [
          'data' => $data,
          'name' => $name,
          'value' => $value,
          'delta' => $delta,
        ]
      );
      // $content .= $control->contentTemplate($data, $name, $value, $data['delta']);
      $content .= '</div>';

      return $content;
    }
  }

  /**
   * Tabs hover html.
   *
   * @param array $data
   *   The data.
   * @param array $hover_status
   *   The hover status.
   *
   * @return string
   *   The html.
   */
  public function tabsHoverHtml($data, $hover_status): string {

    $html_hover = '<div class="hover_tabs btn-group d-flex mb-2">';

    $icon = '<i class="las la-mouse-pointer"></i>';
    foreach ($hover_status as $key_status => $status) {
      if ($key_status === 'hover') {
        $icon = '<i class="las la-hand-pointer"></i>';
      }
      $html_hover .= '<a href="#hover_tab_' . $data['item_id'] . $key_status . '" class="hover_tabs-tab btn" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="' . $status . '">' . $icon . $status . '</a>';
    }

    $html_hover .= '</div>';
    return $html_hover;
  }

  /**
   * Hover html.
   *
   * @param array $data
   *   The data.
   * @param string $content
   *   The content.
   * @param array $values
   *   The values.
   * @param string $wrapper
   *   The wrapper.
   *
   * @return string
   *   The html.
   */
  public function hoverHtml(array $data, $content, $values, $wrapper): ?string {
    if ($data) {

      $control_id = $data['item']['type'];
      $control = $this->getControlById($control_id);
      $hover_status = [
        'default' => t('Default'),
        'hover' => t('Hover'),
        // 'focus' => t('Focus'),
        // 'active' => t('Active')
      ];
      $state = !empty($data['item']['state']) ? htmlspecialchars(json_encode($data['item']['state']), ENT_QUOTES, 'UTF-8') : NULL;
      $open = !empty($data['item']['open']) ? 'show' : '';
      $responsive_class = 'without-responsive-tabs';
      if (!empty($data['item']['responsive'])) {
        $responsive_class = 'contain-responsive-tabs';
      }
      $html_hover = '';
      $html_hover .= '<div class="field__hover noahs_page_builder_field ' . $responsive_class . '"
                     data-field-state="' . $state . '"
                     data-field-name="' . $data['item_id'] . '">';
      $html_hover .= '<h5 class="d-flex justify-content-between expand-field" data-bs-toggle="collapse" href="#collapse_' . $data['item_id'] . '" role="button" aria-expanded="false" aria-controls="' . $data['item_id'] . '">' . $data['item']['title'] . '<i class="fa-solid fa-caret-down"></i></h5>';
      $html_hover .= '<div class="collapse ' . $open . '" id="collapse_' . $data['item_id'] . '">';
      $html_hover .= '<div class="hover-field-wrapper">';

      $html_hover .= $this->tabsHoverHtml($data, $hover_status);
      foreach ($hover_status as $key_status => $status) {

        $html_hover .= '<div class="field__hover-content rounded" id="hover_tab_' . $data['item_id'] . $key_status . '" data-hover-status="' . $key_status . '">';
        if (!empty($data['item']['responsive'])) {
          $name = 'element[css][desktop][' . $key_status . '][' . $data['item_id'] . ']';
          $value = $values['css']['desktop'][$key_status][$data['item_id']] ?? '';
          $content = $this->getContent($data, $name, $value, '', 'desktop', $key_status);
          $html_hover .= $this->responsiveHtml($data, $content, $key_status, $values, FALSE, $wrapper);
        }
        else {
          $name = 'element[css][desktop][' . $key_status . '][' . $data['item_id'] . ']';
          $value = $values['css']['desktop'][$key_status][$data['item_id']] ?? '';
          
          // Adjust for parent if exists
          if (isset($data['parent'])) {
            $name = 'element[css][desktop][' . $key_status . '][' . $data['parent'] . '][' . $data['item_id'] . '][element_' . $data['delta'] . ']';
            $value = !empty($data['values']['css']['desktop'][$key_status][$data['parent']][$data['item_id']]['element_' . $data['delta']]) ? $data['values']['css']['desktop'][$key_status][$data['parent']][$data['item_id']]['element_' . $data['delta']] : NULL;
          }

          $content = $this->getContent($data, $name, $value, '', 'desktop', $key_status);
          $html_hover .= $content;
        }
        $html_hover .= '</div>';
      }
      $html_hover .= '</div>';
      $html_hover .= '</div>';
      $html_hover .= '</div>';
      return $html_hover;
    }
    return NULL;
  }

  /**
   * Tabs responsive html.
   *
   * @return string
   *   The html.
   */
  public function tabsresponsiveHtml(): string {

    $responsive = '<div class="responsive__tabs">';
    $responsive .= '<div class="responsive__tabs__wrapper">';

    foreach (self::getMediaQuery() as $k => $query) {
      $icon = '<i class="las la-mobile-alt"></i>';
      if ($k === 'tablet') {
        $icon = '<i class="las la-tablet-alt"></i>';
      }
      if ($k === 'desktop') {
        $icon = '<i class="las la-desktop"></i>';
      }
      $responsive .= '<a href="#responsive_tab_' . $k . '" class="responsive_tabs-tab responsive_tabs_tab_' . $k . '" data-query="' . $k . '" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="' . $k . '">' . $icon . '</a>';
    }

    $responsive .= '</div>';
    $responsive .= '</div>';
    return $responsive;
  }

  /**
   * Responsive html.
   *
   * @param array $data
   *   The data.
   * @param string $content
   *   The content.
   * @param string $hover_status
   *   The hover status.
   * @param array $values
   *   The values.
   * @param bool $hover
   *   The hover.
   * @param string $wrapper
   *   The wrapper.
   *
   * @return string
   *   The html.
   */
  public function responsiveHtml(array $data, $content, $hover_status, $values, $hover, $wrapper): ?string {
    if ($data) {
      $open = !empty($data['item']['open']) ? 'show' : '';
      $active_class = !empty($data['item']['open']) ? 'active' : '';
      $control_id = $data['item']['type'];
      $control = $this->getControlById($control_id);
      $state = !empty($data['item']['state']) ? htmlspecialchars(json_encode($data['item']['state']), ENT_QUOTES, 'UTF-8') : NULL;
      $responsive = '';
      $hover_class = ($hover) ? 'hover' : NULL;
      $responsive .= '<div class="noahs_page_builder_field noahs_page_builder_field__responsive ' . $hover_class . ' ' . $active_class . ' field__group field__' . $data['item']['type'] . '"
            data-field-state="' . $state . '"
            data-field-name="' . $data['item_id'] . '">';

      if ($hover) {
        $responsive .= '<h5 class="d-flex justify-content-between expand-field" data-bs-toggle="collapse" href="#collapse_' . $data['item_id'] . '" role="button" aria-expanded="true" aria-controls="' . $data['item_id'] . '">' . $data['item']['title'] . $this->tabsresponsiveHtml() . '<i class="fa-solid fa-caret-down"></i></h5>';
      }
      else {
        $responsive .= $this->tabsresponsiveHtml();
      }

      if ($hover) {
        $responsive .= '<div class="collapse ' . $open . '" id="collapse_' . $data['item_id'] . '">';
        $responsive .= '<div class="responsive-field-wrapper">';
      }

      foreach (self::getMediaQuery() as $k => $query) {

        $name = 'element[css][' . $k . '][default][' . $data['item_id'] . ']';
        $value = (!empty($values['css'][$k]['default'][$data['item_id']]) ? $values['css'][$k]['default'][$data['item_id']] : '');

        if (isset($data['parent'])) {
          $name = 'element[css][' . $k . '][default][' . $data['parent'] . '][' . $data['item_id'] . '][element_' . $data['delta'] . ']';
          $value = !empty($data['values']['css'][$k]['default'][$data['parent']][$data['item_id']]['element_' . $data['delta']]) ? $data['values']['css'][$k]['default'][$data['parent']][$data['item_id']]['element_' . $data['delta']] : NULL;

          // $value = (!empty($values['css'][$k]['default'][$data['parent']][$data['item_id']]['element_' . $data['delta']]) ? $values['css'][$k]['default'][$data['parent']][$data['item_id']]['element_' . $data['delta']] : '');
        }

        if ($hover_status) {
          $name = 'element[css][' . $k . '][' . $hover_status . '][' . $data['item_id'] . ']';
          $value = (!empty($values['css'][$k][$hover_status][$data['item_id']]) ? $values['css'][$k][$hover_status][$data['item_id']] : '');
          if (isset($data['parent'])) {
            $name = 'element[css][' . $k . '][' . $hover_status . '][' . $data['parent'] . '][' . $data['item_id'] . '][element_' . $data['delta'] . ']';
            $value = !empty($data['values']['css'][$k][$hover_status][$data['parent']][$data['item_id']]['element_' . $data['delta']]) ? $data['values']['css'][$k][$hover_status][$data['parent']][$data['item_id']]['element_' . $data['delta']] : NULL;

            // $value = (!empty($values['css'][$k][$hover_status][$data['parent']][$data['item_id']]['element_' . $data['delta']]) ? $values['css'][$k][$hover_status][$data['parent']][$data['item_id']]['element_' . $data['delta']] : '');
          }
        }

        // If desktop version.
        if ($k === 'desktop' && !empty($value)) {
          $data['item']['placeholder'] = $value;

        }
        // If tablet version.
        if ($k === 'tablet' && !empty($value)) {
          $data['item']['placeholder'] = $value;

        }
        switch ($k) {
          case 'desktop':
            $icon = '<i class="las la-desktop"></i>';
            break;

          case 'tablet':
            $icon = '<i class="las la-tablet-alt"></i>';
            break;

          default:
            $icon = '<i class="las la-mobile-alt"></i>';
            break;
        }
        $content = $this->getContent($data, $name, $value, $data['delta'], $k, $hover_status);

        $responsive .=
        '<div class="field-wrapper field-wrapper-responsive-' . $k . '" data-mediaquery="' . $k . '" id="responsive_tab_' . $k . '" data-responsive-status="' . $k . '">
          <div class="strong responsive-status">' . $icon . ' ' . $k . '</div>
            ' . $content . '
        </div>';
      }

      $responsive .= '</div>';

      if ($hover) {
        $responsive .= '</div>';
        $responsive .= '</div>';
      }

      return $responsive;
    }
    return NULL;
  }

  /**
   * Get default fields .
   *
   * @return array
   *   The form.
   */
  public function defaultFields(): array {
    $form = [];
    // Section Styles.
    $form['section_extras'] = [
      'type' => 'tab',
      'title' => t('Extras'),
      'weight' => 9,
    ];

    $form['group_extra'] = [
      'type' => 'group',
      'title' => t('Space & Custom Class'),
      'tab'     => 'section_extras',
      'open' => TRUE,
    ];
    $form['margin'] = [
      'type'     => 'noahs_margin',
      'title'    => t('Margin'),
      'tab'     => 'section_extras',
      'style_type' => 'style',
      'style_selector' => 'widget',
      'style_css' => 'margin',
      'responsive' => TRUE,
      'style_hover' => TRUE,
      'open' => TRUE,
      'group' => 'group_extra',
    ];
    $form['padding'] = [
      'type'     => 'noahs_padding',
      'title'    => t('Padding'),
      'tab'     => 'section_extras',
      'style_type' => 'style',
      'style_selector' => 'widget',
      'style_css' => 'padding',
      'responsive' => TRUE,
      'style_hover' => TRUE,
      'open' => TRUE,
      'group' => 'group_extra',
    ];
    $form['element_class'] = [
      'type'    => 'text',
      'title'   => ('Custom CSS classes'),
      'style_type' => 'class',
      'style_selector' => 'widget',
      'tab' => 'section_extras',
      'placeholder' => 'Multiple classes should be separated with SPACE.',
      'group' => 'group_extra',
      'wrapper' => FALSE,
    ];

    $form['element_inner_class'] = [
      'type'    => 'text',
      'title'   => ('Custom for element inner CSS classes'),
      'style_type' => 'class',
      'style_selector' => '.widget-wrapper',
      'placeholder'    => ('Multiple classes should be separated with SPACE.'),
      'tab' => 'section_extras',
      'group' => 'group_extra',
    ];
    $form['border'] = [
      'type'        => 'noahs_border',
      'title'       => t('Border'),
      'tab'     => 'section_extras',
      'style_type' => 'style',
      'style_selector' => 'widget',
      'style_css' => 'border',
      'style_hover' => TRUE,
      'responsive' => TRUE,
    ];

    $form['hidden_element'] = [
      'type'    => 'noahs_group_checkbox',
      'title'   => t('Hide Element'),
      'tab' => 'section_extras',
      'style_type' => 'class',
      'style_selector' => 'widget',
      'options' => [
        'hidden-xs' => t('Hide on mobile'),
        'hidden-md' => t('Hide on Tablet'),
        'hidden-lg' => t('Hide on desktop'),
      ],
    ];

    /*
    $form['hidden_element_if_loggedin'] = [
    'type'    => 'noahs_group_checkbox',
    'title'   => t('Hide Element'),
    'tab' => 'section_extras',
    'style_type' => 'class',
    'style_selector' => 'widget',
    'options' => [
    'hidden-xs' => t('Hide on mobile'),
    'hidden-md' => t('Hide on Tablet'),
    'hidden-lg' => t('Hide on desktop'),
    ]

    ];
     */
    $form['display_element'] = [
      'type'    => 'select',
      'title'   => ('Display Element'),
      'options' => [
        '' => t('Flex'),
        'block' => t('Block'),
        'inline' => t('Inline'),
        'inline-block' => t('Inline Block'),
        'inline-flex' => t('Inline Flex'),
        'table' => t('Table'),
        'table-cell' => t('Table Cell'),
        'grid' => t('Grid'),
        'list-item' => t('List Item'),
        'run-in' => t('Run In'),
        'flow-root' => t('Flow Root'),
        'contents' => t('Contents'),
        'none' => t('None'),
      ],
      'style_type' => 'style',
      'style_selector' => 'widget',
      'style_css' => 'display',
      'tab' => 'section_extras',
      'responsive' => TRUE,
    ];

    $form['custom_width_group'] = [
      'type' => 'group',
      'title' => t('Custom Width'),
      'tab'     => 'section_extras',
    ];
    $form['custom_width_element'] = [
      'type'    => 'text',
      'title'   => t('Max Width'),
      'tab' => 'section_extras',
      'group' => 'custom_width_group',
      'style_type' => 'style',
      'style_css' => 'max-width',
      'style_selector' => 'widget',
      'responsive' => TRUE,
      'wrapper' => FALSE,
    ];
    $form['custom_width_widget'] = [
      'type'    => 'text',
      'title'   => t('Width'),
      'tab' => 'section_extras',
      'group' => 'custom_width_group',
      'style_type' => 'style',
      'style_css' => 'width',
      'style_selector' => 'widget',
      'responsive' => TRUE,
      'wrapper' => FALSE,
    ];

    $form['widget_box_shadows'] = [
      'type'    => 'noahs_shadows',
      'title'   => t('Shadow'),
      'tab' => 'section_extras',
      'style_type' => 'style',
      'style_selector' => 'widget',
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];
    $form['widget_border_radius'] = [
      'type'    => 'noahs_radius',
      'title'   => t('Border Radius'),
      'tab' => 'section_extras',
      'style_type' => 'style',
      'style_selector' => 'widget',
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];

    $form['position_extra'] = [
      'type' => 'group',
      'title' => t('Position'),
      'tab'     => 'section_extras',
    ];
    $form['index'] = [
      'type'    => 'number',
      'title'   => ('z Index'),
      'style_type' => 'style',
      'style_css' => 'z-index',
      'style_selector' => 'widget',
      'tab' => 'section_extras',
      'placeholder' => 'Level',
      'group' => 'position_extra',
      'wrapper' => FALSE,
    ];
    $form['element_position'] = [
      'type'    => 'select',
      'title'   => ('Position'),
      'options' => [
        '' => t('Default'),
        'relative' => t('Relative'),
        'static' => t('Static'),
        'absolute' => t('Absolute'),
        'sticky' => t('Sticky'),
      ],
      'style_type' => 'style',
      'style_selector' => 'widget',
      'style_css' => 'position',
      'tab' => 'section_extras',
      'group' => 'position_extra',
      'responsive' => TRUE,
    ];

    $form['element_position_coordinates'] = [
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
      'tab' => 'section_extras',
      'group' => 'position_extra',
      'style_type' => 'style',
      'style_selector' => 'widget',
      'style_css' => 'position',
      'responsive' => TRUE,
    ];

    $form['transition_extra'] = [
      'type' => 'group',
      'title' => t('Transition element'),
      'tab'     => 'section_extras',
    ];

    $form['element_transition_duration'] = [
      'type'    => 'text',
      'title'   => ('Duration'),
      'style_selector' => '.element-transition',
      'style_type' => 'style',
      'style_css' => 'transition-duration',
      'tab' => 'section_extras',
      'group' => 'transition_extra',
    ];
    $form['element_transition_property'] = [
      'type'    => 'text',
      'title'   => ('Propery'),
      'style_selector' => '.element-transition',
      'style_type' => 'style',
      'style_css' => 'transition-property',
      'description' => t('Example: All, opacity, width, height, etc...'),
      'tab' => 'section_extras',
      'group' => 'transition_extra',
    ];
    $form['element_transition_timing'] = [
      'type'    => 'text',
      'title'   => ('Type'),
      'style_selector' => '.element-transition',
      'style_type' => 'style',
      'style_css' => 'transition-timing-function',
      'description' => t('Example: ease, linear, ease-in, ease-out, ease-in-out, cubic-bezier(n,n,n,n)'),
      'tab' => 'section_extras',
      'group' => 'transition_extra',
    ];

    $form['custom_css'] = [
      'type'    => 'noahs_custom_css',
      'tab' => 'section_extras',
      'title'   => ('Custom Css'),
      'style_type' => 'style',
    ];

    $this->moduleHandler->alter('noahs_default_fields', $form);

    return $form;
  }

  /**
   * Group fields.
   *
   * @param array $fields
   *   The fields.
   *
   * @return array
   *   The fields.
   */
  public function groupFields($fields): array {

    // Iterar sobre el array original y agrupar por pestañas
    // group by tabs.
    $tabs = [];

    foreach ($fields as $key => $value) {
      if (isset($value['type']) && $value['type'] === 'tab') {
        $currentTab = $key;
        $tabs[$currentTab] = $value;
        $tabs[$currentTab]['items'] = [];
        // Agregar el título de la pestaña.
        $tabs[$currentTab]['title'] = $value['title'] ?? $currentTab;
      }
      else {
        if (isset($value['tab'])) {
          $tabName = $value['tab'];
          $group = $value['group'] ?? NULL;

          // Verificar si hay grupos o no.
          if ($group !== NULL) {
            if (!isset($tabs[$tabName]['items'][$group])) {
              // Utilizar el título y tipo del grupo del array original.
              $groupTitle = $fields[$group]['title'] ?? $group;
              $groupType = $fields[$group]['type'] ?? NULL;
              $tabs[$tabName]['items'][$group]['title'] = $groupTitle;
              $tabs[$tabName]['items'][$group]['type'] = $groupType;
            }
            $tabs[$tabName]['items'][$group]['items'][$key] = $value;
          }
          else {
            $tabs[$tabName]['items'][$key] = $value;
          }
        }
      }
    }

    return $tabs;
  }

  /**
   * Get media query.
   *
   * @return array
   *   The media query.
   */
  public static function getMediaQuery(): array {
    $media_query = [
      "desktop" => "1600px",
      "tablet" => "920px",
      "mobile" => "767px",
    ];
    return $media_query;
  }

}
