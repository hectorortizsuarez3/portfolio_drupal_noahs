<?php

namespace Drupal\noahs_page_builder\Plugin\Control;

/**
 * @ControlPlugin(
 *   id = "html",
 *   label = @Translation("HTML")
 * )
 */
class ControlHtml extends ControlBase {

  /**
   * {@inheritdoc}
   */
  public function getype() {
    return 'html';
  }

  /**
   * {@inheritdoc}
   */
  public function contentTemplate(array $params = []) {
    $data = $params['data'] ?? NULL;

    $output = '<div class="field field__html">';
    $output .= '<h5>' . !empty($data['item']['title']) ? $data['item']['title'] : '' . '</h5>';
    $output .= $data['item']['value'];
    $output .= '</div>';

    return $output;
  }

  /**
   * {@inheritdoc}
   */
  public function getDefaultSettings() {
    return [
      'input_type' => 'html',
      'title' => '',
    ];
  }

}
