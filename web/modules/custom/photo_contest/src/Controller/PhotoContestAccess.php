<?php

namespace Drupal\photo_contest\Controller;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Routing\Access\AccessInterface;

/**
 * Blocks access if user have exceeded the number of posts.
 *
 * @package Drupal\photo_contest\Controller
 */
class PhotoContestAccess implements AccessInterface {

  /**
   * Checks access for a specific request.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   User account interface.
   *
   * @return \Drupal\Core\Access\AccessResult
   *   Returns not allowed if user exceeded number of posts.
   */
  public function access(AccountInterface $account) {
    $photoService = \Drupal::service('photo_contest.photo_service');
    if ($photoService->checkUserPosts()) {
      return AccessResult::allowedIf(FALSE);
    }
  }

}
