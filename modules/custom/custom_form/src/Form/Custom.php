<?php

namespace Drupal\custom_form\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Drupal\Core\Url;


class Custom extends FormBase{

  public function getFormId()
  {
    return "creative_custom_form";
  }

  public function buildForm(array $form, FormStateInterface $form_state)
  {
  if(isset($_GET['id'])) {
     print_r('Hi'); die();
    }
    $form['name'] = [
      '#type' => 'textfield',
      '#size' => '35',
      '#attributes' => ['placeholder' => t('Enter Form Name:')],
    ];

    $form['Mytable'] = [
      '#type' => 'table',
      '#header' => [
        'S_NO',
        'FIELD 1',
        'FIELD 2',
        'TOTAL'
      ],
      '#prefix' => '<div id = "table" >',
      '#suffix' => '</div>'
    ];

    for ($i=1; $i <= 2 ; $i++) {
      $form['Mytable'][$i] = $this->getTableLine($i);
    }

    // Incrementing the rows by getting triggering Event.

    $triggeringElement = $form_state->getTriggeringElement();
    $clickCounter = 0;
    if ($triggeringElement and $triggeringElement['#attributes']['id'] == 'add-row') {
      $clickCounter=$form_state->getValue('click_counter');
      $clickCounter++;
      $form_state->setValue('click_counter',$clickCounter);
      $form['click_counter'] = ['#type' => 'hidden', '#default_value' => 0, '#value' => $clickCounter];
    }
    else {
      $form['click_counter'] = ['#type' => 'hidden', '#default_value' => 0];
    }
    for ($k=0  ; $k<$clickCounter ; $k++) {
      $form['Mytable'][3+$k] = $this->getTableLine(3+$k);
    }

    $form['addRow'] = [
      '#type' => 'button',
      '#value' => t('Add Row'),
      '#attributes' => [
        'id' =>  'add-row'
      ],
    ];

    $form['grandTotal'] = [
      '#type' => 'textfield',
      '#size' => '35',
      '#prefix' => '<div id = "right">',
      '#sufix' => '</div>',
      '#attributes' => ['placeholder' => t('Grand Total'),
      'class' => ['Grandtotal']],
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
      '#button_type' => 'primary'
    ];

    return $form;
  }

  public function getTableLine($key) {
    $line = [];
    $line['col_0'] = [
      '#type' => 'textfield',
      '#size' => '30',
      '#default_value' => $key,
      '#attributes' => [
        'class' => ['cu_serial']],
      ];
      $line['col_1'] = [
        '#type' => 'textfield',
        '#size' => '30',
        '#attributes' => ['placeholder' => t('Enter Value'),
        'class' => ['cu_row']],
      ];
      $line['col_2'] = [
        '#type' => 'textfield',
        '#size' => '30',
        '#attributes' => ['placeholder' => t('Enter Value'),
        'class' => ['cu_row']],
      ];
      $line['col_3'] = [
        '#type' => 'textfield',
        '#size' => '30',
        '#attributes' => ['placeholder' => t('Total'),
        'class' => ['cu_total']],
      ];
      return $line;
    }

    public function submitForm(array &$form, FormStateInterface $form_state){

      $form_name = $form_state->getValues()['name'];
      $grand_total = $form_state->getValues()['grandTotal'];
      foreach($form_state->getValues()['Mytable'] as $value)  {
        $data[] = $value;
      }
      array_push($data, ['grandtotal' => $grand_total]);
      $result = json_encode($data);
      $conn = Database::getConnection();
      $conn->insert('custom_form')->fields(
        [
          'Form_Name' => $form_name,
          'Json' => $result,
        ]
        )->execute();
        drupal_set_message('Thank You.');
        $response = Url::fromUserInput('/creative-form');
        $form_state->setRedirectUrl($response);
      }
    }
