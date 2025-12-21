<?php

namespace Drupal\noahs_page_builder\Plugin\Widget;

use Drupal\file\Entity\File;
use Drupal\image\Entity\ImageStyle;

/**
 * @WidgetPlugin(
 *   id = "noahs_video",
 *   label = @Translation("Video")
 * )
 */
class WidgetNoahsVideo extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function data() {
    return [
      'icon' => '<svg height="512pt" viewBox="-31 0 512 512" width="512pt" xmlns="http://www.w3.org/2000/svg" id="fi_1179120"><g fill-rule="evenodd"><path d="m440.589844 206.675781h-341.171875l327.699219-94.929687c2.546874-.738282 4.695312-2.460938 5.976562-4.78125 1.28125-2.324219 1.585938-5.058594.847656-7.605469l-17.148437-59.199219c-6.851563-23.644531-28.867188-40.160156-53.539063-40.160156-5.199218 0-10.378906.738281-15.402344 2.191406l-307.675781 89.128906c-14.230469 4.121094-26.023437 13.582032-33.214843 26.632813-7.1875 13.050781-8.875 28.078125-4.753907 42.304687l16.753907 57.835938v238.253906c0 30.6875 24.964843 55.652344 55.648437 55.652344h120.164063c5.523437 0 10-4.476562 10-10s-4.476563-10-10-10h-120.160157c-19.660156 0-35.652343-15.992188-35.652343-35.652344v-136.085937h51.230468.023438.019531 78.3125.023437.023438 78.3125.023438.023437 78.3125.023437.019532 105.28125v136.085937c0 19.660156-15.992188 35.652344-35.652344 35.652344h-120.164062c-5.519532 0-10 4.476562-10 10s4.480468 10 10 10h120.164062c30.6875 0 55.652344-24.964844 55.652344-55.652344v-239.671875c0-5.523437-4.476563-10-10-10zm-176.332032 93.585938 42.488282-73.585938h55.261718l-42.484374 73.585938zm-78.359374 0 42.488281-73.585938h55.261719l-42.484376 73.585938zm-78.355469 0 42.484375-73.585938h55.265625l-42.488281 73.585938zm37.179687-129.457031-71.148437-68.335938 53.308593-15.441406c.375.546875.8125 1.0625 1.3125 1.542968l71.148438 68.335938-53.308594 15.441406c-.375-.546875-.816406-1.066406-1.3125-1.542968zm134-125.839844 71.148438 68.335937-53.308594 15.441407c-.375-.546876-.8125-1.066407-1.3125-1.542969l-71.148438-68.335938 53.308594-15.441406c.375.546875.8125 1.0625 1.3125 1.542969zm-75.265625 21.804687 71.148438 68.332031-53.308594 15.445313c-.375-.546875-.8125-1.066406-1.3125-1.542969l-71.148437-68.335937 53.308593-15.441407c.378907.542969.816407 1.0625 1.3125 1.542969zm149.960938-45.367187c3.210937-.929688 6.519531-1.402344 9.835937-1.402344 15.824219 0 29.9375 10.578125 34.328125 25.726562l14.367188 49.589844-40.121094 11.621094c-.378906-.546875-.816406-1.0625-1.316406-1.542969l-71.144531-68.332031zm-328.9375 106.199218c4.609375-8.371093 12.160156-14.433593 21.261719-17.070312l5.875-1.703125c.378906.546875.816406 1.066406 1.3125 1.542969l71.148437 68.335937-88.292969 25.578125-14.367187-49.589844c-2.636719-9.097656-1.546875-18.71875 3.0625-27.09375zm14.480469 99.074219h87.972656l-42.484375 73.585938h-45.488281zm303.65625 73.585938 42.484374-73.585938h45.488282v73.585938zm0 0"></path><path d="m303.921875 405.113281c0-3.574219-1.90625-6.875-5-8.660156l-87.855469-50.722656c-3.09375-1.785157-6.90625-1.785157-10 0-3.09375 1.785156-5 5.085937-5 8.660156v101.445313c0 3.570312 1.90625 6.871093 5 8.65625 1.546875.894531 3.273438 1.34375 5 1.34375 1.726563 0 3.453125-.449219 5-1.34375l87.855469-50.71875c3.09375-1.785157 5-5.085938 5-8.660157zm-87.855469 33.402344v-66.804687l57.855469 33.402343zm0 0"></path><path d="m234.773438 492c-5.507813 0-10 4.492188-10 10s4.492187 10 10 10c5.511718 0 10-4.492188 10-10s-4.488282-10-10-10zm0 0"></path></g></svg>',
      'title' => 'Video',
      'description' => 'Iframe Video',
      'group' => 'General',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildWidgetForm(array $form) {

    $form['section_content'] = [
      'type' => 'tab',
      'title' => t('Content'),
    ];

    $form['video_type'] = [
      'type'    => 'select',
      'title'   => t('Video type'),
      'tab' => 'section_content',
      'options' => [
        'youtube' => 'Youtube',
        'local' => t('Local'),
      ],
    ];
    $form['video_url'] = [
      'type' => 'text',
      'title' => t('Video URL'),
      'tab' => 'section_content',
      'description' => t('Use a video provider or paste a your video url.'),
      'style_type'      => 'attribute',
      'style_selector'  => '.noahs-video-iframe',
      'attribute_type'  => 'src',
      'default_value'  => 'https://www.youtube.com/embed/FL0aKqxxvHc?si=TdeVmLWdWNPcb6op',
      'state' => [
        'visible' => [
          'video_type' => ['value' => 'youtube'],
        ],
      ],
    ];
    $form['video_local'] = [
      'type' => 'noahs_video_upload',
      'title' => t('Video Local'),
      'tab' => 'section_content',
      'description' => t('Use a video provider or paste a your video url.'),
      'state' => [
        'visible' => [
          'video_type' => ['value' => 'local'],
        ],
      ],
    ];

    $form['video_container_width'] = [
      'type'    => 'text',
      'title'   => t('Video Width'),
      'tab' => 'section_content',
      'placeholder'     => t('Custom Video Width in px, %, vw...'),
      'style_type' => 'style',
      'style_selector' => '.noahs-video-wrapper',
      'style_css' => 'width',
      'responsive' => TRUE,
    ];
    $form['video_container_height'] = [
      'type'    => 'text',
      'title'   => t('Video Height'),
      'tab' => 'section_content',
      'placeholder'     => t('Custom Video Height in px, %, vw...'),
      'style_type' => 'style',
      'style_selector' => '.noahs-video-wrapper',
      'style_css' => 'height',
      'responsive' => TRUE,
    ];
    $form['video_horizontal_align'] = [
      'type'    => 'select',
      'title'   => t('Horizontal Align'),
      'tab' => 'section_content',
      'style_type' => 'style',
      'style_selector' => '.widget-wrapper',
      'style_css' => 'justify-content',
      'responsive' => TRUE,
      'options' => [
        'center' => 'Center',
        'flex-start' => 'Start',
        'flex-end' => 'End',
      ],
    ];
    $form['video_group_settings'] = [
      'title' => t('Video Settings'),
      'type' => 'group',
    ];

    $form['video_start'] = [
      'type' => 'number',
      'title' => t('Start in'),
      'description' => t('Use in seconds'),
      'group' => 'video_group_settings',
      'tab' => 'section_content',
      'wrapper' => FALSE,
      'attributes' => [
        'class' => 'noahs-regenerate-design',
      ],
    ];
    $form['video_end'] = [
      'type' => 'number',
      'title' => t('End in'),
      'description' => t('Use in seconds'),
      'group' => 'video_group_settings',
      'tab' => 'section_content',
      'wrapper' => FALSE,
      'attributes' => [
        'class' => 'noahs-regenerate-design',
      ],
    ];
    $form['video_autoplay'] = [
      'type' => 'checkbox',
      'title' => t('Auto play'),
      'value' => 1,
      'default_value' => 0,
      'group' => 'video_group_settings',
      'tab' => 'section_content',
      'wrapper' => FALSE,
      'attributes' => [
        'class' => 'noahs-regenerate-design',
      ],
    ];
    $form['video_mute'] = [
      'type' => 'checkbox',
      'title' => t('Mute'),
      'value' => TRUE,
      'default_value' => FALSE,
      'group' => 'video_group_settings',
      'tab' => 'section_content',
      'wrapper' => FALSE,
      'attributes' => [
        'class' => 'noahs-regenerate-design',
      ],
    ];

    $form['video_loop'] = [
      'type' => 'checkbox',
      'title' => t('Loop'),
      'value' => TRUE,
      'default_value' => FALSE,
      'group' => 'video_group_settings',
      'wrapper' => FALSE,
      'tab' => 'section_content',
      'attributes' => [
        'class' => 'noahs-regenerate-design',
      ],
    ];

    $form['video_controls'] = [
      'type' => 'checkbox',
      'title' => t('Controls'),
      'value' => TRUE,
      'default_value' => FALSE,
      'wrapper' => FALSE,
      'group' => 'video_group_settings',
      'tab' => 'section_content',
      'attributes' => [
        'class' => 'noahs-regenerate-design',
      ],
    ];

    $form['video_class'] = [
      'type'    => 'text',
      'title'   => ('Custom CSS classes'),
      'style_type' => 'class',
      'style_selector' => '.noahs-video-iframe',
      'tab' => 'section_content',
      'placeholder' => 'Multiple classes should be separated with SPACE.',
    ];

    $form['video_image'] = [
      'type'    => 'noahs_image',
      'title'   => ('Poster Image'),
      'tab' => 'section_content',
    ];

    $form['section_styles'] = [
      'type' => 'tab',
      'title' => t('Styles'),
    ];

    $form['border'] = [
      'type' => 'noahs_border',
      'title' => t('Border'),
      'tab' => 'section_styles',
      'style_type' => 'style',
      'style_selector' => '.noahs-video-iframe',
      'style_css' => 'border',
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];

    $form['video_margin'] = [
      'type' => 'noahs_margin',
      'title' => t('Margin'),
      'tab' => 'section_styles',
      'style_type' => 'style',
      'style_selector' => '.noahs-video-iframe',
      'style_css' => 'margin',
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];

    $form['video_padding'] = [
      'type' => 'noahs_padding',
      'title' => t('Padding'),
      'tab' => 'section_styles',
      'style_type' => 'style',
      'style_selector' => '.noahs-video-iframe',
      'style_css' => 'padding',
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];
    $form['video_shadows'] = [
      'type'    => 'noahs_shadows',
      'title'   => t('Video Shadow'),
      'tab' => 'section_styles',
      'style_type' => 'style',
      'style_selector' => '.noahs-video-iframe',
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];
    $form['video_radius'] = [
      'type'    => 'noahs_radius',
      'title'   => t('Border Radius'),
      'tab' => 'section_styles',
      'style_type' => 'style',
      'style_selector' => '.noahs-video-iframe',
      'responsive' => TRUE,
      'style_hover' => TRUE,
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function template($settings) {
    $settings = $settings->element;

    $url = 'https://www.youtube.com/watch?v=FL0aKqxxvHc';
    $video_settings = [];
    $image = NULL;
    $file_name = NULL;
    $video_local_url = NULL;

    if (!empty($settings->video_url->text)) {
      $url = $settings->video_url->text;
    }

    if (!empty($settings->video_image->fid)) {
      $file = File::load($settings->video_image->fid);
      $file_uri = $file->getFileUri();

      if (!empty($settings->video_image->image_style)) {
        $image = ImageStyle::load($settings->video_image->image_style)->buildUrl($file_uri);
      }
      else {
        $image = $this->fileUrlGenerator->generateAbsoluteString($file_uri);
      }
    }

    if (!empty($settings->video_local->fid)) {
      $video_file = File::load($settings->video_local->fid);
      $video_file_uri = $video_file->getFileUri();
      $file_name = $video_file->filemime->value;
      $video_local_url = $this->fileUrlGenerator->generateAbsoluteString($video_file_uri);
    }

    if (!empty($settings->video_type)) {
      if ($settings->video_type === 'youtube') {
        if (!empty($settings->video_start)) {
          $video_settings[] = 'start=' . $settings->video_start;
        }

        if (!empty($settings->video_end)) {
          $video_settings[] = 'end=' . $settings->video_end;
        }

        if (!empty($settings->video_autoplay)) {
          $video_settings[] = 'autoplay=' . $settings->video_autoplay;
        }

        if (!empty($settings->video_mute)) {
          $video_settings[] = 'mute=' . $settings->video_mute;
        }

        if (!empty($settings->video_loop)) {
          $video_settings[] = 'loop=' . $settings->video_loop;
        }

        $video_settings[] = !empty($settings->video_controls) ? 'controls=' . $settings->video_controls : 'controls=0';

        $query_string = implode('&amp;', $video_settings);
      }

      if ($settings->video_type === 'local') {
        if (!empty($settings->video_start)) {
          $video_settings[] = 'start="' . $settings->video_start . '"';
        }

        if (!empty($settings->video_end)) {
          $video_settings[] = 'start="' . $settings->video_end . '"';
        }

        if (!empty($settings->video_autoplay)) {
          $video_settings[] = 'autoplay';
        }

        if (!empty($settings->video_mute)) {
          $video_settings[] = 'mute';
        }

        if (!empty($settings->video_loop)) {
          $video_settings[] = 'loop';
        }

        if (!empty($settings->video_controls)) {
          $video_settings[] = 'control';
        }

        $video_settings[] = 'controlslist="nodownload"';
        $query_string = implode(' ', $video_settings);
      }
    }

    $output = '';

    if (!empty($settings->video_type) && $settings->video_type === 'youtube') {
      $output .= '
                 <div class="noahs-video-wrapper">
                     <iframe class="noahs-video-iframe" frameborder="0" allowfullscreen="" allow="" width="640" height="360" src="' . $url . '?' . $query_string . '"></iframe>
                 </div>
             ';
    }
    elseif (!empty($settings->video_type) && $settings->video_type === 'local') {
      $output .= '
                 <div class="noahs-video-wrapper">
                     <video class="noahs-video-iframe" ' . $query_string . ' width="100%" poster="' . $image . '">
                         ' . (!empty($file_name) ? '<source src="' . $video_local_url . '" type="' . $file_name . '">' : '') . '
                         <p>Su navegador no soporta vídeos HTML5.</p>
                     </video>
                 </div>
             ';
    }
    else {
      $output .= '
                 <div class="noahs-video-wrapper">
                     <iframe width="100%" height="400" src="https://www.youtube.com/embed/FL0aKqxxvHc?si=80lWvCF3BT9EjYQA" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                 </div>
             ';
    }

    return $output;
  }

  /**
   * {@inheritdoc}
   */
  public function renderContent($element, $content = NULL) {
    return $this->wrapper($element, $this->template($element->settings));
  }

}
