<?php

namespace Drupal\photo_contest;

use Drupal\Core\Entity\EntityTypeManager;
use Drupal\Core\Entity\Query\QueryFactory;
use Drupal\Core\Session\AccountInterface;

class PhotoService {

  /**
   * Entitytype manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManager
   */
  protected $entityTypeManager;

  /**
   * A current user instance.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;

  /**
   * @var \Drupal\Core\Entity\Query\QueryFactory
   */
  protected $queryFactory;

  /**
   * ReviewsService constructor.
   *
   * @param \Drupal\Core\Entity\EntityTypeManager $entityTypeManager
   * @param \Drupal\Core\Session\AccountInterface $account
   */
  public function __construct(
    EntityTypeManager $entityTypeManager,
    AccountInterface $account,
    QueryFactory $query
  ) {
    $this->entityTypeManager = $entityTypeManager;
    $this->currentUser = $account;
    $this->queryFactory = $query;
  }

  public function checkUserPosts() {
    $posts = $this->queryFactory->get('node')
      ->condition('type', 'photo')
      ->condition('uid', $this->currentUser->id())
      ->execute();

    if (count($posts) >= 3) {
      return TRUE;
    }

    return FALSE;
  }

}
