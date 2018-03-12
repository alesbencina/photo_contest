<?php

namespace Drupal\photo_contest\Access;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Session\AccountInterface;

class CustomAccessCheck {
  /**
   * Blocks access to route if user already posted 3 photos.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *
   * @return \Drupal\Core\Access\AccessResultAllowed|\Drupal\Core\Access\AccessResultForbidden
   */
  public function access(AccountInterface $account) {
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
