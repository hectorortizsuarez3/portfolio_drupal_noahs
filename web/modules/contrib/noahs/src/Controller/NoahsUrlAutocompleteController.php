<?php

namespace Drupal\noahs_page_builder\Controller;

use Drupal\node\Entity\Node;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Component\Utility\Xss;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Url autocomplete controller.
 */
class NoahsUrlAutocompleteController extends ControllerBase {

  /**
   * The entity type manager service.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a new controller object.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container): self {
    return new static(
      $container->get('entity_type.manager')
    );
  }

  /**
   * Autocomplete.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The request.
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   The json response.
   */
  public function autocomplete(Request $request) {
    $grouped = [];
    $input = $request->query->get('q');

    if (!$input) {
      return new JsonResponse([]);
    }

    $input = Xss::filter($input);

    $query = $this->entityTypeManager->getStorage('node')
      ->getQuery()
      ->condition('title', $input, 'CONTAINS')
      ->sort('created', 'DESC')
      ->range(0, 30)
      ->accessCheck(TRUE);

    $ids = $query->execute();
    $nodes = Node::loadMultiple($ids);

    // Obtener labels de los bundles
    $bundle_labels = [];
    $bundles = $this->entityTypeManager->getStorage('node_type')->loadMultiple();
    foreach ($bundles as $bundle_id => $bundle) {
      $bundle_labels[$bundle_id] = $bundle->label();
    }

    // Agrupar por tipo de contenido
    foreach ($nodes as $node) {
      $bundle = $node->bundle();
      $label = $bundle_labels[$bundle] ?? $bundle;
      if (!isset($grouped[$bundle])) {
        $grouped[$bundle] = [
          'text' => $label,
          'children' => [],
        ];
      }
      $grouped[$bundle]['children'][] = [
        'id' => $node->id(),
        'text' => $node->getTitle() . ' (' . $node->id() . ')',
      ];
    }

    // Devolver como array plano de grupos
    return new JsonResponse(array_values($grouped));
  }

}
