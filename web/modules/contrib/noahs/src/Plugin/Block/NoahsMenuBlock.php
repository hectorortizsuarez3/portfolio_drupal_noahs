<?php

namespace Drupal\noahs_page_builder\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Menu\MenuActiveTrailInterface;
use Drupal\Core\Menu\MenuLinkTreeInterface;
use Drupal\Core\Menu\MenuTreeParameters;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a Noahs Menu block (clone of system menu block).
 *
 * @Block(
 *   id = "noahs_menu_block",
 *   admin_label = @Translation("Noahs Menu"),
 *   category = @Translation("Noahs")
 * )
 */
class NoahsMenuBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The menu link tree service.
   * @var \Drupal\Core\Menu\MenuLinkTreeInterface
   */
  protected $menuTree;

  /**
   * The active menu trail service.
   * @var \Drupal\Core\Menu\MenuActiveTrailInterface
   */
  protected $menuActiveTrail;

  /**
   * Constructs a new NoahsMenuBlock.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, MenuLinkTreeInterface $menu_tree, MenuActiveTrailInterface $menu_active_trail) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->menuTree = $menu_tree;
    $this->menuActiveTrail = $menu_active_trail;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('menu.link_tree'),
      $container->get('menu.active_trail')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'menu_name' => 'main',
      'level' => 1,
      'depth' => 0,
      'expand_all_items' => FALSE,
      'noahs_menu_orientation' => FALSE,
      'noahs_menu_orientation' => 'horizontal',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $config = $this->configuration;

    // Selector de menú.
    $menus = \Drupal::entityTypeManager()->getStorage('menu')->loadMultiple();
    $menu_options = [];
    foreach ($menus as $id => $menu) {
      $menu_options[$id] = $menu->label();
    }

    $form['noahs_menu'] = [
      '#type' => 'details',
      '#title' => $this->t('Noahs Menu settings'),
      '#open' => TRUE,
  // Procesar para que sus hijos se guarden en el nivel raíz (como hace el core con menu_levels).
  '#process' => [[self::class, 'processNoahsMenuParents']],
    ];

    $form['noahs_menu']['menu_name'] = [
      '#type' => 'select',
      '#title' => $this->t('Menu'),
      '#default_value' => $config['menu_name'] ?? 'main',
      '#options' => $menu_options,
      '#required' => TRUE,
    ];

    $form['noahs_menu']['noahs_menu_responsive'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Menu responsive?'),
      '#default_value' => !empty($config['noahs_menu_responsive']),
    ];

    $form['noahs_menu']['noahs_menu_orientation'] = [
      '#type' => 'select',
      '#title' => $this->t('Menu orientation'),
      '#options' => [
        'horizontal' => $this->t('Horizontal'),
        'vertical' => $this->t('Vertical'),
      ],
      '#default_value' => $config['noahs_menu_orientation'] ?? 'horizontal',
    ];

    $form['noahs_menu']['noahs_menu_collapsible'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Menu collapsible?'),
      '#default_value' => !empty($config['noahs_menu_collapsible']),
    ];

    $form['noahs_menu']['noahs_menu_vertical_expand'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Menu vertical expand?'),
      '#default_value' => !empty($config['noahs_menu_vertical_expand']),
    ];

    $form['noahs_menu']['noahs_menu_orientation'] = [
      '#type' => 'select',
      '#title' => $this->t('Menu orientation'),
      '#options' => [
        'horizontal' => $this->t('Horizontal'),
        'vertical' => $this->t('Vertical'),
      ],
      '#default_value' => $config['noahs_menu_orientation'] ?? 'horizontal',
    ];

    $form['menu_levels'] = [
      '#type' => 'details',
      '#title' => $this->t('Menu levels'),
      '#open' => FALSE,
      '#process' => [[self::class, 'processMenuLevelsParents']],
    ];

    $options = range(0, $this->menuTree->maxDepth());
    unset($options[0]);
    $form['menu_levels']['level'] = [
      '#type' => 'select',
      '#title' => $this->t('Initial visibility level'),
      '#default_value' => $config['level'] ?? '1',
      '#options' => $options,
      '#description' => $this->t('Use level 1 to always display this menu.'),
      '#required' => TRUE,
    ];
    $options[0] = $this->t('Unlimited');
    $form['menu_levels']['depth'] = [
      '#type' => 'select',
      '#title' => $this->t('Number of levels to display'),
      '#default_value' => $config['depth'] ?? '0',
      '#options' => $options,
      '#description' => $this->t('This maximum number includes the initial level.'),
      '#required' => TRUE,
    ];
    $form['menu_levels']['expand_all_items'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Expand all menu links'),
      '#default_value' => !empty($config['expand_all_items']),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
  // Tras los #process los hijos quedan al mismo nivel que el formulario raíz.
  $this->configuration['menu_name'] = $form_state->getValue('menu_name');
  $this->configuration['noahs_menu_responsive'] = (bool) $form_state->getValue('noahs_menu_responsive');
  $this->configuration['noahs_menu_orientation'] = $form_state->getValue('noahs_menu_orientation');
  $this->configuration['noahs_menu_collapsible'] = $form_state->getValue('noahs_menu_collapsible');
  $this->configuration['level'] = (int) $form_state->getValue('level');
  $this->configuration['depth'] = (int) $form_state->getValue('depth');
  $this->configuration['expand_all_items'] = (bool) $form_state->getValue('expand_all_items');
  $this->configuration['noahs_menu_vertical_expand'] = (bool) $form_state->getValue('noahs_menu_vertical_expand');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $menu_name = $this->configuration['menu_name'] ?? 'main';
    $parameters = $this->configuration['expand_all_items']
      ? (new MenuTreeParameters())->setActiveTrail($this->menuActiveTrail->getActiveTrailIds($menu_name))
      : $this->menuTree->getCurrentRouteMenuTreeParameters($menu_name);

    $level = $this->configuration['level'];
    $depth = $this->configuration['depth'];
    $parameters->setMinDepth($level);
    if ($depth > 0) {
      $parameters->setMaxDepth(min($level + $depth - 1, $this->menuTree->maxDepth()));
    }

    if ($level > 1) {
      if (count($parameters->activeTrail) >= $level) {
        $menu_trail_ids = array_reverse(array_values($parameters->activeTrail));
        $menu_root = $menu_trail_ids[$level - 1];
        $parameters->setRoot($menu_root)->setMinDepth(1);
        if ($depth > 0) {
          $parameters->setMaxDepth(min($level - 1 + $depth - 1, $this->menuTree->maxDepth()));
        }
      }
      else {
        return [];
      }
    }

    $tree = $this->menuTree->load($menu_name, $parameters);
    $manipulators = [
      ['callable' => 'menu.default_tree_manipulators:checkAccess'],
      ['callable' => 'menu.default_tree_manipulators:generateIndexAndSort'],
    ];

    $tree = $this->menuTree->transform($tree, $manipulators);
    $menu_render = $this->menuTree->build($tree);
    $menu_render['#attributes']['data-responsive'][] = !empty($this->configuration['noahs_menu_responsive']) ? 'noahs-menu--responsive' : 'noahs-menu--not-responsive';
    $menu_render['#attributes']['data-orientation'][] = 'noahs-menu--' . $this->configuration['noahs_menu_orientation'];
    $menu_render['#attributes']['data-collapsible'][] = (!empty($this->configuration['noahs_menu_collapsible']) ? 'noahs-menu--collapsible' : 'noahs-menu--not-collapsible');
    $menu_render['#attributes']['data-vertical-expand'][] = (!empty($this->configuration['noahs_menu_vertical_expand']) ? 'noahs-menu--vertical-expand-all' : 'noahs-menu--not-vertical-expand-all');

    return [
      '#theme' => 'noahs_menu_block',
      '#menu' => $menu_render,
      '#cache' => [
        'tags' => ['config:system.menu.' . $menu_name],
        'contexts' => ['route.menu_active_trails:' . $menu_name],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheTags() {
    $menu_name = $this->configuration['menu_name'] ?? 'main';
    return Cache::mergeTags(parent::getCacheTags(), ['config:system.menu.' . $menu_name]);
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheContexts() {
    $menu_name = $this->configuration['menu_name'] ?? 'main';
    return Cache::mergeContexts(parent::getCacheContexts(), ['route.menu_active_trails:' . $menu_name]);
  }

  /**
   * Process callback para noahs_menu: quita el último parent.
   */
  public static function processNoahsMenuParents(&$element, FormStateInterface $form_state, &$complete_form) {
    array_pop($element['#parents']);
    return $element;
  }

  /**
   * Process callback para menu_levels: igual que el core.
   */
  public static function processMenuLevelsParents(&$element, FormStateInterface $form_state, &$complete_form) {
    array_pop($element['#parents']);
    return $element;
  }
}
