<?php

namespace Drupal\noahs_page_builder\Plugin\Widget;

/**
 * @WidgetPlugin(
 *   id = "noahs_drupal_site_logo",
 *   label = @Translation("Site Logo")
 * )
 */
class WidgetNoahsDrupalSiteLogo extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function data() {
    return [
      'icon' => '<i class="fa-brands fa-drupal"></i>',
      'title' => 'Drupal Site Logo',
  'description' => 'Show the site logo from Drupal settings.',
      'group' => 'Drupal',
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

    $form['logo_width'] = [
      'type'    => 'noahs_width',
      'title'   => ('Logo Width'),
      'style_type' => 'style',
      'style_selector' => '.widget-content img',
      'style_css' => 'max-width',
      'tab' => 'section_content',
      'responsive' => TRUE,
      'placeholder' => 'use as 10%, 100px, 100vw...',
    ];

    $form['logo_fixed_width'] = [
      'type'    => 'noahs_width',
      'title'   => ('Logo width on header sticky'),
      'style_type' => 'style',
      'style_selector' => '.noahs-pro-theme--header.sticky [widget] .site__logo',
      'style_css' => 'max-width',
      'tab' => 'section_content',
      'responsive' => TRUE,
      'placeholder' => 'use as 10%, 100px, 100vw...',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function template($settings) {

    $logo_relative_path = theme_get_setting('logo.url');
    $site_name = $this->configFactory->get('system.site')->get('name');
    $element_content = $this->twig()->render(NOAHS_PAGE_BUILDER_PATH . '/templates/widgets/element_noahs_drupal_site_logo.twig', [
      'logo_relative_path' => $logo_relative_path,
      'site_name' => $site_name,
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
