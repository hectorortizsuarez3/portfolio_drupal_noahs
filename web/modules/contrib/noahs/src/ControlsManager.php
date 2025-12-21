<?php

namespace Drupal\noahs_page_builder;

use Drupal\noahs_page_builder\Service\ControlServices;

/**
 * Controls manager.
 */
class ControlsManager {

  /**
   * The control service.
   *
   * @var \Drupal\noahs_page_builder\Service\ControlServices
   */
  protected $controlService;

  /**
   * Constructs a new ControlsManager object.
   *
   * @param \Drupal\noahs_page_builder\Service\ControlServices $controlService
   *   The control service.
   */
  public function __construct(ControlServices $controlService) {
    $this->controlService = $controlService;
  }

  /**
   * Render tabs with inputs inside.
   *
   * @param array $tabs
   *   The tabs.
   * @param array $values
   *   The values.
   * @param bool $multiple
   *   The multiple.
   * @param int $delta
   *   The delta.
   * @param string $parent
   *   The parent.
   *
   * @return array
   *   The form.
   */
  public function renderTabs($tabs, $values, $multiple = NULL, $delta = NULL, $parent = NULL) {
    $controlService = $this->controlService;

    $html_tabs = '';
    $tab_titles = [];
    $items = [];

    $control_tabs = $controlService->getControlById('control_tabs');
    $control_tab = $controlService->getControlById('control_tab');

    // if (!$multiple) {
    //   $array1 = $controlService->defaultFields();
    //   $array1 = $controlService->groupFields($array1);

    //   foreach ($array1 as $key => $value) {

    //     if (array_key_exists($key, $tabs)) {

    //       $tabs[$key]['items'] = array_merge(
    //       $tabs[$key]['items'],
    //       array_diff_key($value['items'], $tabs[$key]['items'])
    //       );

    //     }
    //     else {
    //       $tabs[$key] = $value;
    //     }
    //   }
    // }

    $first = TRUE;

    foreach ($tabs as $tab_id => $tab) {
      $html_tab = '';

      // Controls items.
      foreach ($tab['items'] as $item_id => $item) {

        if (isset($item['type']) && $item['type'] === 'group') {

          $group = $controlService->getControlById('group');

          $html_group = '';
          foreach ($item['items'] as $group_item_id => $group_item) {
            $values_element = $values['element'] ?? [];
          
            $group_items = [
              'item' => $group_item,
              'wid' => !empty($values['wid']) ? $values['wid'] : NULL,
              'item_id' => $group_item_id,
              'delta' => $delta,
              'parent' => $parent,
              'values' => $values,
            ];
            $html_group .= $this->renderControls($group_items, $values_element, 'group', $delta);
          }

          $html_tab .= $group->contentTemplate(
          [
            'content' => $html_group,
            'group_id' => $item_id,
            'title' => $item['title'],
            'open' => $item['open'] ?? NULL,
          ]
          );
        }
        else {
          $items[$item_id] = $item;
          $data = [
            'item' => $item,
            'wid' => $values['wid'] ?? NULL,
            'item_id' => $item_id,
            'delta' => $delta,
            'parent' => $parent,
            'values' => $values,
          ];

          $values_element = $values['element'] ?? [];

          $html_tab .= $this->renderControls($data, $values_element, '', $delta);
        }
      }
      $tab_title = $tab['title'] ?? '';
      $tab_titles[$tab_id] = $tab_title;

      $html_tabs .= $control_tab->contentTemplate(
      [
        'content' => $html_tab,
        'tab_id' => $tab_id,
        'title' => $tab_title,
        'delta' => $delta,
        'first' => $first,
      ]
      );

      $first = FALSE;
    }

    return [
      'form' => $control_tabs->contentTemplate([
        'content' => $html_tabs,
        'tabs' => $tab_titles,
        'delta' => $delta,
      ]),
    ];

  }

  /**
   * Render controls (inputs).
   *
   * @param array $data
   *   The data.
   * @param array $values
   *   The values.
   * @param string $wrapper
   *   The wrapper.
   * @param int $delta
   *   The delta.
   *
   * @return string
   *   The html.
   */
  public function renderControls($data, $values, $wrapper = NULL, $delta = NULL): string {
    return $this->controlService->extractHtml($data, $values, $wrapper, $delta);
  }

  /**
   * Get Classes from selector.
   *
   * @param array $items
   *   The items.
   * @param array $values
   *   The values.
   * @param string $wid
   *   The wid.
   *
   * @return array
   *   The classes.
   */
  public function getClasses($items, $values, $wid): array {

    foreach ($values as $item_id => $element) {
      if (!empty($element)) {
        if (!empty($items[$item_id]['style_selector']) && $items[$item_id]['style_selector'] === 'widget') {
          $class['#widget-id-' . $wid][] = $element;
        }
        elseif (!empty($items[$item_id]['style_selector'])) {

          if ($wid === 'no_id') {
            $class[$items[$item_id]['style_selector']][] = $element;
          }
          else {
            $class['#widget-id-' . $wid . ' ' . $items[$item_id]['style_selector']][] = $element;
          }
        }

      }
    }

    if (!empty($class)) {
      return $this->transformArray($class);
    }

    return [];
  }

  /**
   * Get Attributes from selector.
   *
   * @param array $items
   *   The items.
   * @param array $values
   *   The values.
   * @param string $wid
   *   The wid.
   *
   * @return array
   *   The attributes.
   */
  public function getAttributes($items, $values, $wid): array {
    $class = [];

    foreach ($values as $item_id => $element) {

      if (isset($element)) {
        if (!empty($items[$item_id]['style_type']) && $items[$item_id]['style_type'] === 'attribute') {
          if (!empty($element['text'])) {
            $element = $element['text'];
          }

          if ($items[$item_id]['style_selector'] === 'widget') {
            $class['#widget-id-' . $wid][$items[$item_id]['attribute_type']] = $element;
          }
          else {
            $class['#widget-id-' . $wid . ' ' . $items[$item_id]['style_selector']][$items[$item_id]['attribute_type']] = $element;
          }

        }
      }
    }

    return $class;

  }

  /**
   * Transform Array to implode.
   *
   * @param array $array
   *   The array.
   *
   * @return array
   *   The new array.
   */
  public function transformArray($array): array {
    $newArray = [];

    foreach ($array as $key => $value) {
      if (is_array($value)) {
        $flattenedValues = [];

        foreach ($value as $val) {
          if (is_array($val)) {
            $flattenedValues[] = implode(' ', $val);
          }
          else {
            $flattenedValues[] = $val;
          }
        }

        $newArray[$key] = implode(' ', $flattenedValues);
      }
      else {
        $newArray[$key] = $value;
      }
    }

    return $newArray;
  }

}
