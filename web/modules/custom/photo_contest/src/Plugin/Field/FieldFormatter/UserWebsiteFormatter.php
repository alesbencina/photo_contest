<?php

namespace Drupal\photo_contest\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Url;

/**
 * Plugin implementation of the 'entity_user_website' formatter.
 *
 * @FieldFormatter(
 *   id = "entity_user_website_formatter",
 *   label = @Translation("Entity User Website - Formatter"),
 *   description = @Translation("Entity User Website - Formatter"),
 *   field_types = {
 *     "entity_user_website",
 *   }
 * )
 */
class UserWebsiteFormatter extends FormatterBase {

  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];
    foreach ($items as $delta => $item) {
      $elements[$delta] = [
        '#type' => 'html_tag',
        '#tag' => 'a',
        '#attributes' => [
          'href' => $item->url,
          'target' => '_blank',
        ],
        '#value' => $item->url,
      ];
    }
    return $elements;
  }

}