<?php

namespace Drupal\noahs_page_builder\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\token\TokenEntityMapperInterface;
use Drupal\token\TreeBuilderInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Modal tokens controller.
 */
class NoahsModalTokensController extends ControllerBase {
  /**
   * The token entity mapper service.
   *
   * @var \Drupal\token\TokenEntityMapperInterface
   */
  protected $tokenEntityMapper;

  /**
   * The token tree builder service.
   *
   * @var \Drupal\token\TreeBuilderInterface
   */
  protected $tokenTreeBuilder;

  /**
   * Constructs a new NoahsModalTokensController.
   *
   * @param \Drupal\token\TokenEntityMapperInterface $token_entity_mapper
   *   The token entity mapper service.
   * @param \Drupal\token\TreeBuilderInterface $token_tree_builder
   *   The token tree builder service.
   */
  public function __construct(
    TokenEntityMapperInterface $token_entity_mapper,
    TreeBuilderInterface $token_tree_builder,
  ) {
    $this->tokenEntityMapper = $token_entity_mapper;
    $this->tokenTreeBuilder = $token_tree_builder;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('token.entity_mapper'),
      $container->get('token.tree_builder')
    );
  }

  /**
   * Output tree.
   *
   * @return array
   *   The page.
   */
  public function outputTree() {

    $token_entity_mapping = $this->tokenEntityMapper;

    // Obtener una lista de tokens disponibles.
    $all_tokens = $token_entity_mapping->getEntityTypeMappings();
    $tree = $this->tokenTreeBuilder->buildAllRenderable(array_keys($all_tokens));
    $build = $tree;
    $build['#cache']['contexts'][] = 'url.query_args:options';
    $build['#title'] = $this->t('Available tokens');
    $build['#prefix'] = '<div>';
    $build['#suffix'] = '</div>';

    return $build;
  }

}
