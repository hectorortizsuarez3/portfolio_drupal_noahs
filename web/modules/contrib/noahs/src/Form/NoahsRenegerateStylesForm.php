<?php

namespace Drupal\noahs_page_builder\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\noahs_page_builder\Controller\NoahsSaveStylesController;
use Drupal\Core\Database\Connection;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\DependencyInjection\ClassResolverInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Defines a form that configures noahs_page_builder settings.
 */
class NoahsRenegerateStylesForm extends ConfigFormBase {

  /**
   * The database.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $database;

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * The class resolver.
   *
   * @var \Drupal\Core\DependencyInjection\ClassResolverInterface
   */
  protected $classResolver;

  /**
   * Constructor.
   *
   * @param \Drupal\Core\Database\Connection $database
   *   The database connection.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   * @param \Drupal\Core\DependencyInjection\ClassResolverInterface $class_resolver
   *   The class resolver.
   */
  public function __construct(Connection $database, EntityTypeManagerInterface $entity_type_manager, ClassResolverInterface $class_resolver) {
    $this->database = $database;
    $this->entityTypeManager = $entity_type_manager;
    $this->classResolver = $class_resolver;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database'),
      $container->get('entity_type.manager'),
      $container->get('class_resolver')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'noahs-regenerate-styles-form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['noahs_page_builder.regenerate_styels'];
  }

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state, $nid = NULL) {

  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $elements = $this->database->select('noahs_page_builder_page', 'd')
      ->fields('d', ['entity_id', 'entity_type'])
      ->execute()
      ->fetchAll();

    foreach ($elements as $element) {
      if (empty($element->entity_type)) {

        if (strpos($element->entity_id, 'product_') !== FALSE) {
          $entity_id = str_replace('product_', '', $element->entity_id);
          $entity = $this->entityTypeManager->getStorage('commerce_product')->load($entity_id);
          $this->database->update("noahs_page_builder_page")
            ->fields([
              'noahs_id' => $entity->id(),
              'entity_type' => $entity->getEntityTypeId(),
              'entity_id' => $entity->id(),
            ])
            ->condition('entity_id', $element->entity_id)
            ->execute();

        }
        else {
          $entity = $this->entityTypeManager->getStorage('node')->load($element->entity_id);
          $this->database->update("noahs_page_builder_page")
            ->fields([
              'noahs_id' => $entity->id(),
              'entity_type' => $entity->getEntityTypeId(),
              'entity_id' => $entity->id(),
            ])
            ->condition('entity_id', $entity->id())
            ->execute();
        }
      }
    }

    $new_elements = $this->database->select('noahs_page_builder_page', 'd')
      ->fields('d', ['entity_id', 'entity_type'])
      ->execute()
      ->fetchAll();

    foreach ($new_elements as $element) {

      $this->classResolver->getInstanceFromDefinition(NoahsSaveStylesController::class)
        ->save($element->entity_type, $element->entity_id);
    }
    $pro_elements = $this->database->select('noahs_page_builder_pro_themes', 'd')
      ->fields('d')
      ->execute()
      ->fetchAll();

    foreach ($pro_elements as $element) {
      $this->classResolver->getInstanceFromDefinition(NoahsSaveStylesController::class)
        ->save('pro_theme', $element->type);
    }

  }

}
