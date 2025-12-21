<?php

namespace Drupal\noahs_page_builder\Plugin\Control;

use Drupal\Core\Plugin\ContainerFactoryPluginInterface;

/**
 * Provides a URL control plugin for Noah's Page Builder.
 *
 * @ControlPlugin(
 *   id = "noahs_url",
 *   label = @Translation("Url")
 * )
 */
class ControlNoahsUrl extends ControlBase implements ContainerFactoryPluginInterface {

  /**
   * {@inheritdoc}
   */
  public function getype() {
    return 'noahs_url';
  }

  /**
   * {@inheritdoc}
   */
  public function contentTemplate(array $params = []) {
    $data = $params['data'] ?? NULL;
    $name = $params['name'] ?? NULL;
    $value = $params['value'] ?? NULL;

    $placeholder = !empty($data['item']['placeholder']) ? $data['item']['placeholder'] : $data['item']['title'];
    $selector = !empty($data['item']['update_selector']) ? 'data-update-selector="#widget-id-' . $data['wid'] . ' ' . $data['item']['update_selector'] . '"' : NULL;
    $attributes = '';
    $class = [];
    $class[] = 'form-control';

    $output = '<div class="field_item">';

    if (!empty($data['item']['autocomplete'])) {
      $class[] = 'select2-control';
      $class[] = $data['item']['autocomplete'];
    }

    if (!empty($data['item']['attributes'])) {
      $attributes = implode(' ', array_map(
      function ($key, $value) {
        return sprintf('%s="%s"', $key, htmlspecialchars($value));
      },
                array_keys($data['item']['attributes']),
                $data['item']['attributes']
      ));

    }

    $class = implode(" ", $class);

    $url = '';
    $text = !empty($value['text']) ? $value['text'] : '';
    if (!empty($value['node_id'])) {
      $url = $this->pathAliasManager->getAliasByPath('/node/' . $value['node_id']);
    }
    elseif (filter_var($value, FILTER_VALIDATE_URL)) {
      $url = $value['text'];
    }
    elseif (strpos($value['text'], '#') === 0) {
      $url = $value['text'];
    }
    $entity_id = !empty($value['node_id']) ? $value['node_id'] : '';
    $output .= '<label for="' . $data['item_id'] . '">' . $placeholder . '</label>';
    $output .= '<input type="hidden" name="' . $name . '[node_id]" value="' . $entity_id . '" class="node_id" field-settings/>';
    $output .= '<input type="hidden" name="' . $name . '[url]" value="' . $url . '" field-settings/>';
    $output .= '<input type="hidden" name="' . $name . '[entity_id]" value="' . $url . '" field-settings/>';
    $output .= '<input type="text" name="' . $name . '[text]" ' . $attributes . ' id="' . $data['item_id'] . '" title="' . $data['item']['title'] . '" class="' . $class . '" placeholder="' . $placeholder . '" value="' . $text . '" ' . $selector . ' field-settings/>';
    $output .= '<input type="text" name="' . $name . '[url_params]" id="' . $data['item_id'] . '" title="' . t('Url params') . '" placeholder="?param=test" class="form-control mt-1" value="' . $value['url_params'] . '" field-settings/>';

    $output .= '</div>';

    return $output;
  }

  /**
   * {@inheritdoc}
   */
  public function renderControl($data) {
    return $this->base($data, $this->contentTemplate($data));
  }

  /**
   * {@inheritdoc}
   */
  public function getDefaultSettings() {
    return [
      'input_type' => 'noahs_url',
      'placeholder' => '',
      'title' => '',
    ];
  }

}
