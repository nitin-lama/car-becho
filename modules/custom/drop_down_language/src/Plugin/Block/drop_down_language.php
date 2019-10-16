<?php
 namespace Drupal\drop_down_language\Plugin\Block;
 use Drupal\Core\Block\BlockBase;
 use Drupal\Core\Form\FormStateInterface;
 use Drupal\Core\Config\ConfigFactoryInterface;
 use Drupal\Core\Language\LanguageManagerInterface;
 /**
  * Provides a 'Drop Down Language Switcher' Block.
  *
  * @Block(
  *   id = "drop_down_language2",
  *   admin_label = @Translation("Drop Down Language Switcher2"),
  *   category = @Translation("Drop Down Language"),
  * )
  */
 class drop_down_language extends BlockBase {
   /**
    * {@inheritdoc}
    */

    public function build() {
     $form = \Drupal::formBuilder()->getForm('Drupal\simple_form\Form\SimpleForm');
    return $form;
 }
}
