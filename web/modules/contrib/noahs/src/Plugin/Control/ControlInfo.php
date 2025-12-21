<?php

namespace Drupal\noahs_page_builder\Plugin\Control;

/**
 * @ControlPlugin(
 *   id = "info",
 *   label = @Translation("Info")
 * )
 */
class ControlInfo extends ControlBase {

  /**
   * {@inheritdoc}
   */
  public function getype() {
    return 'info';
  }

  /**
   * {@inheritdoc}
   */
  public function contentTemplate(array $params = []) {
    $data = $params['data'] ?? NULL;

    $output = '<div class="field field__info">';
    $output .= '<p>' . $data['item']['title'] . '</p>';
    $output .= '</div>';

    return $output;
  }

  /**
   * {@inheritdoc}
   */
  public function getDefaultSettings() {
    return [
      'input_type' => 'info',
      'title' => '',
    ];
  }

}
