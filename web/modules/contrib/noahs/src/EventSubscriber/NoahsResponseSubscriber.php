<?php

namespace Drupal\noahs_page_builder\EventSubscriber;

use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\Core\Routing\CurrentRouteMatch;
use Drupal\Core\File\FileUrlGeneratorInterface;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\Core\Path\CurrentPathStack;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Injects Noah's dynamic CSS only for nodes at the end of the <head>.
 */
class NoahsResponseSubscriber implements EventSubscriberInterface {

  protected $routeMatch;
  protected $fileUrlGenerator;
  protected $logger;
  protected $currentPath;
  protected $requestStack;

  public function __construct(
    CurrentRouteMatch $route_match,
    FileUrlGeneratorInterface $file_url_generator,
    LoggerChannelFactoryInterface $logger_factory,
    CurrentPathStack $current_path,
    RequestStack $request_stack
  ) {
    $this->routeMatch = $route_match;
    $this->fileUrlGenerator = $file_url_generator;
    $this->logger = $logger_factory->get('default');
    $this->currentPath = $current_path;
    $this->requestStack = $request_stack;
  }

  public static function getSubscribedEvents() {
    return [
      KernelEvents::RESPONSE => ['onRespond', -100],
    ];
  }

  public function onRespond(ResponseEvent $event) {
    $request = $event->getRequest();

    // Only process main HTML requests.
    if (! $event->isMainRequest()) {
      return;
    }

    $response = $event->getResponse();
    $content_type = $response->headers->get('Content-Type') ?? '';
    if (strpos($content_type, 'html') === FALSE) {
      return;
    }

    if ($request->isXmlHttpRequest() || !$request->isMethod('GET')) {
      return;
    }

    $route_name = $this->routeMatch->getRouteName();
    $excluded = [
      'noahs_page_builder.editor',
      'noahs_page_builder_pro.build',
      'noahs_page_builder.noahs_settings_styles',
    ];
    if (in_array($route_name, $excluded, TRUE)) {
      return;
    }

    $css_urls = [];

    try {
      // Only node-specific CSS.
      if ($route_name === 'entity.node.canonical' || $route_name === 'noahs_page_builder.product_preview') {
        $node = $this->routeMatch->getParameter('node');
        if ($node && method_exists($node, 'id')) {
          $css = \noahs_page_builder_add_node_css($node->getEntityTypeId(), $node->id());
          if (!empty($css)) {
            $css_urls[] = $css;
          }
        }
      }
    }
    catch (\Throwable $e) {
      $this->logger->error('NoahsResponseSubscriber error: @msg', ['@msg' => $e->getMessage()]);
    }

    if (empty($css_urls)) {
      return;
    }

    // Build insertion HTML.
    $insert_html = '';
    foreach ($css_urls as $css_url) {
      $insert_html .= '<link rel="stylesheet" href="' . htmlspecialchars($css_url, ENT_QUOTES, 'UTF-8') . '" />' . PHP_EOL;
    }

    // Inject just before </head>.
    $content = $response->getContent();
    if (strpos($content, '</head>') !== FALSE) {
      $content = str_replace('</head>', $insert_html . '</head>', $content);
      $response->setContent($content);
    }
    elseif (strpos($content, '<body') !== FALSE) {
      $content = preg_replace('/(<body[^>]*>)/i', '$1' . $insert_html, $content, 1);
      $response->setContent($content);
    }

    $response->headers->set('X-Noahs-Injected', implode(',', array_map(function($u){ return basename($u); }, $css_urls)));
  }
}
