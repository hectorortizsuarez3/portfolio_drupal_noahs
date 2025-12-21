<?php

namespace Drupal\noahs_page_builder\Plugin\Control;

/**
 * @ControlPlugin(
 *   id = "control_tab",
 *   label = @Translation("Tab")
 * )
 */
class ControlTab extends ControlBase {

  /**
   * {@inheritdoc}
   */
  public function getype() {
    return 'tab';
  }

  /**
   * {@inheritdoc}
   */
  public function contentTemplate(array $params = []) {
    $content = $params['content'] ?? NULL;
    $tab_id = $params['tab_id'] ?? NULL;
    $title = $params['title'] ?? NULL;
    $delta = $params['delta'] ?? NULL;
    $first = $params['first'] ?? NULL;

    if (is_array($content)) {
      return;
    }

    $output = '';

    $output .= '<div class="tab-pane fade ' . (($delta === 0 || $first) ? 'active show' : '') . '" id="nav_' . $tab_id . '_' . $delta . '" role="tabpanel" aria-labelledby="nav_' . $tab_id . '_' . $delta . '_tab' . '">';
    $output .= '<div class="noahs_page_builder-tab_content">';
    $output .= $content;
    $output .= '</div>';
    $output .= '</div>';

    return $output;
  }

  /**
   * {@inheritdoc}
   */
  public function getDefaultSettings() {
    return [
      'input_type' => 'tab',
      'placeholder' => '',
      'title' => '',
    ];
  }

}
