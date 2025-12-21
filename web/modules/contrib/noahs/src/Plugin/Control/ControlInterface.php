<?php

namespace Drupal\noahs_page_builder\Plugin\Control;

/**
 * Controls Interface.
 */
interface ControlInterface {

  /**
   * Run control.
   *
   * @return string
   *   The type.
   */
  public function getype();

  /**
   * Content template.
   *
   * @param array $params
   *   The params.
   *
   * @return string
   *   The content template.
   */
  public function contentTemplate(array $params = []);

  /**
   * Default settings.
   *
   * @return array
   *   The default settings.
   */
  public function getDefaultSettings();

}
