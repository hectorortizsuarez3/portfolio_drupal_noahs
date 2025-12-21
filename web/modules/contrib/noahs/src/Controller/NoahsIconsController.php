<?php

namespace Drupal\noahs_page_builder\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\File\FileUrlGeneratorInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\file\FileInterface;

/**
 * Icons controller.
 */
class NoahsIconsController extends ControllerBase {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * The file URL generator.
   *
   * @var \Drupal\Core\File\FileUrlGeneratorInterface
   */
  protected $fileUrlGenerator;

  /**
   * {@inheritdoc}
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager, FileUrlGeneratorInterface $file_url_generator) {
    $this->entityTypeManager = $entity_type_manager;
    $this->fileUrlGenerator = $file_url_generator;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager'),
      $container->get('file_url_generator')
    );
  }

  /**
   * List of icons.
   *
   * @return array
   *   The page.
   */
  public function listOfIcons() {

    return [
      '#theme' => 'noahs_icons_list',
      '#content' => 'dewdwe',
      '#icons' => $this->htmlIconsScript(),
      '#attached' => [
        'library' => [
          'noahs_page_builder/noahs_page_builder.fontawesome',
          'noahs_page_builder/noahs_page_builder.bootstrap',
        ],
      ],

    ];
  }

  /**
   * Get icons.
   *
   * @return array
   *   The icons.
   */
  private function getIcons() {

    $content = file_get_contents(NOAHS_PAGE_BUILDER_PATH . '/assets/icons.json');
    $json = json_decode($content);
    $icons = [];

    foreach ($json as $icon => $value) {

      foreach ($value->styles as $style) {

        $icons[$style][$icon] = "fa-$style fa-$icon";
      }
    }

    return $icons;

  }

  /**
   * Html icons script.
   *
   * @return string
   *   The html.
   */
  private function htmlIconsScript() {
    $icons = $this->getIcons();
    $firstIteration = TRUE;
    $files = $this->entityTypeManager->getStorage('file')
      ->loadByProperties([
        'filemime' => [
          'image/svg+xml',
        ],
      ]);

    $output = '';

    $output .= '<div class="noahs-icons-container">';
    $output .= '<div class="noahs-tabs-icon">';
    $output .= '<nav>';
    $output .= '<div class="nav nav-pills mb-3 justify-content-center" id="nav-tab" role="tablist">';
    foreach ($icons as $key => $items) {
      $output .= '<button class="nav-link ' . ($firstIteration ? 'active' : '') . ' text-uppercase p-3" id="nav-' . $key . '-tab" data-bs-toggle="tab" data-bs-target="#nav-' . $key . '" type="button" role="tab" aria-controls="nav-' . $key . '" aria-selected="true">' . $key . '</button>';
      $firstIteration = FALSE;
    }
    $output .= '<button class="nav-link text-uppercase p-3" id="nav-custom-svg-tab" data-bs-toggle="tab" data-bs-target="#nav-custom-svg" type="button" role="tab" aria-controls="nav-custom-svg" aria-selected="true">Custom Icons</button>';
    $output .= '</div>';
    $output .= '</nav>';
    $output .= '</div>';

    $output .= '<div class="tab-content p-3 border bg-light" id="nav-tabContent">';
    $output .= '<form>';
    $output .= '<div class="mb-3">';
    $output .= '<label for="iconSearch" class="form-label">Search Icon</label>';
    $output .= '<input type="text" class="form-control" id="iconSearch">';
    $output .= '</div>';
    $output .= '</form>';

    $firstIteration = TRUE;
    foreach ($icons as $key => $items) {
      $output .= '<div class="tab-pane fade ' . ($firstIteration ? 'active show' : '') . '" id="nav-' . $key . '" role="tabpanel" aria-labelledby="nav-' . $key . '-tab">';
      $output .= '<div class="d-flex flex-wrap g-2">';
      $output .= '<div class="col-12"><div class="text-uppercase">' . $key . '</div></div>';

      foreach ($items as $k => $icon) {
        $output .= '<div class="col-1" data-group="' . $key . '" data-icon="' . $icon . '" data-bs-toggle="tooltip" data-bs-placement="top" title="' . $k . '">';
        $output .= '<div class="p-3 border d-flex justify-content-center"><i class="' . $icon . '"></i></div>';
        $output .= '</div>';
      }

      $output .= '</div>';
      $output .= '</div>';
      $firstIteration = FALSE;
    }

    $output .= '<div class="tab-pane fade" id="nav-custom-svg" role="tabpanel" aria-labelledby="nav-custom-svg-tab">';
    $output .= '<div class="d-flex flex-wrap g-2">';
    $output .= '<div class="col-12"><h4>custom-svg</h4></div>';
    $output .= '</div>';
    $output .= '<div class="row mb-2 noahs-customs-svg">';

    // Ordenar los archivos por fecha de creación en orden descendente
    usort($files, function ($a, $b) {
      return $b->getCreatedTime() <=> $a->getCreatedTime();
    });

    foreach ($files as $file) {
      if ($file instanceof FileInterface) {
        $file_uri = $file->getFileUri();
        $svg_local_url = $this->fileUrlGenerator->generateAbsoluteString($file_uri);
        $output .= '<div class="col-2 image-box" data-fileid="' . $file->id() . '" data-thumbnail="' . $svg_local_url . '"><span><img src="' . $svg_local_url . '" class="w-100" alt="Thumbnail"></span></div>';
      }
    }
    $output .= '</div>';
    $output .= '</div>';
    $output .= '</div>';
    $output .= '<div class="upload-image mt-4">';
    $output .= '<form id="noahs_page_builderUploadImageForm" enctype="multipart/form-data">';
    $output .= '<label>' . $this->t('Upload Media') . '</label>';
    $output .= '<input type="file" id="noahs_page_builder_upload_svg" name="noahs_page_builder_upload_svg" title="Upload Media" accept="image/svg+xml" class="form-control">';
    $output .= '</form>';
    $output .= '<div class="modal-messages"></div>';
    $output .= '</div>';
    $output .= '</div>';

    return $output;
  }

  /**
   * The modal.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The request.
   *
   * @return \Symfony\Component\HttpFoundation\Response
   *   The response.
   */
  public function modal(Request $request) {
    $data = json_decode($request->getContent(), TRUE);
    $wid = $data['wid'];
    $delta = $data['delta'];
    $output = '<div class="modal fade" id="noahsIconsModal" tabindex="-1" aria-labelledby="noahsIconsModalLabel" aria-hidden="true">';
    $output .= '<div class="modal-dialog modal-lg">';
    $output .= '<div class="modal-content">';
    $output .= '<div class="modal-header">';
    $output .= '<h5 class="modal-title" id="noahsIconsModalLabel">' . $this->t('Icons') . '</h5>';
    $output .= '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
    $output .= '</div>';
    $output .= '<div class="modal-body">';
    $output .= $this->htmlIconsScript();
    $output .= '</div>';
    $output .= '<div class="modal-footer">';
    $output .= '<button type="button" class="btn btn-success insert-icon-modal" data-element-id="' . $data['element_id'] . '" data-wid="' . $wid . '" data-delta="' . $delta . '" data-thumbnail="" data-bs-dismiss="modal" aria-label="Close">' . $this->t('Insert selected') . '</button>';
    $output .= '</div>';
    $output .= '</div>';
    $output .= '</div>';
    $output .= '</div>';

    return new Response($output);
  }

}
