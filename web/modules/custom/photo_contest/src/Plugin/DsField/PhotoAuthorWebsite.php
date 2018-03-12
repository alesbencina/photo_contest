<?php

namespace Drupal\photo_contest\Plugin\DsField;

use Drupal\Core\Entity\Query\QueryFactory;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\ds\Plugin\DsField\DsFieldBase;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\user\Entity\User;


/**
 * Plugin that renders link for adding recommendation.
 *
 * @DsField(
 *   id = "photo_author_website",
 *   title = @Translation("Photo author website"),
 *   entity_type = "node",
 *   provider = "photo_contest",
 *   ui_limit = {"photo|*"}
 * )
 */
class PhotoAuthorWebsite extends DsFieldBase implements ContainerFactoryPluginInterface {

  /**
   * @var \Drupal\Core\Entity\Query\QueryFactory
   */
  protected $entityQuery;

  /**
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   *
   * @return static
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity.query')
    );
  }

  /**
   * CompanyReviews constructor.
   *
   * @param array $configuration
   * @param $plugin_id
   * @param $plugin_definition
   * @param \Drupal\Core\Session\AccountInterface $account
   * @param \Drupal\Core\Entity\Query\QueryFactory $queryFactory
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, QueryFactory $queryFactory) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->entityQuery = $queryFactory;
  }

  /**
   * {@inheritdoc}
   *
   * The method which return render array for add recommentaion link.
   * If logged in user already gave review function build markup that user
   * already gave a review.
   *
   */
  public function build() {
    $fieldConfig = $this->getConfiguration();
    $user_id = $fieldConfig['entity']->get('uid')->target_id;
    $author = User::load($user_id);

    $build['label'] = [
      '#type' => 'markup',
      '#markup' => $this->t('Author: '),
    ];
    $build['examples_link'] = [
      '#title' => $author->get('name')->value,
      '#type' => 'link',
      '#url' => Url::fromUri($author->get('field_website')->url),
      '#attributes' => [
        'target' => [
          '_blank',
        ],
      ],
    ];

    return $build;
  }

}
