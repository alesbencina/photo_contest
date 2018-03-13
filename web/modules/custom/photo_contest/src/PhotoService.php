<?php

namespace Drupal\photo_contest;

use Drupal\Core\Entity\EntityTypeManager;
use Drupal\Core\Entity\Query\QueryFactory;
use Drupal\Core\Session\AccountInterface;

/**
 * It provides service which define different functions for working with Photo.
 *
 * @package Drupal\photo_contest
 */
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
   * QueryFactory $queryFactory.
   *
   * @var \Drupal\Core\Entity\Query\QueryFactory
   */
  protected $queryFactory;

  /**
   * PhotoService constructor.
   *
   * @param \Drupal\Core\Entity\EntityTypeManager $entityTypeManager
   *   EntityTypeManager $entityTypeManager.
   * @param \Drupal\Core\Session\AccountInterface $account
   *   AccountInterface $account.
   * @param \Drupal\Core\Entity\Query\QueryFactory $query
   *   QueryFactory $query.
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

  /**
   * It checks if user exceeded number of photos.
   *
   * @return bool
   *   Returns true or false.
   */
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
