<?php

namespace Drupal\noahs_page_builder\Plugin\Widget;

/**
 * Widgets Interface.
 */
interface WidgetInterface {

  /**
   * Run widget.
   *
   * @return array
   *   Render.
   */
  public function data();

  /**
   * {@inheritdoc}
   */
  public function renderForm();

  /**
   * {@inheritdoc}
   */
  public function renderContent($element, $content = NULL);

}
