<?php

namespace Drupal\noahs_page_builder;

use Drupal\noahs_page_builder\Service\ControlServices;
use Drupal\noahs_page_builder\ControlsManager;

/**
 * Modal form.
 */
class ModalForm {

  /**
   * The control service.
   *
   * @var \Drupal\noahs_page_builder\Service\ControlServices
   */
  protected $controlService;
  /**
   * The control service.
   *
   * @var Drupal\noahs_page_builder\ControlsManager
   */
  protected $controlsManager;

  /**
   * Constructs a new ModalForm object.
   *
   * @param \Drupal\noahs_page_builder\Service\ControlServices $controlService
   *   The control service.
   * @param \Drupal\noahs_page_builder\ControlsManager $controlsManager
   *   The control service.
   */
  public function __construct(ControlServices $controlService, ControlsManager $controlsManager) {
    $this->controlService = $controlService;
    $this->controlsManager = $controlsManager;
  }

  /**
   * Render form.
   *
   * @param array $fields
   *   The fields.
   * @param array $values
   *   The values.
   * @param int $delta
   *   The delta.
   * @param string $parent
   *   The parent.
   *
   * @return array
   *   The form.
   */
  public function renderForm($fields, $values, $delta = NULL, string $parent = NULL, array $unset = []): array {

    $extraFields = $this->controlService->defaultFields();
    $mergedFields = array_merge($fields, $extraFields);
    $widgetFields = $this->controlService->groupFields($mergedFields);

    // Unset fields if they are in the unset array.
    if (!empty($unset)) {
      foreach ($unset as $field) {
        if (isset($widgetFields[$field])) {
          unset($widgetFields[$field]);
        }
      }
    }
    $data_controls = $this->controlsManager->renderTabs($widgetFields, $values);

    $form[] = $data_controls['form'];

    return $form;
  }

  /**
   * Render sub fields.
   *
   * @param array $fields
   *   The fields.
   * @param array $values
   *   The values.
   * @param int $delta
   *   The delta.
   * @param string $parent
   *   The parent.
   *
   * @return array
   *   The form.
   */
  public function renderSubFields(array $fields, array $values = NULL, string $delta = NULL, string $parent = NULL): string {

    $tabs = [];

    $widgetFields = $this->controlService->groupFields($fields);
    $data_controls = $this->controlsManager->renderTabs($widgetFields, $values, 'multiple', $delta, $parent);

    return $data_controls['form'];
  }

}
