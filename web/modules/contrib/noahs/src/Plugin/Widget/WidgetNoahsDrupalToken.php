<?php

namespace Drupal\noahs_page_builder\Plugin\Widget;

use Drupal\Core\Render\Markup;

/**
 * @WidgetPlugin(
 *   id = "noahs_drupal_token",
 *   label = @Translation("Token")
 * )
 */
class WidgetNoahsDrupalToken extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function data() {
    return [
      'icon' => '<i class="fa-solid fa-code"></i>',
      'title' => 'Drupal Token',
  'description' => 'Render dynamic content using Drupal tokens.',
      'group' => 'Drupal',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildWidgetForm(array $form) {
    

    $form['section_content'] = [
      'type' => 'tab',
      'title' => t('Gallery'),
    ];

    $form['token'] = [
      'type'    => 'text',
      'title'   => t('Token'),
      'tab' => 'section_content',
    ];

    $form['token_button'] = [
      'type'    => 'html',
      'value'   => '<a class="btn btn-s btn-info noahs_page_builder-modal-tokens mb-4" href="#">Select Token</a>',
      'tab' => 'section_content',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function template($settings) {
    $settings = $settings->element;
    $token_service = $this->token;
    $rendered_token = '';

    if (!empty($settings->token->text)) {
      $token = $settings->token->text;
      $route_match = $this->routeMatch;
      $node = $route_match->getParameter('node');

      if (!empty($node)) {
        $rendered_token = $token_service->replace($token, [
          $node->getEntityTypeId() => $node,
        ]);
      }
      else {
        $rendered_token = $token_service->replace($token);
      }
    }
    else {
      $rendered_token = '<p>[mytoken]</p>';
    }

    $output = '<div class="widget-content">';
    $output .= Markup::create($rendered_token);
    $output .= '</div>';

    return $output;
  }

  /**
   * {@inheritdoc}
   */
  public function renderContent($element, $content = NULL) {
    return $this->wrapper($element, $this->template($element->settings));
  }

}
