<?php

namespace Drupal\photo_contest\Routing;

use Drupal\Core\Access\AccessResultForbidden;
use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

class RouteSubscriber extends RouteSubscriberBase {

  protected function alterRoutes(RouteCollection $collection) {
    if ($route = $collection->get('node.add')) {
      $route->setRequirement('_custom_access', 'Drupal\photo_contest\Access\CustomAccessCheck::access');
    }
  }

}