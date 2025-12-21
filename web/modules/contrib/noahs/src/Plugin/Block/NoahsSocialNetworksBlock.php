<?php

namespace Drupal\noahs_page_builder\Plugin\Block;

use Drupal\Component\Utility\Html;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a "Social Networks" block to display the social media links.
 *
 * @Block(
 *   id = "noahs_social_networks_block",
 *   admin_label = @Translation("Noahs Social Networks"),
 * )
 */
class NoahsSocialNetworksBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The route match.
   *
   * @var \Drupal\Core\Routing\RouteMatchInterface
   */
  protected $routeMatch;

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, RouteMatchInterface $route_match) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->routeMatch = $route_match;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('current_route_match')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'icon_text' => '',
      'socials' => [],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $config = $this->configuration + $this->defaultConfiguration();
    $wrapper_id = Html::getUniqueId('noahs-theme-socials-wrapper');

    $form['icon_text'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Follow us text'),
      '#default_value' => $config['icon_text'],
    ];

    $saved_socials = $config['socials'];
    $count = $form_state->get('header_top_socials_count');
    if ($count === NULL) {
      $count = max(1, count($saved_socials));
      $form_state->set('header_top_socials_count', $count);
    }

    $form['header_top_socials'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Social networks'),
      '#attributes' => ['id' => $wrapper_id],
      '#description' => $this->t('Copy icons HTML from <a href="https://fontawesome.com/v6/search?ic=free&o=r" target="_blank">Font Awesome</a>.'),
    ];

    $form['header_top_socials']['items'] = [
      '#type' => 'table',
      '#header' => [$this->t('Icon class/name'), $this->t('URL'), $this->t('Operations')],
    ];

    for ($i = 0; $i < $count; $i++) {
      $def_icon = $saved_socials[$i]['icon'] ?? '';
      $def_url = $saved_socials[$i]['url'] ?? '';

      $form['header_top_socials']['items'][$i]['icon'] = [
        '#type' => 'textfield',
        '#title_display' => 'invisible',
        '#default_value' => $def_icon,
      ];
      $form['header_top_socials']['items'][$i]['url'] = [
        '#type' => 'textfield',
        '#title_display' => 'invisible',
        '#default_value' => $def_url,
      ];
      $form['header_top_socials']['items'][$i]['remove'] = [
        '#type' => 'submit',
        '#value' => $this->t('Remove'),
        '#name' => 'remove_social_row_' . $i,
        '#limit_validation_errors' => [],
        '#submit' => [[get_class($this), 'removeSocialRowSubmit']],
        '#ajax' => [
          'callback' => [get_class($this), 'ajaxCallback'],
          'wrapper' => $wrapper_id,
        ],
      ];
    }

    $form['header_top_socials']['add_row'] = [
      '#type' => 'submit',
      '#value' => $this->t('Add social'),
      '#name' => 'add_social_row',
      '#limit_validation_errors' => [],
      '#submit' => [[get_class($this), 'addSocialRowSubmit']],
      '#ajax' => [
        'callback' => [get_class($this), 'ajaxCallback'],
        'wrapper' => $wrapper_id,
      ],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['icon_text'] = $form_state->getValue('icon_text');

    $values = $form_state->getValue(['header_top_socials', 'items']) ?? [];
    $socials = [];

    foreach ($values as $item) {
      if (!empty($item['icon']) && !empty($item['url'])) {
        $socials[] = [
          'icon' => $item['icon'],
          'url' => $item['url'],
        ];
      }
    }

    $this->configuration['socials'] = $socials;
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = $this->configuration + $this->defaultConfiguration();

    return [
      '#theme' => 'noahs_social_networks',
      '#icon_text' => $config['icon_text'],
      '#socials' => $config['socials'],
      '#attached' => [
        'library' => [
          // Ejemplo: 'noahs_page_builder/social-networks' si tienes CSS/JS.
        ],
      ],
    ];
  }

  /**
   * AJAX callback para el contenedor de redes sociales.
   */
  public static function ajaxCallback(array &$form, FormStateInterface $form_state) {
    // Aseguramos compatibilidad con formularios dentro de "settings".
    if (isset($form['header_top_socials'])) {
      return $form['header_top_socials'];
    }
    elseif (isset($form['settings']['header_top_socials'])) {
      return $form['settings']['header_top_socials'];
    }
    // Fallback seguro si el wrapper no se encuentra.
    return ['#markup' => t('Unable to load social networks form section.')];
  }

  /**
   * Submit: añadir fila de red social.
   */
  public static function addSocialRowSubmit(array &$form, FormStateInterface $form_state) {
    $count = (int) ($form_state->get('header_top_socials_count') ?? 1);
    $form_state->set('header_top_socials_count', $count + 1);
    $form_state->setRebuild(TRUE);
  }

  /**
   * Submit: eliminar fila de red social.
   */
  public static function removeSocialRowSubmit(array &$form, FormStateInterface $form_state) {
    $trigger = $form_state->getTriggeringElement();
    $name = $trigger['#name'] ?? '';
    if (strpos($name, 'remove_social_row_') === 0) {
      $count = (int) ($form_state->get('header_top_socials_count') ?? 1);
      if ($count > 1) {
        $form_state->set('header_top_socials_count', $count - 1);
      }
    }
    $form_state->setRebuild(TRUE);
  }

}
