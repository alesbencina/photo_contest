<?php

namespace Drupal\photo_contest\Plugin\Menu;

use Drupal\Core\Menu\MenuLinkDefault;
use Drupal\Core\Menu\StaticMenuLinkOverridesInterface;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AccountMenu extends MenuLinkDefault {

  /**
   * The current user.
   *
   * @var \Drupal\Core\Session\AccountInterface
   */
  protected $currentUser;


  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, StaticMenuLinkOverridesInterface $static_override, AccountInterface $current_user) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $static_override);

    $this->currentUser = $current_user;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('menu_link.static.overrides'),
      $container->get('current_user')
    );
  }

  public function getCacheTags() {
    return [
      'account_add_photo_link',
    ];
  }

  public function isEnabled() {
    if ($this->checkUserPosts()) {
      return 0;
    }
    else {
      return 1;
    }
  }

  private function checkUserPosts() {
    $posts = \Drupal::entityQuery('node')
      ->condition('type','photo')
      ->condition('uid', $this->currentUser->id())
      ->execute();

    if (count($posts) >= 3) {
      return TRUE;
    }


    return FALSE;
  }

}