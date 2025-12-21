<?php

namespace Drupal\noahs_page_builder\Theme;

use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Theme\ThemeNegotiatorInterface;

class CustomThemeNegotiator implements ThemeNegotiatorInterface {

  /**
   * {@inheritdoc}
   */
  public function applies(RouteMatchInterface $route_match) {
    $allowed_routes = [
      'noahs_page_builder.noahs_settings_styles',
      'noahs_page_builder.noahs_settings_iframe'
    ];

    return in_array($route_match->getRouteName(), $allowed_routes, TRUE);
  }

  /**
   * {@inheritdoc}
   */
  public function determineActiveTheme(RouteMatchInterface $route_match) {
    // Usa el tema por defecto del sitio (frontend).
    return \Drupal::config('system.theme')->get('default');
  }
}
