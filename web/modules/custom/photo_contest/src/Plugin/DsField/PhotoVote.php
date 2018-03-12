<?php

namespace Drupal\photo_contest\Plugin\DsField;

use Drupal\Core\Entity\Query\QueryFactory;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\ds\Plugin\DsField\DsFieldBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Plugin that show average vote number per entity.
 *
 * @DsField(
 *   id = "photo_vote_result",
 *   title = @Translation("Average vote"),
 *   entity_type = "node",
 *   provider = "photo_contest",
 *   ui_limit = {"photo|*"}
 * )
 */
class PhotoVote extends DsFieldBase implements ContainerFactoryPluginInterface {

  /**
   * @var \Drupal\Core\Entity\Query\QueryFactory
   */
  protected $entityQuery;

  /**
   * PhotoVote constructor.
   *
   * @param array $configuration
   * @param $plugin_id
   * @param $plugin_definition
   * @param \Drupal\Core\Entity\Query\QueryFactory $queryFactory
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, QueryFactory $queryFactory) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->entityQuery = $queryFactory;
  }

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
   * Function builds render array to display average vote for photo and vote count.
   *
   * @return array|mixed
   */
  public function build() {
    $entity = $this->entity();
    $results = \Drupal::service('plugin.manager.votingapi.resultfunction')
      ->getResults($entity->getEntityTypeId(), $entity->id());

    if (count($results) == 0) {
      $content['no_results'] = [
        "#type" => "markup",
        "#markup" => $this->t("No results"),
      ];
      return $content;
    }

    $content['vote_result'] = [
      '#id' => 'vote_results',
      '#theme' => 'photo_contest_entity_vote_statistic',
      '#average' => $results['vote']['vote_average'],
      '#num_of_votes' => $results['vote']['vote_count'],
      '#cache' => [
        'contexts' => ['url.path'],
        'tags' => ['node:' . $entity->id()],
      ],
    ];
    return $content;
  }

}
