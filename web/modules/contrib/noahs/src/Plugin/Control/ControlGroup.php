<?php

namespace Drupal\noahs_page_builder\Plugin\Control;

/**
 * @ControlPlugin(
 *   id = "group",
 *   label = @Translation("Group")
 * )
 */
class ControlGroup extends ControlBase {

  /**
   * {@inheritdoc}
   */
  public function getype() {
    return 'group';
  }

  /**
   * {@inheritdoc}
   */
  public function contentTemplate(array $params = []) {
    $content = $params['content'] ?? NULL;
    $group_id = $params['group_id'] ?? NULL;
    $title = $params['title'] ?? NULL;
    $open = !empty($params['open']) ? 'show' : '';

    $html = '<div class="noahs_page_builder-group noahs_page_builder_field" id="noahs_page_builder_' . htmlspecialchars($group_id) . '">';
    $html .= '<h5 class="d-flex justify-content-between" data-bs-toggle="collapse" href="#' . htmlspecialchars($group_id) . '" role="button" aria-expanded="false" aria-controls="' . htmlspecialchars($group_id) . '">';
    $html .= htmlspecialchars($title) . '<i class="fa-solid fa-caret-down"></i></h5>';
    $html .= '<div class="noahs_page_builder-group_content collapse ' . $open . '" id="' . htmlspecialchars($group_id) . '">';
    $html .= $content;
    $html .= '</div></div>';

    return $html;
  }

  /**
   * {@inheritdoc}
   */
  public function getDefaultSettings() {
    return [
      'input_type' => 'group',
      'placeholder' => '',
      'title' => '',
    ];
  }

}
