<?php

namespace Drupal\noahs_page_builder\Plugin\Control;

/**
 * @ControlPlugin(
 *   id = "select",
 *   label = @Translation("Select")
 * )
 */
class ControlSelect extends ControlBase {

  /**
   * {@inheritdoc}
   */
  public function getype() {
    return 'select';
  }

  /**
   * {@inheritdoc}
   */
  public function contentTemplate(array $params = []) {
    $data = $params['data'] ?? NULL;
    $name = $params['name'] ?? NULL;
    $value = $params['value'] ?? NULL;

    $attributes = '';
    $class = [];
    $class[] = 'form-control form-select';
    $selector = !empty($data['item']['update_selector_html']) ? 'data-update-selectorhtml="#widget-id-' . $data['wid'] . ' ' . $data['item']['update_selector_html'] . '"' : NULL;

    if (!empty($data['item']['attributes'])) {

      $attributes = implode(' ', array_map(
      function ($key, $value) {
        if ($key != 'class') {
          return sprintf('%s="%s"', $key, htmlspecialchars($value));
        }
      },
        array_keys($data['item']['attributes']),
        $data['item']['attributes']
      ));
      $class[] = !empty($data['item']['attributes']['class']) ? $data['item']['attributes']['class'] : NULL;
    }
    if (!empty($data['item']['multiple']) && $data['item']['multiple'] === TRUE) {
      $name = $name . '[]';
      $attributes .= ' multiple="true"';
    }
    $attributes .= 'data-select-value="' . htmlspecialchars(json_encode($value), ENT_QUOTES, 'UTF-8') . '"';
    $class = implode(" ", $class);
    $output = '<select name="' . $name . '" ' . $attributes . '  class="' . $class . '" ' . $selector . ' field-settings>';

    if (!empty($data['item']['select_group_views'])) {

      foreach ($data['item']['options'] as $groupName => $groupItems) {

        $output .= '<optgroup label="' . $groupItems[0]['master'] . '">';
        foreach ($groupItems as $item) {
          $block_id_decoded = htmlspecialchars_decode($item['block_id'], ENT_QUOTES);
          $value_array = json_decode($value, TRUE);
          $item_block_id_array = json_decode($block_id_decoded, TRUE);
          $selected = ($value_array === $item_block_id_array) ? 'selected="selected"' : '';
          $output .= "<option value='{$item['block_id']}' {$selected}>{$item['text']}</option>";
        }
        $output .= '</optgroup>';
      }
    }
    elseif (!empty($data['item']['select_group'])) {

      foreach ($data['item']['options'] as $groupName => $groupItems) {

        $output .= '<option>Select</option>';
        $output .= '<optgroup label="' . $groupItems['text'] . '">';
        foreach ($groupItems['options'] as $key => $item) {
          $selected = ($value == $key) ? 'selected="selected"' : '';

          $output .= "<option value='{$key}' {$selected}>{$item}</option>";
        }
        $output .= '</optgroup>';
      }
    }
    else {

      foreach ($data['item']['options'] as $key => $option) {
        $selected = ($value == $key) ? 'selected="selected"' : '';

        if (!empty($data['item']['multiple']) && $data['item']['multiple'] === TRUE) {
          if (is_array($value)) {
            $selected = (in_array($key, $value)) ? 'selected="selected"' : '';
          }
        }

        $output .= '<option value="' . $key . '" ' . $selected . '>' . $option . '</option>';
      }
    }

    $output .= '</select>';

    return $output;
  }

  /**
   * {@inheritdoc}
   */
  public function getDefaultSettings() {
    return [
      'input_type' => 'select',
      'placeholder' => '',
      'title' => '',
    ];
  }

}
