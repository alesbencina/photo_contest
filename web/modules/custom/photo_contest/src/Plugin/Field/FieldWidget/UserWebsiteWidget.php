<?php

namespace Drupal\photo_contest\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\link\Plugin\Field\FieldWidget\LinkWidget;

/**
 * Plugin implementation of the 'entity_user_website' widget.
 *
 * @FieldWidget(
 *   id = "entity_user_website_widget",
 *   label = @Translation("Entity User Website - Widget"),
 *   description = @Translation("Entity User Website - Widget"),
 *   field_types = {
 *     "entity_user_website",
 *   },
 * )
 */
class UserWebsiteWidget extends WidgetBase {

  /**
   * @inheritDoc
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $value = isset($items[$delta]->url) ? $items[$delta]->url : '';
    $element = [
      '#title' => 'Website link',
      '#type' => 'url',
      '#description' => 'Enter your website url (format http://website.com)',
      '#default_value' => $value,
    ];

    return ['url' => $element];
  }

}