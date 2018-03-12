<?php

namespace Drupal\photo_contest\Controller;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Routing\Access\AccessInterface;

class PhotoContestAccess implements AccessInterface {

  /**
   * Checks access for a specific request.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   Run access checks for this account.
   */
  public function access(AccountInterface $account) {
    $photoService = \Drupal::service('photo_contest.photo_service');
    if ($photoService->checkUserPosts()) {
      return AccessResult::allowedIf(FALSE);
    }
  }
}