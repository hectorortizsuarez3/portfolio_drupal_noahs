<?php

namespace Drupal\noahs_page_builder\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\File\FileSystemInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\Database\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides Themes for Noah's Builder.
 */
class NoahsThemesController extends ControllerBase {

  /**
   * The database connection.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $database;

  /**
   * The file system service.
   *
   * @var \Drupal\Core\File\FileSystemInterface
   */
  protected $fileSystem;

  /**
   * Constructs a new NoahsThemesController.
   *
   * @param \Drupal\Core\Database\Connection $database
   *   The database service.
   * @param \Drupal\Core\File\FileSystemInterface $file_system
   *   The file system service.
   */
  public function __construct(
    Connection $database,
    FileSystemInterface $file_system
  ) {
    $this->database = $database;
    $this->fileSystem = $file_system;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database'),
      $container->get('file_system'),
    );
  }

  /**
   * Get theme.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The request.
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   The json response.
   */
  public function getTheme(Request $request) {
    $data = json_decode($request->getContent(),);
    // $data['url'] = 'https://page-builder.ddev.site/modules/custom/noahs_page_builder/assets/noahs-themes/test_template.json';
    $json_string = file_get_contents($data->url);
    $widget = json_decode($json_string);

    return new JsonResponse(noahs_page_builder_html_generated(json_decode($widget->settings)));
  }

  /**
   * Modal themes.
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   The json response.
   */
  public function modalThemes(): JsonResponse {
    return new JsonResponse(['html' => $this->listOfThemes()]);
  }

  /**
   * List of themes.
   *
   * @return string
   *   The html.
   */
  private function listOfThemes(): string {

    $schema = $this->database->schema();
    $builder = NULL;
    if ($schema->tableExists('noahs_page_builder_pro_theme')) {
      $builder = $this->database->select('noahs_page_builder_pro_theme', 'mt')
        ->fields('mt', ['id', 'title'])
        ->execute()
        ->fetchAll();
    }

    $noahs_themes = [];
    $noahs_themes_categories = [];
    $module_path = NOAHS_PAGE_BUILDER_PATH;

    $themes_folder_path = $module_path . '/assets/noahs-themes/';
    $json_folder_path = $themes_folder_path . 'data/';
    $files = $this->fileSystem->scanDirectory($json_folder_path, '/\.json$/');

    // Permitir que otros módulos alteren los archivos escaneados.
    \Drupal::moduleHandler()->alter('noahs_themes_files', $files);

    // Ordenar los archivos por la letra y el número en el prefijo del nombre del archivo
    usort($files, function ($a, $b) {
      preg_match('/^([A-Za-z])(\d+)/', basename($a->filename), $matchesA);
      preg_match('/^([A-Za-z])(\d+)/', basename($b->filename), $matchesB);

      $letterA = $matchesA[1] ?? '';
      $letterB = $matchesB[1] ?? '';
      $numberA = (int) ($matchesA[2] ?? 0);
      $numberB = (int) ($matchesB[2] ?? 0);

      return [$letterA, $numberA] <=> [$letterB, $numberB];
    });

    global $base_root;
    foreach ($files as $index => $file) {
      $json_string = file_get_contents($base_root . '/' . $file->uri);
      $data = json_decode($json_string, TRUE);
      $data['url'] = $base_root . '/' . $file->uri;
      $noahs_themes[] = $data;
      $noahs_themes_categories[$data['category']] = $data['category'];
    }

    $output = '<div class="modal fade modal-type-themes" id="noahsSectionThemeModal" tabindex="-1">';
    $output .= '<div class="modal-dialog modal-xl">';
    $output .= '<div class="modal-content">';
    $output .= '<div class="modal-header">
        <h5 class="modal-title">' . t('Themes') . '</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>';
    $output .= '<div class="modal-body">';
    $output .= '<nav>';
    $output .= '<div class="nav nav-tabs" id="nav-tab" role="tablist">';
    $output .= '<button class="nav-link active" id="nav-noahs-theme-tab" data-bs-toggle="tab" data-bs-target="#nav-noahs-theme" type="button" role="tab" aria-controls="nav-noahs-theme" aria-selected="true">' . t('Noahs themes') . '</button>';
    $output .= '<button class="nav-link" id="nav-user-noahs-theme-tab" data-bs-toggle="tab" data-bs-target="#nav-user-noahs-theme" type="button" role="tab" aria-controls="nav-user-noahs-theme" aria-selected="true">' . t('My themes') . '</button>';
    $output .= '</div>';
    $output .= '</nav>';
    $output .= '<div class="tab-content p-3 border bg-light" id="nav-tabContent">';
    $output .= '<form>';
    $output .= '<div class="mb-3">';
    $output .= '<label for="searchThemes" class="form-label">' . t('Search theme') . '</label>';
    $output .= '<input type="text" class="form-control element-admin" id="searchThemes">';
    $output .= '</div>';
    $output .= '</form>';
    $output .= '<div class="tab-pane fade active show" id="nav-noahs-theme" role="tabpanel" aria-labelledby="nav-noahs-theme-tab">';

    $output .= '<div class="d-flex justify-content-center mb-4">';
    $output .= '<div class="btn-group" role="group" aria-label="Filter by category">';
    $output .= '<input name="filterThemeCheck" type="radio" class="btn-check filter-theme-check" id="all_themes" autocomplete="off" checked>';
    $output .= '<label class="btn btn-admin btn-outline-primary" for="all_themes">' . t('All') . '</label>';
    foreach ($noahs_themes_categories as $k => $item) {
      $output .= '<input type="radio" name="filterThemeCheck" class="btn-check filter-theme-check" id="btncheck_' . $k . '" autocomplete="off">';
      $output .= '<label class="btn btn-outline-primary btn-admin" for="btncheck_' . $k . '">' . t($item) . '</label>';
    }

    $output .= '</div>';
    $output .= '</div>';

    $output .= '<div class="row row-cols-3 g-4">';

    foreach ($noahs_themes as $k => $item) {

      $output .= '<div class="col" data-bs-toggle="tooltip" data-bs-placement="top" data-category="' . $item['category'] . '" data-title="' . $item['title'] . '">';
      $output .= '<div class="card noahs_paste_default_theme h-100" data-url="' . $item['url'] . '" data-group="noahs-theme">
                  <img src="/' . $themes_folder_path . '/images/' . $item['thumbnail'] . '" class="card-img-top" alt="...">
                  <div class="card-body">
                    <h5 class="card-title">' . $item['title'] . '</h5>
                </div>
      </div>';

      $output .= '</div>';
    }
    $output .= '</div>';
    $output .= '</div>';
    $output .= '<div class="tab-pane fade" id="nav-user-noahs-theme" role="tabpanel" aria-labelledby="nav-user-noahs-theme-tab">';
    $output .= '<div class="d-flex flex-wrap g-2">';
    if ($builder) {
      foreach ($builder as $k => $item) {
        $output .= '<div class="col-4" data-group="user-noahs-theme" data-bs-toggle="tooltip" data-bs-placement="top">';
        $output .= '<div class="p-3 border d-flex justify-content-center noahs_paste_saved_theme" data-id="' . $item->id . '">' . $item->title . '</div>';
        $output .= '</div>';
      }
    }
    else {
      $link = '<a href="https://noahs-creator.com" target="_blank">Noahs PRO</a>';
      $output .= '<div class="col-12"><h4>' . sprintf('You need to install %s to use this feature.', $link) . '</h4></div>';
    }

    $output .= '</div>';
    $output .= '</div>';
    $output .= '</div>';
    $output .= '<div class="modal-footer px-0 pb-0 justify-content-end">
                <button type="button" class="btn btn-danger btn-admin" data-bs-dismiss="modal">' . t('Cancel') . '</button>';
    $output .= '</div>';
    $output .= '</div>';
    $output .= '</div>';
    $output .= '</div>';
    $output .= '</div>';

    return $output;

  }

}
