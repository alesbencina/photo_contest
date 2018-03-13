<?php

namespace Drupal\photo_contest\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

/**
 * Provides a base implementation for RouteSubscriber.
 *
 * @package Drupal\photo_contest\Routing
 */
class RouteSubscriber extends RouteSubscriberBase {

  /**
   * Alters existing routes for a specific collection.
   *
   * @param \Symfony\Component\Routing\RouteCollection $collection
   *   The route collection for adding routes.
   */
  protected function alterRoutes(RouteCollection $collection) {
    if ($route = $collection->get('node.add')) {
      $route->setRequirement('_custom_access', 'Drupal\photo_contest\Access\CustomAccessCheck::access');
    }
  }

}
