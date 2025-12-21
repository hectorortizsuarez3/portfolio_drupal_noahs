<?php

namespace Drupal\noahs_page_builder\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\file\Entity\File;
use Drupal\image\Entity\ImageStyle;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\ReplaceCommand;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\Core\File\FileSystemInterface;
use Symfony\Component\HttpFoundation\Request;
use Drupal\media\Entity\Media;
use Drupal\views\Views;
use Drupal\Core\File\FileUrlGeneratorInterface;
use Drupal\Component\Datetime\TimeInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Modal media controller.
 */
class NoahsModalMediaController extends ControllerBase {

  /**
   * The file system service.
   *
   * @var \Drupal\Core\File\FileSystemInterface
   */
  protected $fileSystem;

  /**
   * The file URL generator.
   *
   * @var \Drupal\Core\File\FileUrlGeneratorInterface
   */
  protected $fileUrlGenerator;

  /**
   * The time service.
   *
   * @var \Drupal\Component\Datetime\TimeInterface
   */
  protected $time;

  /**
   * Constructor.
   *
   * @param \Drupal\Core\File\FileSystemInterface $file_system
   *   The file system service.
   * @param \Drupal\Core\File\FileUrlGeneratorInterface $file_url_generator
   *   The file URL generator service.
   * @param \Drupal\Component\Datetime\TimeInterface $time
   *   The time service.
   */
  public function __construct(
    FileSystemInterface $file_system,
    FileUrlGeneratorInterface $file_url_generator,
    TimeInterface $time
  ) {
    $this->fileSystem = $file_system;
    $this->fileUrlGenerator = $file_url_generator;
    $this->time = $time;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('file_system'),
      $container->get('file_url_generator'),
      $container->get('datetime.time')
    );
  }

  /**
   * The media modal.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The request.
   *
   * @return array
   *   The page.
   */

  public function mediaModal(Request $request) {

    $source = $request->query->get('source');
    $element_id = $request->query->get('element_id');
    $wid = $request->query->get('wid');
    $type = $request->query->get('type');

    $view = Views::getView('noahs_media_modal');
    $display_id = $source === 'video' ? 'block_3' : 'block_1';

    $view->setDisplay($display_id);
    $view->preExecute();
    $view->execute();

    $render = [
      '#theme' => 'noahs_media_modal_page',
      '#view_render' => $view->buildRenderable($display_id),
      '#source' => $source,
      '#element_id' => $element_id,
      '#wid' => $wid,
      '#type' => $type,
    ];

    $response = new AjaxResponse();
    $response->addCommand(new ReplaceCommand('#noahs-media-inner', $render));
    return $response;
  }


  /**
   * Upload media modal.
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   The json response.
   */
public function uploadMediaModal() {
  $files = $_FILES['files'] ?? NULL;
  $current_date = $this->time->getCurrentTime();
  $current_month = date('Y-m', $current_date);

  $directory = 'public://' . $current_month;
  $file_system = $this->fileSystem;
  $file_system->prepareDirectory($directory, FileSystemInterface::CREATE_DIRECTORY | FileSystemInterface::MODIFY_PERMISSIONS | FileSystemInterface::EXISTS_RENAME);

  $uploaded_files = [];

  foreach ($files['name'] as $key => $filename) {
    $filedata = file_get_contents($files['tmp_name'][$key]);
    $clean_filename = $this->sanitizeFileName($filename);
    $directory_url = $directory . '/' . $clean_filename;

    // Guardar el archivo en el sistema de archivos.
    $uploaded_file = $file_system->saveData($filedata, $directory_url, FileSystemInterface::EXISTS_RENAME);

    // Crear la entidad de archivo.
    $file = File::create([
      'uri' => $uploaded_file,
    ]);
    $file->setPermanent();
    $file->save();

    $mime = $file->getMimeType();
    $file_url = $this->fileUrlGenerator->generateString($file->getFileUri());
    $image_style_url = '';
    $media_id = NULL;

    $media_bundle = 'noahs_image';
    if (\Drupal::entityTypeManager()->getStorage('media_type')->load('image')) {
      if (!\Drupal::entityTypeManager()->getStorage('media_type')->load('noahs_image')) {
        $media_bundle = 'image';
      }
    }

    // Crear la entidad media con el bundle adecuado.
    if ($mime !== "image/svg+xml") {
      $media = Media::create([
        'bundle' => $media_bundle,
        'name' => $filename,
        'field_media_image' => [
          'target_id' => $file->id(),
        ],
      ]);
      $media->save();
      $media_id = $media->id();

      // Generar URL de estilo thumbnail.
      $image_style_url = ImageStyle::load('thumbnail')->buildUrl($file->getFileUri());
    }

    $uploaded_files[] = [
      'file_id'     => $file->id(),   // siempre el ID del File
      'media_id'    => $media_id,     // NULL si es SVG
      'file_url'    => $image_style_url ?: $file_url, // thumbnail si existe, si no URL directa
      'file_name'   => $file->getFilename(),
      'file_type'   => $mime,
      'file_fullurl'=> $file_url,
      'media_type'  => $media_bundle,
    ];
  }

  if (empty($uploaded_files)) {
    return new JsonResponse(['message' => 'No file has been sent.'], 400);
  }

  return new JsonResponse([
    'message' => 'Files uploaded successfully.',
    'files' => $uploaded_files,
  ]);
}

/**
 * Sanitize file name.
 *
 * @param string $filename
 *   The original file name.
 *
 * @return string
 *   The sanitized file name.
 */
protected function sanitizeFileName($filename) {
  // 1. Pasar a ASCII quitando acentos (si está disponible iconv).
  if (function_exists('iconv')) {
    $filename = iconv('UTF-8', 'ASCII//TRANSLIT', $filename);
  }

  // 2. Reemplazar espacios por guiones bajos.
  $filename = str_replace(' ', '_', $filename);

  // 3. Eliminar cualquier caracter que no sea letras, números, punto, guion o guion bajo.
  $filename = preg_replace('/[^A-Za-z0-9\.\-_]/', '', $filename);

  // 4. Pasar a minúsculas por consistencia.
  $filename = strtolower($filename);

  return $filename;
}

  /**
   * Upload ck media modal.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The request.
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   The json response.
   */
  public function uploadCkMediaModal(Request $request): JsonResponse {

    $file_system = $this->fileSystem;
    $file_url_generator = $this->fileUrlGenerator;
    $file = $request->files->get('upload');

    if ($file) {

      $directory = 'public://ckeditor_uploads/';
      $file_system->prepareDirectory($directory, FileSystemInterface::CREATE_DIRECTORY);
      $filename = $file_system->copy($file->getRealPath(), $directory . $file->getClientOriginalName(), FileSystemInterface::EXISTS_RENAME);

      $file_entity = File::create([
        'uri' => $filename,
        'status' => 1,
      ]);
      $file_entity->save();

      $file_url = $file_url_generator->generateAbsoluteString($file_entity->getFileUri());

      return new JsonResponse(['url' => $file_url]);
    }

    return new JsonResponse(['error' => 'Error uploading image'], 400);
  }

}
