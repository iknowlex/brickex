<?php

namespace Drupal\brickex\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\bricks_inline\Plugin\Field\FieldWidget\BricksTreeInlineWidget;
use Drupal\Core\Form\FormStateInterface;

/**
 * @FieldWidget(
 *   id = "brickex_tree_inline",
 *   label = @Translation("Brickex tree (Inline entity form)"),
 *   description = @Translation("A tree of inline entity forms."),
 *   field_types = {
 *     "bricks",
 *     "bricks_revisioned"
 *   },
 *   multiple_values = true
 * )
 */
class BrickexTreeInlineWidget extends BricksTreeInlineWidget {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element = parent::formElement($items, $delta, $element, $form, $form_state);

    // Hack - widget id not updated - ? issue with drag handler.
    $element['entities']['#widget'] = 'bricks_tree_inline';

    $entities = $form_state->get(['inline_entity_form', $this->getIefId(), 'entities']);
    foreach ($entities as $delta => $value) {
      _bricks_form_element_alter($element['entities'][$delta], $items[$delta], $value['entity']);

      $element['entities'][$delta]['options']['css_class']['#size'] = 20;
      $element['entities'][$delta]['options']['wrapperex'] = [
        '#type' => 'textfield',
        '#default_value' => !empty($items[$delta]->options['wrapperex']) ? $items[$delta]->options['wrapperex'] : '',
        '#size' => 30,
        '#attributes' => [
          'placeholder' => t('Wrapper - prefix ~ suffix'),
        ],
      ];

    }

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  protected function formMultipleElements(FieldItemListInterface $items, array &$form, FormStateInterface $form_state) {
    $elements = parent::formMultipleElements($items, $form, $form_state);
    // Hack - widget id not updated - ? issue with drag handler.
    $elements['#widget'] = 'bricks_tree_inline';

    return $elements;
  }

}
