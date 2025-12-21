<?php

namespace Drupal\noahs_page_builder\Plugin\Widget;

use Drupal\views\Views;

/**
 * @WidgetPlugin(
 *   id = "noahs_drupal_views",
 *   label = @Translation("View")
 * )
 */
class WidgetNoahsDrupalViews extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function data() {
    return [
      'icon' => '<i class="fa-brands fa-drupal"></i>',
      'title' => 'Drupal Views',
  'description' => 'Embed a Drupal View in your layout.',
      'group' => 'Drupal',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildWidgetForm(array $form) {
    
    $options = noahs_page_builder_load_views();

    // Section Content.
    $form['section_content'] = [
      'type' => 'tab',
      'title' => t('Content'),
    ];

    $form['drupal_block'] = [
      'type'    => 'select',
      'select_group_views'    => TRUE,
      'title'   => t('Drupal Block'),
      'tab' => 'section_content',
      'options' => $options,
      'wrapper' => FALSE,
      'attributes' => [
        'class' => 'noahs-regenerate-design',
        'data-select-2' => '1',
      ],
    ];

  // (LEGACY) Original single token/argument field kept for backward
  // compatibility with already stored widgets.
    $form['token'] = [
      'type'    => 'text',
      'title'   => t('Token (legacy)'),
      'tab' => 'section_content',
  'description' => t('Deprecated: use "Contextual arguments" below for multiple arguments.'),
      'attributes' => [
        'placeholder' => t('[node:nid]'),
      ],
    ];

  // New field for multiple contextual filter arguments. Separate by lines
  // or commas. Each argument supports tokens.
    $form['contextual_arguments'] = [
      'type'    => 'textarea',
      'title'   => t('Contextual arguments'),
      'tab' => 'section_content',
      'format' => 'noahs_textarea_plain',
  'description' => t('Enter one per line or separated by commas. You can use tokens like [node:nid]. Empty lines generate empty arguments.'),
      'attributes' => [
        'class' => 'noahs-regenerate-design',
  'placeholder' => "[node:nid]\npublished",
        'rows' => 4,
      ],
    ];
    
    $form['contextual_arguments_help'] = [
      'type' => 'html',
      'title' => '<div class="description mb-3 p-2 bg-light"><strong>' . t('Examples:') . '</strong><br>' .
        t('1) [node:nid]\n2) category,published\n3) [current-user:uid]\n4) category,,published (empty argument in the middle)') . '</div>',
      'tab' => 'section_content',
    ];

    $form['show_items'] = [
      'type'    => 'number',
      'title'   => t('Show items'),
      'tab' => 'section_content',
      'description' => t('Set the number of items to display'),
    ];
    $form['hide_pagination'] = [
      'type'    => 'checkbox',
      'title'   => t('Hide Pagination'),
      'value' => 'true',
      'default_value' => 'false',
      'tab' => 'section_content',
      'wrapper' => FALSE,
      'attributes' => [
        'class' => 'noahs-regenerate-design',
      ],
    ];
    $form['hide_exposed_filter'] = [
      'type'    => 'checkbox',
      'title'   => t('Hide Exposed Filters'),
      'value' => 'true',
      'default_value' => 'false',
      'tab' => 'section_content',
      'wrapper' => FALSE,
      'attributes' => [
        'class' => 'noahs-regenerate-design',
      ],
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
    $render_block = '';
    $settings = $settings->element;

    if (!empty($settings->drupal_block)) {

      $views_array = json_decode($settings->drupal_block);
      $view = Views::getView($views_array[0]);

      $display_id = $views_array[1];
      $render_block = '<div>Missing view, block "' . $settings->drupal_block . '"</div>';

      // Build contextual filter arguments from BOTH sources:
      // 1) New multi-line field contextual_arguments.
      // 2) Legacy single token field token.
      // They are merged preserving order: contextual_arguments first, then token.
      $args = [];
      $token_service = $this->token;

      // Helper closure to parse a raw string into argument list.
      $parse_raw = function($raw_string) use ($token_service) {
        $collected = [];
        if ($raw_string === NULL || $raw_string === '') {
          return $collected;
        }
        // Split by commas OR new lines (one or more).
        $parts = preg_split('/[\r\n,]+/', $raw_string);
        if (empty($parts)) {
          return $collected;
        }
        foreach ($parts as $part) {
          $part = trim($part);
          if ($part === '') {
            // Keep empty placeholder to maintain positional semantics if user wants it.
            $collected[] = '';
            continue;
          }
            // Replace tokens individually so each argument can use tokens.
          $collected[] = $token_service->replace($part);
        }
        return $collected;
      };

      // Extract raw contextual arguments (object may store ->text or be a plain string).
      $raw_contextual = NULL;
      if (isset($settings->contextual_arguments)) {
        if (is_object($settings->contextual_arguments) && isset($settings->contextual_arguments->text)) {
          $raw_contextual = $settings->contextual_arguments->text;
        }
        elseif (is_string($settings->contextual_arguments)) {
          $raw_contextual = $settings->contextual_arguments;
        }
      }
      // Extract legacy token raw value.
      $raw_token = NULL;
      if (isset($settings->token) && is_object($settings->token) && isset($settings->token->text)) {
        $raw_token = $settings->token->text;
      }

      // Select ONE source of arguments:
      // Priority 1: New contextual_arguments field (if it has content).
      // Priority 2: Legacy single token field.
      if ($raw_contextual !== NULL && $raw_contextual !== '') {
        $args = $parse_raw($raw_contextual);
      }
      elseif ($raw_token !== NULL && $raw_token !== '') {
        $args = $parse_raw($raw_token);
      }
      // (If neither provided, $args remains empty and the view gets default behavior.)

      // Trim trailing empty placeholders (positional empties inside the list are preserved).
      while (!empty($args) && end($args) === '') {
        array_pop($args);
      }

      if ($view) {

        $view->setDisplay($display_id);
        // Only set arguments if we actually have some; otherwise default.
        if (!empty($args)) {
          $view->setArguments($args);
        }

        if (!empty($settings->show_items)) {
          $view->setItemsPerPage($settings->show_items);
          $view->setCurrentPage(0);
          $view->setOffset(0);
        }
        if (!empty($settings->hide_exposed_filter)) {
          $view->display_handler->options['exposed_block'] = TRUE;
        }

        $view->initHandlers();
        $view->preExecute();
        $view->execute();

        if (!empty($settings->hide_pagination)) {
          unset($view->pager);
        }
        $view_render = $view->buildRenderable($display_id);
        $render_block = $this->renderer->render($view_render);
        $render_block = !empty($render_block) ? $render_block->__toString() : NULL;

      }

    }

    $output = '';

    $output .= '<div class="widget-content">';
    if (!empty($render_block)) {
      $output .= $render_block;
    }
    else {
      $output .= '<div class="drupal-viewblock-empty">Drupal View</div>';
    }
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
