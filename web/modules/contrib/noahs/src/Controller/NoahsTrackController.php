<?php

namespace Drupal\noahs_page_builder\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\RequestStack;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Track user.
 */
class NoahsTrackController extends ControllerBase {

  /**
   * The current user service.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;

  /**
   * The messenger service.
   *
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;


  /**
   * RequestStack.
   *
   * @var \Symfony\Component\HttpFoundation\RequestStack
   */
  protected $requestStack;

  /**
   * Constructor.
   *
   * @param \Symfony\Component\HttpFoundation\RequestStack $request_stack
   *   The request stack.
   * @param \Drupal\Core\Session\AccountProxyInterface $current_user
   *   The current user.
   * @param \Drupal\Core\Messenger\MessengerInterface $messenger
   *   The messenger.
   */
  public function __construct(
    RequestStack $request_stack,
    AccountProxyInterface $current_user,
    MessengerInterface $messenger,
  ) {
    $this->requestStack = $request_stack;
    $this->currentUser = $current_user;
    $this->messenger = $messenger;
  }

  /**
   * Create.
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *   The container.
   *
   * @return static
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('request_stack'),
      $container->get('current_user'),
      $container->get('messenger')
    );
  }

  /**
   * Track user.
   *
   * @param string $eid
   *   The eid.
   *
   * @return array
   *   The page.
   */
  public function trackUser($eid) {
    $current_user = $this->currentUser;

    $connection = Database::getConnection();
    $query = $connection->select('noahs_user_track', 'n')
      ->fields('n', ['uid'])
      ->condition('eid', $eid)
      ->execute()
      ->fetchAll();

    if (!empty($query)) {
      if (!in_array($current_user->id(), array_column($query, 'uid'))) {
        $this->messenger->addWarning('Otro usuario está editando este contenido.');
      }
    }
    else {
      $connection->insert('noahs_user_track')
        ->fields([
          'eid' => $eid,
          'uid' => $current_user->id(),
          'timestamp' => time(),
        ])
        ->execute();
    }

    return [
      '#markup' => "Tracking user with ID {$current_user->id()} on entity {$eid}.",
    ];
  }

}
