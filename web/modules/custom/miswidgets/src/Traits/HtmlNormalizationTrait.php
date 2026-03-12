<?php

namespace Drupal\miswidgets\Traits;

//Este trait se puede exportar cuando el campo representa contenido enriquecido
//(extraemos text, lo convertimos a string y permitimos html)
trait HtmlNormalizationTrait {
  protected function normalizeHtml($raw): string {

  //Si es nulo
    if ($raw === NULL) {
      return '';
    }

  //Si es un array...
    if (is_array($raw)) {
      if (isset($raw['text'])) {
        $raw = $raw['text'];
      }
      else {
        $raw = '';
      }
    }  

    //Si es un objeto...
    if (is_object($raw)) {
      if (isset($raw->text)) {
        $raw = $raw->text;
      }
      else {
        $raw = '';
      }
    }

    //Si $raw no es tipo int, double, string o bool, descartar...
    if (!is_scalar($raw)) {
      return '';
    }

    return trim((string) $raw);
  }
}