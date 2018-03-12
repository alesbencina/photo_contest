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
   * AccountMenu constructor.
   *
   * @param array $configuration
   * @param $plugin_id
   * @param $plugin_definition
   * @param \Drupal\Core\Menu\StaticMenuLinkOverridesInterface $static_override
   * @param \Drupal\Core\Session\AccountInterface $current_user
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, StaticMenuLinkOverridesInterface $static_override, AccountInterface $current_user) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $static_override);

    $this->currentUser = $current_user;
  }

  /**
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   * @param array $configuration
   * @param $plugin_id
   * @param $plugin_definition
   *
   * @return static
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

  /**
   * @return array|string[]
   */
  public function getCacheTags() {
    return [
      'account_add_photo_link',
    ];
  }

  /**
   * Show or hide menu link if user posted more than three photos.
   *
   * @return bool|int
   */
  public function isEnabled() {
    $photoService = \Drupal::service('photo_contest.photo_service');

    if ($photoService->checkUserPosts()) {
      return 0;
    }
    else {
      return 1;
    }
  }

}
