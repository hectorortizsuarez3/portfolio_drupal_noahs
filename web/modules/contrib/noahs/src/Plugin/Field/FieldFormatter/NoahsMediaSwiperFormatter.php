<?php

namespace Drupal\noahs_page_builder\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\Annotation\FieldFormatter;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\media\Entity\Media;
use Drupal\image\Entity\ImageStyle;
use Drupal\Core\Template\Attribute;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\File\FileUrlGeneratorInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Plugin implementation of the 'noahs_media_swiper' formatter.
 *
 * @FieldFormatter(
 *   id = "noahs_media_swiper",
 *   label = @Translation("Noahs Media Swiper"),
 *   field_types = {
 *     "entity_reference"
 *   }
 * )
 */
class NoahsMediaSwiperFormatter extends FormatterBase implements ContainerFactoryPluginInterface {

  /** @var EntityTypeManagerInterface */
  protected $entityTypeManager;

  /** @var FileUrlGeneratorInterface */
  protected $fileUrlGenerator;

  /**
   * {@inheritdoc}
   */
  public function __construct($plugin_id, $plugin_definition, FieldDefinitionInterface $field_definition, array $settings, $label, $view_mode, array $third_party_settings, EntityTypeManagerInterface $entity_type_manager, FileUrlGeneratorInterface $file_url_generator) {
    parent::__construct($plugin_id, $plugin_definition, $field_definition, $settings, $label, $view_mode, $third_party_settings);
    $this->entityTypeManager = $entity_type_manager;
    $this->fileUrlGenerator = $file_url_generator;
  }

  /**
   * {@inheritdoc}
   */
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

  /**
   * {@inheritdoc}
   */
  public static function isApplicable(FieldDefinitionInterface $field_definition) {
    // Solo para campos que referencian entidades media.
    return $field_definition->getType() === 'entity_reference'
      && ($field_definition->getSetting('target_type') === 'media');
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'image_style' => 'original',
      'slides_per_view' => [
        'desktop' => 1,
        'tablet' => 1,
        'mobile' => 1,
      ],
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements = [];

    // Estilo de imagen.
    $style_options = [];
    foreach (ImageStyle::loadMultiple() as $id => $style) {
      $style_options[$id] = $style->label();
    }
    $elements['image_style'] = [
      '#type' => 'select',
      '#title' => $this->t('Image style'),
      '#options' => ['original' => $this->t('Original')] + $style_options,
      '#default_value' => $this->getSetting('image_style'),
    ];

    // Slides por vista.
    $elements['slides_per_view'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Slides per view'),
    ];
    $elements['slides_per_view']['desktop'] = [
      '#type' => 'number',
      '#title' => $this->t('Desktop'),
      '#min' => 1,
      '#default_value' => (int) $this->getSetting('slides_per_view')['desktop'],
    ];
    $elements['slides_per_view']['tablet'] = [
      '#type' => 'number',
      '#title' => $this->t('Tablet'),
      '#min' => 1,
      '#default_value' => (int) $this->getSetting('slides_per_view')['tablet'],
    ];
    $elements['slides_per_view']['mobile'] = [
      '#type' => 'number',
      '#title' => $this->t('Mobile'),
      '#min' => 1,
      '#default_value' => (int) $this->getSetting('slides_per_view')['mobile'],
    ];

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    $style = $this->getSetting('image_style');
    $spv = $this->getSetting('slides_per_view');
    $summary[] = $this->t('Image style: @style', ['@style' => $style]);
    $summary[] = $this->t('Slides per view - Desktop: @d, Tablet: @t, Mobile: @m', [
      '@d' => (int) $spv['desktop'],
      '@t' => (int) $spv['tablet'],
      '@m' => (int) $spv['mobile'],
    ]);
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    $settings = $this->getSettings();
    $spv = $settings['slides_per_view'];
    $image_style = $settings['image_style'];

    $wrapper_attributes = [
      'class' => ['noahs_page_builder-carousel', 'swiper'],
      'data-show-items-desktop' => (string) (int) $spv['desktop'],
      'data-show-items-tablet' => (string) (int) $spv['tablet'],
      'data-show-items-mobile' => (string) (int) $spv['mobile'],
    ];

    $slides = [];

    $media_ids = [];
    foreach ($items as $delta => $item) {
      if (!empty($item->target_id)) {
        $media_ids[] = $item->target_id;
      }
    }

    if ($media_ids) {
      $media_list = Media::loadMultiple($media_ids);
      foreach ($media_list as $mid => $media) {
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

        $image_url = ($image_style === 'original')
          ? $this->fileUrlGenerator->generateString($uri)
          : $this->entityTypeManager->getStorage('image_style')->load($image_style)->buildUrl($uri);

        $slides[] = [
          'src' => $image_url,
          'alt' => $alt,
          'title' => $alt,
          'classes' => ['widget-image-src', 'img-fluid'],
        ];
      }
    }

    $elements[] = [
      '#theme' => 'noahs_media_swiper',
      '#attributes' => new Attribute($wrapper_attributes),
      '#slides' => $slides,
    ];

    return $elements;
  }
}
