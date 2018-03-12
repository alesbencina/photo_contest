<?php

namespace Drupal\photo_contest\Plugin\votingapi_widget;

use Drupal\votingapi_widgets\Plugin\VotingApiWidgetBase;

/**
 * Fivestar with 10 stars widget.
 *
 * @VotingApiWidget(
 *   id = "fivestar_ten",
 *   label = @Translation("Fivestar rating 10 stars"),
 *   values = {
 *    10 = @Translation("1"),
 *    20 = @Translation("2"),
 *    30 = @Translation("3"),
 *    40 = @Translation("4"),
 *    50 = @Translation("5"),
 *    60 = @Translation("6"),
 *    70 = @Translation("7"),
 *    80 = @Translation("8"),
 *    90 = @Translation("9"),
 *    100 = @Translation("10"),
 *   },
 * )
 */
class MyFivestarWidget extends VotingApiWidgetBase {

  /**
   * @param $entity_type
   * @param $entity_bundle
   * @param $entity_id
   * @param $vote_type
   * @param $field_name
   * @param $style
   * @param $show_results
   * @param bool $read_only
   * @param bool $show_own_vote
   *
   * @return array
   */
  public function buildForm($entity_type, $entity_bundle, $entity_id, $vote_type, $field_name, $style, $show_results, $read_only = FALSE, $show_own_vote = FALSE) {
    $form = $this->getForm($entity_type, $entity_bundle, $entity_id, $vote_type, $field_name, $style, $show_results, $read_only, $show_own_vote);

    $build = [
      'rating' => [
        '#theme' => 'container',
        '#attributes' => [
          'class' => [
            'votingapi-widgets',
            'fivestar',
            ($read_only) ? 'read_only' : '',
          ],
        ],
        '#children' => [
          'form' => $form,
        ],
      ],
      '#attached' => [
        'library' => ['votingapi_widgets/fivestar'],
      ],
    ];
    return $build;
  }

  /**
   * @return array
   */
  public function getStyles() {
    return [
      'default' => t('Default'),
      'bars-horizontal' => t('Bars horizontal'),
      'css-stars' => t('Css stars'),
      'bars-movie' => t('Bars movie'),
      'bars-pill' => t('Bars pill'),
      'bars-square' => t('Bars square'),
      'fontawesome-stars-o' => t('Fontawesome stars-o'),
      'fontawesome-stars' => t('Fontawesome stars'),
      'bootstrap-stars' => t('Bootstrap stars'),
    ];
  }

  /**
   * @param array $form
   */
  public function getInitialVotingElement(array &$form) {
    $form['value']['#prefix'] = '<div class="votingapi-widgets fivestar">';
    $form['value']['#attached'] = [
      'library' => ['votingapi_widgets/fivestar'],
    ];
    $form['value']['#suffix'] = '</div>';
    $form['value']['#attributes'] = [
      'data-style' => 'default',
      'data-is-edit' => 1,
    ];
  }
}
