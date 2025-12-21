<?php

namespace Drupal\noahs_page_builder\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Define un Widget plugin.
 *
 * @Annotation
 */
class WidgetPlugin extends Plugin {
  /**
   * El ID del plugin.
   *
   * @var string
   */
  public $id;

  /**
   * El nombre del widget.
   *
   * @var string
   */
  public $label;

}
