<?php

namespace Drupal\photo_contest\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

class RouteSubscriber extends RouteSubscriberBase {

  /**
   * @param \Symfony\Component\Routing\RouteCollection $collection
   */
  protected function alterRoutes(RouteCollection $collection) {
    if ($route = $collection->get('node.add')) {
      $route->setRequirement('_custom_access', 'Drupal\photo_contest\Access\CustomAccessCheck::access');
    }
  }

}
