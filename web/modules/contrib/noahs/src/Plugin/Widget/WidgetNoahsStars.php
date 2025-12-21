<?php

namespace Drupal\noahs_page_builder\Plugin\Widget;

/**
 * @WidgetPlugin(
 *   id = "noahs_stars",
 *   label = @Translation("Stars")
 * )
 */
class WidgetNoahsStars extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function data() {
    return [
      'icon' => '<svg id="fi_12971356" enable-background="new 0 0 64 64" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg"><path d="m57 11h-50c-2.7568359 0-5 2.2431641-5 5v32c0 2.7568359 2.2431641 5 5 5h50c2.7568359 0 5-2.2431641 5-5v-32c0-2.7568359-2.2431641-5-5-5zm-50 2h50c1.6542969 0 3 1.3457031 3 3v3h-56v-3c0-1.6542969 1.3457031-3 3-3zm50 38h-50c-1.6542969 0-3-1.3457031-3-3v-27h56v27c0 1.6542969-1.3457031 3-3 3zm-51-35c0-.5527344.4472656-1 1-1h6c.5527344 0 1 .4472656 1 1s-.4472656 1-1 1h-6c-.5527344 0-1-.4472656-1-1zm10 0c0-.5527344.4472656-1 1-1h6c.5527344 0 1 .4472656 1 1s-.4472656 1-1 1h-6c-.5527344 0-1-.4472656-1-1zm28 0c0-.5527344.4472656-1 1-1h10c.5527344 0 1 .4472656 1 1s-.4472656 1-1 1h-10c-.5527344 0-1-.4472656-1-1zm-4.0273437 16.2529297-4.8896484-.7109375-2.1865234-4.4306641c-.3359375-.6835938-1.4570313-.6835938-1.7929688 0l-2.1865234 4.4306641-4.8896484.7109375c-.3769531.0546875-.6894531.3183594-.8076172.6806641-.1171875.3613281-.0195313.7587891.2529297 1.0244141l3.5390625 3.4492188-.8359375 4.8701172c-.0644531.375.0898438.7539063.3974609.9775391.3085938.2246094.7167969.2539063 1.0537109.0761719l4.3730468-2.2988283 4.3730469 2.2988281c.1464844.0771484.3066406.1152344.4658203.1152344.2070313 0 .4140625-.0644531.5878906-.1914063.3076172-.2236328.4619141-.6025391.3974609-.9775391l-.8359375-4.8701172 3.5390625-3.4492188c.2724609-.265625.3701172-.6630859.2529297-1.0244141-.118164-.3623045-.430664-.6259764-.8076171-.6806639zm-4.756836 4.0888672c-.2353516.2294922-.3427734.5605469-.2871094.8847656l.5820313 3.3916016-3.0449219-1.6005859c-.1464844-.0771485-.305664-.1152344-.4658203-.1152344s-.3193359.0380859-.4658203.1152344l-3.0449219 1.6005859.5820313-3.3916016c.0556641-.3242188-.0517578-.6552734-.2871094-.8847656l-2.4638672-2.4013672 3.4042969-.4951172c.3261719-.046875.6074219-.2519531.7529297-.546875l1.5224609-3.0849609 1.5224609 3.0849609c.1455078.2949219.4267578.5.7529297.546875l3.4042969.4951172zm-13.5615234-1.7802735-3.9785156-.578125-1.7792969-3.6054688c-.3359375-.6835938-1.4570313-.6835938-1.7929688 0l-1.7792969 3.6054688-3.9785156.578125c-.3769531.0546875-.6894531.3183594-.8076172.6796875-.1171875.3623047-.0195313.7597656.2529297 1.0253906l2.8789063 2.8066406-.6796875 3.9628906c-.0644531.375.0898438.7539063.3974609.9775391.3085938.2246094.71875.2548828 1.0527344.0761719l3.5595703-1.8701171 3.5595703 1.8701172c.1455078.0771484.3056641.1152344.4648438.1152344.2070313 0 .4140625-.0644531.5878906-.1914063.3076172-.2236328.4619141-.6025391.3974609-.9775391l-.6796875-3.9628906 2.8789063-2.8066406c.2724609-.265625.3701172-.6630859.2529297-1.0253906-.1181641-.3613282-.4306641-.6250001-.8076172-.6796876zm-4.0966797 3.4472657c-.2353516.2294922-.3427734.5605469-.2871094.8847656l.4257813 2.4833984-2.2314453-1.171875c-.1455079-.0771484-.3046875-.1152343-.4648438-.1152343s-.3193359.0380859-.4648438.1152344l-2.2314453 1.171875.4257813-2.4833984c.0556641-.3242188-.0517578-.6552734-.2871094-.8847656l-1.8046875-1.7597656 2.4941406-.3623047c.3261719-.046875.6074219-.2519531.7529297-.546875l1.1152344-2.2597658 1.1152344 2.2597656c.1455078.2949219.4267578.5.7529297.546875l2.4941406.3623047zm38.4306641-3.4472657-3.9785156-.578125-1.7802734-3.6054688c-.3359375-.6835938-1.4570313-.6835938-1.7929688 0l-1.7792969 3.6054688-3.9785156.578125c-.3769531.0546875-.6894531.3183594-.8076172.6806641-.1171875.3613281-.0195313.7587891.2529297 1.0244141l2.8798828 2.8066406-.6796875 3.9628906c-.0644531.375.0898438.7539063.3974609.9775391.3095703.2246094.7177734.2548828 1.0537109.0761719l3.5576172-1.8701172 3.5595703 1.8701172c.1455078.0771484.3056641.1152344.4648438.1152344.2070313 0 .4140625-.0644531.5878906-.1914063.3076172-.2236328.4619141-.6025391.3974609-.9775391l-.6796875-3.9628906 2.8798828-2.8066406c.2724609-.265625.3701172-.6630859.2529297-1.0244141-.118164-.3623047-.430664-.6259766-.8076171-.6806641zm-4.0976563 3.4472657c-.2353516.2294922-.3427734.5605469-.2871094.8847656l.4257813 2.4833984-2.2314453-1.171875c-.1455078-.0771484-.3046875-.1152344-.4648438-.1152344s-.3193359.0380859-.4658203.1152344l-2.2294922 1.171875.4257813-2.4833984c.0556641-.3242188-.0517578-.6552734-.2871094-.8847656l-1.8046875-1.7597656 2.4931641-.3623047c.3261719-.046875.6074219-.2519531.7529297-.546875l1.1152344-2.2597656 1.1162109 2.2597656c.1455078.2949219.4267578.5.7529297.546875l2.4931641.3623047z"></path></svg>',
      'title' => 'Stars',
      'description' => 'Star rating widget.',
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
    $form['section_content'] = [
      'type' => 'tab',
      'title' => t('Content'),
    ];

    $form['stars'] = [
      'type'    => 'number',
      'title'   => t('Valoration 0 to 5'),
      'tab' => 'section_content',
      'style_type'      => 'attribute',
      'style_selector'  => '.stars-outer',
      'attribute_type'  => 'data-percentage',
      'attributes' => [
        'min' => '0',
        'max' => '5',
        'step' => '0.1',
        'class' => 'noahs_update_stars',
      ],
    ];

    $form['size'] = [
      'type'    => 'text',
      'title'   => t('Size'),
      'tab' => 'section_content',
      'style_type' => 'style',
      'style_selector' => '.stars-outer',
      'style_css' => 'font-size',
      'responsive' => TRUE,
      'description' => 'use as 10%, 100px, 100vw...',
    ];

    $form['column_gap'] = [
      'type'    => 'text',
      'title'   => t('Space'),
      'tab' => 'section_content',
      'style_type' => 'style',
      'style_selector' => '.stars-icon, .stars-inner',
      'style_css' => 'column-gap',
      'responsive' => TRUE,
      'description' => 'use as 10%, 100px, 100vw...',
    ];
    $form['horizontal_align'] = [
      'type'    => 'select',
      'title'   => t('Horizontal Align'),
      'tab' => 'section_content',
      'style_type' => 'style',
      'style_selector' => '.widget-wrapper',
      'style_css' => 'justify-content',
      'responsive' => TRUE,
      'options' => [
        '' => 'Por defecto',
        'flex-start' => 'Start',
        'center' => 'Center',
        'flex-end' => 'End',
      ],
    ];
    $form['color'] = [
      'type'    => 'noahs_color',
      'title'   => t('First Color'),
      'tab' => 'section_content',
      'style_type' => 'style',
      'style_selector' => '.stars-icon',
      'style_css' => 'color',
      'responsive' => TRUE,
      'description' => 'use as 10%, 100px, 100vw...',
    ];
    $form['second_color'] = [
      'type'    => 'noahs_color',
      'title'   => t('Second Color'),
      'tab' => 'section_content',
      'style_type' => 'style',
      'style_selector' => '.stars-inner',
      'style_css' => 'color',
      'responsive' => TRUE,
      'description' => 'use as 10%, 100px, 100vw...',
    ];
    $form['icon'] = [
      'type'    => 'noahs_icon',
      'title'   => t('Icon'),
      'tab' => 'section_content',
      'update_selector' => '.stars-outer i',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function template($settings) {
    $settings = $settings->element;
    $numero = !empty($settings->attribute->stars) ? $settings->attribute->stars : 0;
    $total = 5;
    $porcentaje = ($numero / $total) * 100;

    $output = '';

    $output .= '
             <div class="stars-outer" data-percentage="' . $numero . '">
                 <div class="stars-icon">
                     <i class="' . (!empty($settings->icon->class) ? $settings->icon->class : 'fa-solid fa-star') . '"></i>
                     <i class="' . (!empty($settings->icon->class) ? $settings->icon->class : 'fa-solid fa-star') . '"></i>
                     <i class="' . (!empty($settings->icon->class) ? $settings->icon->class : 'fa-solid fa-star') . '"></i>
                     <i class="' . (!empty($settings->icon->class) ? $settings->icon->class : 'fa-solid fa-star') . '"></i>
                     <i class="' . (!empty($settings->icon->class) ? $settings->icon->class : 'fa-solid fa-star') . '"></i>
                 </div>
                 <div class="stars-inner" style="width: ' . $porcentaje . '%">
                     <i class="' . (!empty($settings->icon->class) ? $settings->icon->class : 'fa-solid fa-star') . '" aria-hidden="true"></i>
                     <i class="' . (!empty($settings->icon->class) ? $settings->icon->class : 'fa-solid fa-star') . '" aria-hidden="true"></i>
                     <i class="' . (!empty($settings->icon->class) ? $settings->icon->class : 'fa-solid fa-star') . '" aria-hidden="true"></i>
                     <i class="' . (!empty($settings->icon->class) ? $settings->icon->class : 'fa-solid fa-star') . '" aria-hidden="true"></i>
                     <i class="' . (!empty($settings->icon->class) ? $settings->icon->class : 'fa-solid fa-star') . '" aria-hidden="true"></i>
                 </div>
             </div>
             <span class="number-rating"></span>
         ';

    return $output;
  }

  /**
   * {@inheritdoc}
   */
  public function renderContent($element, $content = NULL) {
    return $this->wrapper($element, $this->template($element->settings));
  }

}
