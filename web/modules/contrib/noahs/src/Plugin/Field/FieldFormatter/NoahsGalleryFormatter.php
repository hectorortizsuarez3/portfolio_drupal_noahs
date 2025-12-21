<?php

namespace Drupal\noahs_page_builder\Plugin\Field\FieldFormatter;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Field\Annotation\FieldFormatter;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\File\FileUrlGeneratorInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Template\Attribute;
use Drupal\image\Entity\ImageStyle;
use Drupal\media\Entity\Media;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Plugin implementation of the 'noahs_gallery' formatter.
 *
 * @FieldFormatter(
 *   id = "noahs_gallery",
 *   label = @Translation("Noahs Gallery"),
 *   field_types = {
 *     "entity_reference"
 *   }
 * )
 */
class NoahsGalleryFormatter extends FormatterBase implements ContainerFactoryPluginInterface {

  protected EntityTypeManagerInterface $entityTypeManager;
  protected FileUrlGeneratorInterface $fileUrlGenerator;

  public function __construct($plugin_id, $plugin_definition, FieldDefinitionInterface $field_definition, array $settings, $label, $view_mode, array $third_party_settings, EntityTypeManagerInterface $entity_type_manager, FileUrlGeneratorInterface $file_url_generator) {
    parent::__construct($plugin_id, $plugin_definition, $field_definition, $settings, $label, $view_mode, $third_party_settings);
    $this->entityTypeManager = $entity_type_manager;
    $this->fileUrlGenerator = $file_url_generator;
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $plugin_id,
      $plugin_definition,
      $configuration['field_definition'],
      $configuration['settings'],
      $configuration['label'],
      $configuration['view_mode'],
      $configuration['third_party_settings'],
      $container->get('entity_type.manager'),
      $container->get('file_url_generator')
    );
  }

  public static function isApplicable(FieldDefinitionInterface $field_definition) {
    return $field_definition->getType() === 'entity_reference'
      && ($field_definition->getSetting('target_type') === 'media');
  }

  public static function defaultSettings() {
    return [
      'columns' => 3,
      'thumb_style' => 'original',
      'full_style' => 'original',
    ] + parent::defaultSettings();
  }

  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements = [];

    $style_options = ['original' => $this->t('Original')];
    foreach (ImageStyle::loadMultiple() as $id => $style) {
      $style_options[$id] = $style->label();
    }

    $elements['columns'] = [
      '#type' => 'select',
      '#title' => $this->t('Columns'),
      '#options' => [1=>1,2=>2,3=>3,4=>4,5=>5,6=>6],
      '#default_value' => (int) $this->getSetting('columns'),
    ];

    $elements['thumb_style'] = [
      '#type' => 'select',
      '#title' => $this->t('Thumbnail style'),
      '#options' => $style_options,
      '#default_value' => $this->getSetting('thumb_style'),
    ];

    $elements['full_style'] = [
      '#type' => 'select',
      '#title' => $this->t('Large image style (Fancybox)'),
      '#options' => $style_options,
      '#default_value' => $this->getSetting('full_style'),
    ];

    return $elements;
  }

  public function settingsSummary() {
    $summary = [];
    $summary[] = $this->t('Columns: @c', ['@c' => (int) $this->getSetting('columns')]);
    $summary[] = $this->t('Thumb style: @t', ['@t' => $this->getSetting('thumb_style')]);
    $summary[] = $this->t('Full style: @f', ['@f' => $this->getSetting('full_style')]);
    return $summary;
  }

  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    $columns = (int) $this->getSetting('columns');
    $thumb_style = $this->getSetting('thumb_style');
    $full_style = $this->getSetting('full_style');

    $attributes = new Attribute([
      'class' => ['field-noahs-gallery', 'field-noahs-gallery--cols-' . max(1, min(6, $columns))],
      'data-fancybox' => 'field-noahs-gallery',
    ]);

    $gallery_items = [];

    $media_ids = [];
    foreach ($items as $delta => $item) {
      if (!empty($item->target_id)) {
        $media_ids[] = $item->target_id;
      }
    }

    if ($media_ids) {
      $media_list = Media::loadMultiple($media_ids);
      foreach ($media_list as $media) {
        if (!in_array($media->bundle(), ['noahs_image', 'image'], TRUE)) {
          continue;
        }
        $field_name = 'field_media_image';
        if (!$media->hasField($field_name) || $media->get($field_name)->isEmpty()) {
          continue;
        }
        $image_item = $media->get($field_name)->first();
        $file = $image_item ? $image_item->entity : NULL;
        if (!$file) {
          continue;
        }
        $uri = $file->getFileUri();
        $alt = $image_item->get('alt')->getString() ?: '';

        $thumb = NULL;
        if ($thumb_style === 'original') {
          $thumb = $this->fileUrlGenerator->generateString($uri);
        }
        else {
          $style = ImageStyle::load($thumb_style);
          $thumb = $style ? $style->buildUrl($uri) : $this->fileUrlGenerator->generateString($uri);
        }

        $full = NULL;
        if ($full_style === 'original') {
          $full = $this->fileUrlGenerator->generateString($uri);
        }
        else {
          $fstyle = ImageStyle::load($full_style);
          $full = $fstyle ? $fstyle->buildUrl($uri) : $this->fileUrlGenerator->generateString($uri);
        }

        $gallery_items[] = [
          'thumb_src' => $thumb,
          'full_src' => $full,
          'alt' => $alt,
          'title' => $alt,
        ];
      }
    }

    $elements[] = [
      '#theme' => 'noahs_gallery',
      '#attributes' => $attributes,
      '#columns' => $columns,
      '#items' => $gallery_items,
    ];

    return $elements;
  }
}
