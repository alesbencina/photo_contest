<?php
namespace Drupal\photo_contest\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;
use Drupal\Core\Form\FormStateInterface;

/**
 * @FieldType(
 *   id = "entity_user_website",
 *   label = @Translation("Entity User Website"),
 *   description = @Translation("This field stores a user website."),
 *   default_formatter = "entity_user_website_formatter",
 *   default_widget = "entity_user_website_widget",
 * )
 */
class UserWebsite extends FieldItemBase implements FieldItemInterface {
  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties = [];
    $properties['url'] = DataDefinition::create('string')
      ->setLabel(t('URL'));

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    return [
      'columns' => [
        'url' => [
          'type' => 'text',
          'size' => 'small',
        ],
      ],
    ];
  }

  /**
   * @inheritDoc
   */
  public function fieldSettingsForm(array $form, FormStateInterface $form_state) {
    $element = [];
    $element['size'] = [
      '#title' => $this->t('Website link'),
      '#type' => 'text',
    ];

    return $element;
  }


}