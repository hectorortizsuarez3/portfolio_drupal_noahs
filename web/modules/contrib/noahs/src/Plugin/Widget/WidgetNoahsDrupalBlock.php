<?php

namespace Drupal\noahs_page_builder\Plugin\Widget;

/**
 * @WidgetPlugin(
 *   id = "noahs_drupal_block",
 *   label = @Translation("Drupal Block")
 * )
 */
class WidgetNoahsDrupalBlock extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function data() {
    return [
      'icon' => '<i class="fa-brands fa-drupal"></i>',
      'title' => 'Drupal Block',
  'description' => 'Embed any Drupal block in your layout.',
      'group' => 'Drupal',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildWidgetForm(array $form) {
    
    $options = noahs_page_builder_load_blocks();

    $form['section_content'] = [
      'type' => 'tab',
      'title' => t('Countdown'),
    ];
    $form['drupal_block'] = [
      'type'    => 'select',
      'title'   => t('Drupal Block'),
      'tab' => 'section_content',
      'options' => $options,
      'attributes' => [
        'class' => 'noahs-regenerate-design',
        'data-select-2' => '1',
      ],
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function template($settings) {

    $settings = $settings->element;

    if (!empty($settings->drupal_block)) {

      $block_manager = $this->blockManager;
      $config = [];
      $plugin_block = $block_manager->createInstance($settings->drupal_block, $config);

      $access_result = $plugin_block->access($this->currentUser);
      if (is_object($access_result) && $access_result->isForbidden() || is_bool($access_result) && !$access_result) {
        return;
      }

      $render_block = '<div>Missing view, block "' . $settings->drupal_block . '"</div>';
      if ($plugin_block) {
        $build = $plugin_block->build();

        $render_block = $this->renderer->render(
            $build
         );

      }
    }
    else {
      $render_block = '<div>Select your block before :)</div>';
    }

    $output = '<div class="widget-content">';
    $output .= $render_block ?: '<div class="drupal-viewblock-empty">Drupal View</div>';
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
