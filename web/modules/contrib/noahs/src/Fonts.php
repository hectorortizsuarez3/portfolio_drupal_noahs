<?php

namespace Drupal\noahs_page_builder;

/**
 * {@inheritdoc}
 */
class Fonts {

  /**
   * Get fonts.
   *
   * @return array
   *   The fonts.
   */
  public static function getFonts(): array {
    $font_options = [
      '' => 'Default',
      'Droid Sans' => 'Droid Sans',
      'Exo 2' => 'Exo 2',
      'Inter' => 'Inter',
      'Jost' => 'Jost',
      'Lato' => 'Lato',
      'Lora' => 'Lora',
      'Merriweather' => 'Merriweather',
      'Montserrat' => 'Montserrat',
      'Noto Sans' => 'Noto Sans',
      'Nunito' => 'Nunito',
      'Open Sans' => 'Open Sans',
      'Oswald' => 'Oswald',
      'Outfit' => 'Outfit',
      'Playfair Display' => 'Playfair Display',
      'Poppins' => 'Poppins',
      'PT Sans' => 'PT Sans',
      'Raleway' => 'Raleway',
      'Roboto' => 'Roboto',
      'Roboto Condensed' => 'Roboto Condensed',
      'Roboto Mono' => 'Roboto Mono',
      'Roboto Slab' => 'Roboto Slab',
      'Rubik' => 'Rubik',
      'Sora' => 'Sora',
      'Titillium Web' => 'Titillium Web',
      'Tomorrow' => 'Tomorrow',
      'Ubuntu' => 'Ubuntu',
      'Ubuntu Condensed' => 'Ubuntu Condensed',
      'Work Sans' => 'Work Sans',
    ];

    // Merge custom fonts defined via settings.
    try {
      $custom_fonts = \Drupal::config('noahs_page_builder.settings')->get('custom_fonts') ?? [];
      if (is_array($custom_fonts)) {
        foreach ($custom_fonts as $cf) {
          if (!empty($cf['name'])) {
            $font_options[$cf['name']] = $cf['name'];
          }
        }
      }
    }
    catch (\Throwable $e) {
      // Config may not be available in some early contexts; ignore.
    }

    // Ensure uniqueness of options preserving labels.
    return array_unique($font_options);
  }

  /**
   * Get fonts availables.
   *
   * @return array
   *   The fonts availables.
   */
public static function getFontsAvailables(): array {

  $raw = \Drupal::config('noahs_page_builder.settings')->get('available_fonts') ?? [];

  if (!is_array($raw)) {
    $raw = [];
  }

  // Filtrar solo claves no vacías y valores string no vacíos.
  $selected = array_filter($raw, static function ($v, $k) {
    return $k !== '' && !empty($v) && is_string($v);
  }, ARRAY_FILTER_USE_BOTH);

  $keys = array_keys($selected);
  $available = !empty($keys) ? array_combine($keys, $keys) : [];

  // Añadir fuentes personalizadas.
  try {
    $custom_fonts = \Drupal::config('noahs_page_builder.settings')->get('custom_fonts') ?? [];
    if (is_array($custom_fonts)) {
      foreach ($custom_fonts as $cf) {
        if (!empty($cf['name'])) {
          $available[$cf['name']] = $cf['name'];
        }
      }
    }
  }
  catch (\Throwable $e) {}
  return $available;
}

  /**
   * Get fonts weights.
   *
   * @return array
   *   The fonts weights.
   */
  public static function getFontsWeights(): array {
    $noahs_page_builder_fonts = [
      ""    => "Default",
      "100" => "100",
      "200" => "200",
      "300" => "300",
      "400" => "400",
      "500" => "500",
      "600" => "600",
      "700" => "700",
      "800" => "800",
      "900" => "900",
      "normal" => "Normal",
      "bold" => "Bold",
    ];
    return $noahs_page_builder_fonts;
  }

}
