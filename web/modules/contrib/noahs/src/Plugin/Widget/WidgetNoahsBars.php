<?php

namespace Drupal\noahs_page_builder\Plugin\Widget;

/**
 * @WidgetPlugin(
 *   id = "noahs_bars",
 *   label = @Translation("Bars")
 * )
 */
class WidgetNoahsBars extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function data() {
    return [
      'skill' => '<svg id="fi_8630332" height="512" viewBox="0 0 64 64" width="512" xmlns="http://www.w3.org/2000/svg"><path d="m59 50h-54c-1.65 0-3 1.35-3 3v6c0 1.65 1.35 3 3 3h54c1.65 0 3-1.35 3-3v-6c0-1.65-1.35-3-3-3zm-54.82 9.53c-.1-.16-.18-.33-.18-.53v-6c0-.55.45-1 1-1h3.53zm8.98.47 1.44-2.5-1.73-1-2.02 3.5h-4.63l4.62-8h4.62l-1.44 2.5 1.73 1 2.02-3.5h4.61l-4.62 8h-4.61zm13.85 0 1.44-2.5-1.73-1-2.02 3.5h-4.62l4.62-8h4.62l-1.44 2.5 1.73 1 2.02-3.5h4.62l-4.62 8h-4.61zm6.92 0 4.62-8h4.62l-4.62 8zm6.93 0 4.62-8h4.79l-4.62 8zm7.1 0 4.62-8h4.58l-4.62 8zm12.05-1c0 .55-.45 1-1 1h-4.16l4.57-7.91c.34.16.59.5.59.91z"></path><path d="m59 34h-54c-1.65 0-3 1.35-3 3v6c0 1.65 1.35 3 3 3h54c1.65 0 3-1.35 3-3v-6c0-1.65-1.35-3-3-3zm-54.82 9.53c-.1-.16-.18-.33-.18-.53v-6c0-.55.45-1 1-1h3.53zm8.98.47 1.44-2.5-1.73-1-2.02 3.5h-4.63l4.62-8h4.62l-1.44 2.5 1.73 1 2.02-3.5h4.61l-4.62 8h-4.61zm13.85 0 1.44-2.5-1.73-1-2.02 3.5h-4.62l4.62-8h4.62l-1.44 2.5 1.73 1 2.02-3.5h4.62l-4.62 8h-4.61zm33-1c0 .55-.45 1-1 1h-25.08l4.62-8h20.45c.55 0 1 .45 1 1v6z"></path><path d="m59 18h-54c-1.65 0-3 1.35-3 3v6c0 1.65 1.35 3 3 3h54c1.65 0 3-1.35 3-3v-6c0-1.65-1.35-3-3-3zm-54.82 9.53c-.1-.16-.18-.33-.18-.53v-6c0-.55.45-1 1-1h3.53zm8.98.47 1.44-2.5-1.73-1-2.02 3.5h-4.63l4.62-8h4.62l-1.44 2.5 1.73 1 2.02-3.5h4.61l-4.62 8h-4.61zm46.85-1c0 .55-.45 1-1 1h-32.01l1.44-2.5-1.73-1-2.02 3.5h-4.62l4.62-8h4.62l-1.44 2.5 1.73 1 2.02-3.5h27.38c.55 0 1 .45 1 1v6z"></path><path d="m59 2h-54c-1.65 0-3 1.35-3 3v6c0 1.65 1.35 3 3 3h54c1.65 0 3-1.35 3-3v-6c0-1.65-1.35-3-3-3zm-54.82 9.53c-.1-.16-.18-.33-.18-.53v-6c0-.55.45-1 1-1h3.53zm8.98.47 1.44-2.5-1.73-1-2.02 3.5h-4.63l4.62-8h4.62l-1.44 2.5 1.73 1 2.02-3.5h4.61l-4.62 8h-4.61zm46.85-1c0 .55-.45 1-1 1h-38.94l4.62-8h34.31c.55 0 1 .45 1 1v6z"></path></svg>',
      'title' => 'Skill Bars',
  'description' => 'Animated skill or progress bars.',
      'group' => 'General',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildWidgetForm(array $form) {
    

    $form['section_content'] = [
      'type' => 'tab',
      'title' => t('Content'),
    ];
    $form['skill_list'] = [
      'type'    => 'noahs_multiple_elements',
      'title'   => t('Skill List'),
      'tab' => 'section_content',
      'default_items' => 4,
      'wrapper' => FALSE,
      'fields' => [
        'skill_content' => [
          'type' => 'tab',
          'title' => t('Skill'),
        ],
        'skill_title' => [
          'title' => 'Title',
          'type' => 'text',
          'tab' => 'skill_content',
          'update_selector' => '.multipart-item_element_[index] .info span',
          'default_value' => 'CSS',
          'wrapper' => FALSE,
        ],
        'skill_width' => [
          'title' => '%',
          'type' => 'number',
          'tab' => 'skill_content',
          'style_selector' => '.multipart-item_element_[index] .progress-line span',
          'wrapper' => FALSE,
          'default_value' => '70',
          'style_type'      => 'attribute',
          'attribute_type'  => 'data-width',
        ],
        'background_color' => [
          'type' => 'noahs_color',
          'title' => t('Background Color'),
          'tab' => 'slideshow_content',
          'style_type' => 'style',
          'style_selector' => '.multipart-item_element_[index] .progress-line span',
          'style_css' => 'background-color',
        ],
      ],
    ];
    $form['bar_height'] = [
      'type'    => 'text',
      'title'   => t('Bar Height'),
      'tab' => 'section_content',
      'placeholder'     => t('Height'),
      'style_type' => 'style',
      'style_selector' => '.progress-line span',
      'style_css' => 'height',
    ];
    $form['heading_font'] = [
      'type'        => 'noahs_font',
      'title'       => t('Font'),
      'tab'     => 'section_styles',
      'style_type' => 'style',
      'style_selector' => '.bar .info span',
      'responsive' => TRUE,
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function template($settings) {

    $settings = $settings->element;
    $items = !empty($settings->skill_list) ? $settings->skill_list : [];

    $twig = $this->twig;

    $element_content = $twig->render(NOAHS_PAGE_BUILDER_PATH . '/templates/widgets/noahs_skill_bars.twig', [
      'settings' => $settings,
      'elements' => (array) $items,
    ]);

    return $element_content;
  }

  /**
   * {@inheritdoc}
   */
  public function renderContent($element, $content = NULL) {
    return $this->wrapper($element, $this->template($element->settings));
  }

}
