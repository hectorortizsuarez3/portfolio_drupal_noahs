<?php

namespace Drupal\miswidgets\Traits;

//Este trait se puede exportar cuando el campo representa texto plano (extraemos text, lo convertimos a string y no permitimos html)
trait TextNormalizationTrait {
    /**
   * Normaliza cualquier valor (string/array/stdClass) a string de texto.
   */
  private function normalizeText($raw): string {
    if ($raw === NULL) {
      return '';
    }

    // Array tipo ['text' => '...']
    if (is_array($raw)) {
      $raw = $raw['text'] ?? '';
    }

    // Objeto tipo stdClass con ->text
    if (is_object($raw)) {
      if (isset($raw->text)) {
        $raw = $raw->text;
      }
      else {
        // Si no sabemos qué es, lo dejamos vacío para evitar 500.
        $raw = '';
      }
    }

    // Si sigue sin ser escalar, fuera.
    if (!is_scalar($raw)) {
      return '';
    }

    $val = (string) $raw;
    $val = trim(strip_tags($val));
    return $val;
  }
}