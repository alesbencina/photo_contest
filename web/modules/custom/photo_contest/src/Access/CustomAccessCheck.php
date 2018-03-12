<?php

namespace Drupal\photo_contest\Access;

use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

class CustomAccessCheck {

  public $routeMatch;

  public function access(AccountInterface $account) {
    // Check permissions and combine that with any custom access checking needed. Pass forward
    // parameters from the route and/or request as needed.
    $photoService = \Drupal::service('photo_contest.photo_service');
    $currentRoute = \Drupal::service('current_route_match');
    $params = $currentRoute->getRawParameters();
    $type = $params->get('node_type');
    if ($type == 'photo') {
      if ($photoService->checkUserPosts()) {
        return AccessResult::forbidden('You have exceeded the number of photo uploads.');
      }
        return AccessResult::allowed();
    }
    return AccessResult::allowed();
  }
}