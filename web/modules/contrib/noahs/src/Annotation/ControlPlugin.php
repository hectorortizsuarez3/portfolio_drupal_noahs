<?php

namespace Drupal\noahs_page_builder\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Define un Control plugin.
 *
 * @Annotation
 */
class ControlPlugin extends Plugin {
  /**
   * El ID del plugin.
   *
   * @var string
   */
  public $id;

  /**
   * El nombre del control.
   *
   * @var string
   */
  public $label;

}
