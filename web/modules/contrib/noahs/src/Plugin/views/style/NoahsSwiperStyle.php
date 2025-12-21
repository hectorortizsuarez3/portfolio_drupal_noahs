<?php

namespace Drupal\noahs_page_builder\Plugin\views\style;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Template\Attribute;
use Drupal\views\Annotation\ViewsStyle;
use Drupal\views\Plugin\views\style\StylePluginBase;

/**
 * Provides a Swiper carousel style for Views.
 *
 * @ViewsStyle(
 *   id = "noahs_swiper",
 *   title = @Translation("Noahs Swiper Carousel"),
 *   help = @Translation("Render view rows inside a Swiper carousel."),
 *   theme = "views_noahs_media_swiper",
 *   display_types = {"normal"}
 * )
 */
class NoahsSwiperStyle extends StylePluginBase {

  protected $usesRowPlugin = TRUE;

  public function defineOptions() {
    $options = parent::defineOptions();
    $options['slides_per_view'] = [
      'contains' => [
        'desktop' => ['default' => 1],
        'tablet' => ['default' => 1],
        'mobile' => ['default' => 1],
      ],
    ];
    return $options;
  }

  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    parent::buildOptionsForm($form, $form_state);

    $form['slides_per_view'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Slides per view'),
    ];
    $form['slides_per_view']['desktop'] = [
      '#type' => 'number',
      '#title' => $this->t('Desktop'),
      '#min' => 1,
      '#default_value' => (int) $this->options['slides_per_view']['desktop'],
    ];
    $form['slides_per_view']['tablet'] = [
      '#type' => 'number',
      '#title' => $this->t('Tablet'),
      '#min' => 1,
      '#default_value' => (int) $this->options['slides_per_view']['tablet'],
    ];
    $form['slides_per_view']['mobile'] = [
      '#type' => 'number',
      '#title' => $this->t('Mobile'),
      '#min' => 1,
      '#default_value' => (int) $this->options['slides_per_view']['mobile'],
    ];
  }

  public function render() {
    $spv = $this->options['slides_per_view'];
    $wrapper_attributes = [
      'class' => ['noahs_page_builder-carousel', 'swiper'],
      'data-show-items-desktop' => (string) (int) $spv['desktop'],
      'data-show-items-tablet' => (string) (int) $spv['tablet'],
      'data-show-items-mobile' => (string) (int) $spv['mobile'],
    ];

    $rows = [];
    foreach ($this->view->result as $row) {
      $rows[] = $this->view->rowPlugin->render($row);
    }

    return [
      '#theme' => 'views_noahs_media_swiper',
      '#attributes' => new Attribute($wrapper_attributes),
      '#rows' => $rows,
    ];
  }
}
