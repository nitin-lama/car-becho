<?php


namespace Drupal\project\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Implements the SimpleForm form controller.
 *
 * This example demonstrates a simple form with a single text input element. We
 * extend FormBase which is the simplest form base class used in Drupal.
 *
 * @see \Drupal\Core\Form\FormBase
 */
class ProjectCreate extends FormBase {

  /**
   * Build the simple form.
   *
   * A build form method constructs an array that defines how markup and
   * other form elements are included in an HTML form.
   *
   * @param array $form
   *   Default form array structure.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   Object containing current form state.
   *
   * @return array
   *   The render array defining the elements of the form.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['description'] = [
      '#type' => 'item',
      '#markup' => $this->t('Shipment Details'),
    ];
//    $form['submit'] = array(
//            '#type' => 'submit',
//            '#value' => t('Submit'),
//    );

    // table

//    $num_names = $form_state->get('num_names');
//    if ($num_names === NULL) {
//      $name_field = $form_state->set('num_names', 1);
//      $num_names = 1;
//    }
//    $form['#tree'] = TRUE;
//    $form['names_fieldset'] = [
//      '#type' => 'fieldset',
//      '#prefix' => '<div id="names-fieldset-wrapper">',
//      '#suffix' => '</div>',
//    ];
//    for ($i = 0; $i < $num_names; $i++) {
//      $form['names_fieldset']['name'][$i] = [
//        '#type' => 'textfield',
//        '#title' => $this->t('Name'),
//      ];
//    }
//    $form['names_fieldset']['actions'] = [
//      '#type' => 'actions',
//    ];
//    $form['names_fieldset']['actions']['add_name'] = [
//      '#type' => 'submit',
//      '#value' => $this->t('Add one more'),
//      '#submit' => ['::addOne'],
//      '#ajax' => [
//        'callback' => '::addmoreCallback',
//        'wrapper' => 'names-fieldset-wrapper',
//      ],
//    ];
//    if ($num_names > 1) {
//      $form['names_fieldset']['actions']['remove_name'] = [
//        '#type' => 'submit',
//        '#value' => $this->t('Remove one'),
//        '#submit' => ['::removeCallback'],
//        '#ajax' => [
//          'callback' => '::addmoreCallback',
//          'wrapper' => 'names-fieldset-wrapper',
//        ],
//      ];
//    }


    $form['fieldset_one'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Shipment Details'),
      '#prefix' => '<div id="names-fieldset-wrapper">',
      '#suffix' => '</div>',
    ];


    $form['fieldset_one']['title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Name of Project'),
    ];
    $form['fieldset_one']['origin'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Origin:'),
    ];
    $form['fieldset_one']['pickupdate'] = [
      '#type' => 'date',
      '#title' => t('Pickup Date:'),
//      '#required' => TRUE,
    ];


    $form['fieldset_one']['destination'] = [
      '#type' => 'textfield',
      '#title' => t('Destination:'),
    ];
    $form['fieldset_one']['transportmode'] = [
      '#type' => 'textfield',
      '#title' => t('Mode of Transport:'),
    ];
    $form['fieldset_one']['incoterms'] = [
      '#type' => 'select',
      '#title' => $this->t('Incoterms:'),
      '#options' => [
        'exw' => $this->t('EXW'),
        'fca' => $this->t('FCA'),
        'cpt' => $this->t('CPT'),
        'cip' => $this->t('CIP'),
        'dat' => $this->t('DAT'),
        'dap' => $this->t('DAP'),
        'ddp' => $this->t('DDP'),
        'fas' => $this->t('FAS'),
        'fob' => $this->t('FOB'),
        'cfr' => $this->t('CFR'),
        'cip' => $this->t('CIP'),
      ],
      '#empty_option' => $this->t('Select'),
    ];
    $form['fieldset_one']['etadeadline'] = [
      '#type' => 'date',
      '#title' => t('ETA Deadline:'),
    ];
//    $form['fieldset_two'] = [
//      '#type' => 'fieldset',
//      '#prefix' => '<div id="names-fieldset-wrapper">',
//      '#suffix' => '</div>',
//    ];
    // Freight Details
    $form['myTable'] = [
      '#type' => 'table',
      '#header' => [
        'Pieces',
        'Length (IN)',
        'Width (IN)',
        'Height (IN)',
        'Weight (LBS)'
      ],
      '#prefix' => '<div id="names-fieldset-wrapper">',
      '#suffix' => '</div>',
    ];


    // Freight Details
    $form['fieldset_four'] = [
      '#type' => 'fieldset',
      '#prefix' => '<div id="names-fieldset-wrapper">',
      '#suffix' => '</div>',
    ];
    $form['fieldset_four']['commodity'] = [
      '#type' => 'textfield',
      '#title' => t('Commodity:'),
      '#attached' => [
        'library' => ['project/project'],
      ],
    ];
    $form['fieldset_four']['text'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Requirements:'),
      '#attributes' => [
        'placeholder' => t('CARRIER MUST MEET TRANSIT DEADLINE. EXPRESS QUOTE IF NEEDED TO MEET ETA.'),
      ],
    ];
    $form['actions'] = [
      '#type' => 'actions',
    ];

		$form['addRow'] = [
      '#type' => 'button',
      '#value' => t('Add a row'),
      '#ajax' => [
        'callback' =>  '::ajaxAddRow',
        'event' => 'click',
        'wrapper' => 'my-table-wrapper',
      ],
      '#attributes' => [
      'id' =>  'add-row'
      ],
	  '#prefix' => '<div id="names-fieldset-wrapper">',
      '#suffix' => '</div>',
    ];

    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    return $form;
  }




  /**
   * Getter method for Form ID.
   *
   * The form ID is used in implementations of hook_form_alter() to allow other
   * modules to alter the render array built by this form controller. It must be
   * unique site wide. It normally starts with the providing module's name.
   *
   * @return string
   *   The unique ID of the form defined by this class.
   */
  public function getFormId() {
    return 'form_api_example_simple_form';
  }

  /**
   * Callback for both ajax-enabled buttons.
   *
   * Selects and returns the fieldset with the names in it.
   */
  public function addmoreCallback(array &$form, FormStateInterface $form_state) {
    return $form['names_fieldset'];
  }

 public function ajaxAddRow($form, $form_state) {
    $cpt=0;
    for ($x = 0; $x <= 10 & $form['myTable'][$x]; $x++) {
        $cpt++;
    }

    // $cpt always return 6 - expected to increment
    // $form['myTable'][$cpt] is always empty

    $form['myTable'][$cpt] = $this->getTableLine($cpt);

    return $form['myTable'];

}

  /**
   * Submit handler for the "add-one-more" button.
   *
   * Increments the max counter and causes a rebuild.
   */
  public function addOne(array &$form, FormStateInterface $form_state) {
    $name_field = $form_state->get('num_names');
    $add_button = $name_field + 1;
    $form_state->set('num_names', $add_button);
    $form_state->setRebuild();
  }

  /**
   * Submit handler for the "remove one" button.
   *
   * Decrements the max counter and causes a form rebuild.
   */
  public function removeCallback(array &$form, FormStateInterface $form_state) {
    $name_field = $form_state->get('num_names');
    if ($name_field > 1) {
      $remove_button = $name_field - 1;
      $form_state->set('num_names', $remove_button);
    }
    $form_state->setRebuild();
  }

  /**
   * Implements a form submit handler.
   *
   * The submitForm method is the default method called for any submit elements.
   *
   * @param array $form
   *   The render array of the currently built form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   Object describing the current state of the form.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $title = $form_state->getValue('title');
    $this->messenger()->addMessage($this->t('You specified a title of %title.', ['%title' => $title]));
  }

}
