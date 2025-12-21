<?php

namespace Drupal\noahs_page_builder\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Menu\LocalTaskManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Render\Element;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\user\Entity\Role;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a "Tabs" block to display the local tasks.
 *
 * @Block(
 *   id = "noahs_local_tasks_block",
 *   admin_label = @Translation("Noahs Admin Tabs"),
 * )
 */
class NoahsLocalTasksBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The local task manager.
   *
   * @var \Drupal\Core\Menu\LocalTaskManagerInterface
   */
  protected $localTaskManager;

  /**
   * The route match.
   *
   * @var \Drupal\Core\Routing\RouteMatchInterface
   */
  protected $routeMatch;

  /**
   * Creates a LocalTasksBlock instance.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    LocalTaskManagerInterface $local_task_manager,
    RouteMatchInterface $route_match
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->localTaskManager = $local_task_manager;
    $this->routeMatch = $route_match;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(
    ContainerInterface $container,
    array $configuration,
    $plugin_id,
    $plugin_definition
  ) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('plugin.manager.menu.local_task'),
      $container->get('current_route_match')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'label_display' => FALSE,
      'primary' => TRUE,
      'secondary' => TRUE,
      'allowed_roles' => [],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $config = $this->configuration;

    $form['levels'] = [
      '#type' => 'details',
      '#title' => $this->t('Shown tabs'),
      '#open' => TRUE,
    ];
    $form['levels']['primary'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Show primary tabs'),
      '#default_value' => $config['primary'],
    ];
    $form['levels']['secondary'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Show secondary tabs'),
      '#default_value' => $config['secondary'],
    ];

    // Roles disponibles.
    $roles = Role::loadMultiple();
    $role_options = [];
    foreach ($roles as $role_id => $role) {
      $role_options[$role_id] = $role->label();
    }

    $form['allowed_roles'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Allowed roles'),
      '#description' => $this->t('Select the roles that can see this block. Leave empty to allow all roles.'),
      '#options' => $role_options,
      '#default_value' => $config['allowed_roles'],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $levels = $form_state->getValue('levels');
    $this->configuration['primary'] = $levels['primary'];
    $this->configuration['secondary'] = $levels['secondary'];
    $this->configuration['allowed_roles'] = array_filter($form_state->getValue('allowed_roles'));
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = $this->configuration;
    $current_user = \Drupal::currentUser();

    // Control por roles.
    if (!empty($config['allowed_roles'])) {
      $user_roles = $current_user->getRoles();
      if (empty(array_intersect($config['allowed_roles'], $user_roles))) {
        return [
          '#markup' => '',
          '#cache' => ['max-age' => 0],
        ];
      }
    }

    $tabs = [
      '#theme' => 'noahs_menu_local_tasks',
    ];

    if ($config['primary']) {
      $links = $this->localTaskManager->getLocalTasks(
        $this->routeMatch->getRouteName(),
        0
      );
      $tabs['#primary'] = count(Element::getVisibleChildren($links['tabs'])) > 1
        ? $links['tabs']
        : [];
    }

    if ($config['secondary']) {
      $links = $this->localTaskManager->getLocalTasks(
        $this->routeMatch->getRouteName(),
        1
      );
      $tabs['#secondary'] = count(Element::getVisibleChildren($links['tabs'])) > 1
        ? $links['tabs']
        : [];
    }

    if (empty($tabs['#primary']) && empty($tabs['#secondary'])) {
      return [
        '#markup' => '',
        '#cache' => ['max-age' => 0],
      ];
    }

    return $tabs + [
      '#cache' => [
        'max-age' => 0,
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    return 0;
  }

}
