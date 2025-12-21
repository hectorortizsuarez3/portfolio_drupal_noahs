<?php

namespace Drupal\noahs_page_builder\Plugin\Control;

/**
 * @ControlPlugin(
 *   id = "control_tabs",
 *   label = @Translation("Tabs")
 * )
 */
class ControlTabs extends ControlBase {

  /**
   * {@inheritdoc}
   */
  public function getype() {
    return 'tabs';
  }

  /**
   * {@inheritdoc}
   */
  public function contentTemplate(array $params = []) {
    $content = $params['content'] ?? NULL;
    $tabs = $params['tabs'] ?? NULL;
    $delta = $params['delta'] ?? NULL;

    $first = TRUE;
    $output = '';

    $output .= '<ul class="nav noahs_page_builder-tabs" id="nav-tab_' . $delta . '" role="tablist">';
    foreach ($tabs as $key => $tab) {
      $output .= '<li class="nav-item">';
      $output .= '<a class="nav-link ' . ($first ? 'active' : '') . '" 
                  id="nav_' . $key . '_' .  $delta . '_tab' . '" 
                  data-bs-toggle="tab" 
                  data-bs-target="#nav_' . $key . '_' .  $delta . '" 
                  type="button" 
                  role="tab" 
                  aria-controls="nav_' . $key . '_' .  $delta . '" 
                  aria-selected="' . ($first ? 'true' : 'false') . '">
                  ' . $tab . '
                  </a>';
      $output .= '</li>';
      $first = FALSE;
    }
    $output .= '</ul>';

    $output .= '<div class="tab-content" id="nav_tab_content_' . $key . '_' . $delta . '">';
    $output .= $content;
    $output .= '</div>';

    return $output;
  }

  /**
   * {@inheritdoc}
   */
  public function getDefaultSettings() {
    return [
      'input_type' => 'tabs',
      'placeholder' => '',
      'title' => '',
    ];
  }

}
