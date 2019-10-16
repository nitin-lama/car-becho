<?php

namespace Drupal\simple_form\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\ReplaceCommand;
use Drupal\rest\ResourceResponse;
use Drupal\user\Entity;

class SimpleForm extends FormBase{
  public function getFormId(){
    return "language_form";
  }

  public function buildForm(array $form, FormStateInterface $form_state){

    $lang = \Drupal::currentUser()->getPreferredLangcode();
      $form['language'] = [
      '#type' => 'select',
      '#title' => $this->t('Select Language'),
      '#options' => [
        'en' => $this->t('English'),
        'hi' => $this->t('Hindi')
      ],
      '#default_value' => $lang,
     '#attributes' => ['onchange' => 'this.form.submit();'],
    //   '#ajax' => [
    //     'callback' => '::myAjaxCallback', // don't forget :: when calling a class method.
    //     'disable-refocus' => TRUE, // Or TRUE to prevent re-focusing on the triggering element.
    //     'event' => 'change',
    //     'wrapper' => 'edit-output', // This element is updated with this AJAX callback.
    //     'progress' => [
    //       'type' => 'throbber',
    //       'message' => $this->t('Verifying Language...'),
    //     ],
    //   ]
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#attributes' => [
        'class' => ['js-hide']
      ]
    ];

    return $form;
  }

//Get the value from Language select field
  public function myAjaxCallback(array &$form, FormStateInterface $form_state) {
    // if ($selectedValue = $form_state->getValue('language')) {
    //   $user_id = \Drupal::currentUser()->id();
    //   $user = \Drupal::service('entity_type.manager')->getStorage('user')->load($user_id);
    //   $user->set('preferred_langcode', $selectedValue);
    //   $user->save();
    // }
  }

  public function submitForm(array &$form, FormStateInterface $form_state){
    if ($selectedValue = $form_state->getValue('language')) {
      $user_id = \Drupal::currentUser()->id();
      $user = \Drupal::service('entity_type.manager')->getStorage('user')->load($user_id);
      $user->set('preferred_langcode', $selectedValue);
      $user->save();
    }

  }
}
