<?php

namespace Drupal\noahs_page_builder\Plugin\Control;

/**
 * @ControlPlugin(
 *   id = "hidden",
 *   label = @Translation("hidden")
 * )
 */
class ControlHidden extends ControlBase {

  /**
   * {@inheritdoc}
   */
  public function getype() {
    return 'hidden';
  }

  /**
   * {@inheritdoc}
   */
  public function contentTemplate(array $params = []) {
    $data = $params['data'] ?? NULL;
    $name = $params['name'] ?? NULL;
    $value = $params['value'] ?? NULL;
    $class = [];

    if (!empty($data['item']['attributes'])) {
      $attributes = implode(' ', array_map(
      function ($key, $value) {
        return sprintf('%s="%s"', $key, htmlspecialchars($value));
      },
                array_keys($data['item']['attributes']),
                $data['item']['attributes']
      ));
      $class[] = !empty($data['item']['attributes']['class']) ? $data['item']['attributes']['class'] : NULL;
    }

    $class = implode(" ", $class);

    $output = '<input type="hidden" name="' . $name . '" value="' . $value . '" class="' . $class . '" field-settings/>';

    return $output;
  }

  /**
   * {@inheritdoc}
   */
  public function getDefaultSettings() {
    return [
      'input_type' => 'hidden',
      'title' => '',
    ];
  }

}
