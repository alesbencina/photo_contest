<?php

namespace Drupal\photo_contest\Plugin\Menu;

use Drupal\Core\Menu\MenuLinkDefault;
use Drupal\Core\Menu\StaticMenuLinkOverridesInterface;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Show or hide button for adding photos.
 *
 * @package Drupal\photo_contest\Plugin\Menu
 */
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
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin ID for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Menu\StaticMenuLinkOverridesInterface $static_override
   *   Defines an interface for objects which overrides menu links
   *   defined in YAML.
   * @param \Drupal\Core\Session\AccountInterface $current_user
   *   User account interface.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, StaticMenuLinkOverridesInterface $static_override, AccountInterface $current_user) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $static_override);

    $this->currentUser = $current_user;
  }

  /**
   * Creates an instance of the plugin.
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *   The container to pull out services used in the plugin.
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin ID for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   *
   * @return static
   *   Returns an instance of this plugin.
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
   * Gets cache tags.
   *
   * @return array|string[]
   *   Returns array of cache tags.
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
   *   Returns 0 or 1 (disable or enable).
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
