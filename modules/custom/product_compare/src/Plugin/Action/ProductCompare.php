<?php

namespace Drupal\product_compare\Plugin\Action;

use Drupal\views_bulk_operations\Action\ViewsBulkOperationsActionBase;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
//echo "in php";die;
use Drupal\views_bulk_operations\Action\ViewsBulkOperationsPreconfigurationInterface;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\views_bulk_operations\Form\ViewsBulkOperationsFormTrait;
use Drupal\redirect\Entity\Redirect;


/**
 * Action description.
 *
 * @Action(
 *   id = "product_compare_action",
 *   label = @Translation("Product Compare Action label"),
 *   type = ""
 * )
 */
class ProductCompare extends ViewsBulkOperationsActionBase {

  use StringTranslationTrait;

  /**
   * {@inheritdoc}
   */
  public function execute($entity = NULL) {
    // Do some processing..

    // Don't return anything for a default completion message, otherwise return translatable markup.
    return $this->t('Some result');
  }

  /**
   * {@inheritdoc}
   */
  public function access($object, AccountInterface $account = NULL, $return_as_object = FALSE) {
    if ($object->getEntityType() === 'node') {
      //kint($object->getEntityType);
      //die();
      $access = $object->access('update', $account, TRUE)
        ->andIf($object->status->access('edit', $account, TRUE));
      return $return_as_object ? $access : $access->isAllowed();
    }

    // Other entity types may have different
    // access methods and properties.
    return TRUE;
  }


  /**
  * {@inheritdoc}
  */
 public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
  $entity_id = array();
  $selectedItems = array_map(function ($listItem) {
     return reset($listItem);
   }, $this->context['list']);
   foreach ($selectedItems as $id) {
   $entity_id[] = $id;
   kint($entity_id);
   die();
}

  /*Redirect::create([
  'redirect_source' => '/compare-product',
  'redirect_redirect' => 'internal:/node/9',
  'status_code' => 301,
])->save();*/
if(count($entity_id) == 2 || count($entity_id) == 3 ){
print_r($entity_id);
$nids = implode(',', $entity_id);
print_r($nids);
die();
$url = '/cardekho/compare-product/'.$nids;
return new RedirectResponse($url);
   return $form;
 }
 else
 {
  drupal_set_message(t('You can compare 2 and 3 product'), 'error');
  $response = new RedirectResponse('/cardekho/car-view');
  return $response->send();
   //echo "Please Select 2 and 3 Product";
 }
}


 /**
 * {@inheritdoc}
 */

//  public function validateConfigurationForm(array &$form, FormStateInterface $form_state) {
//    if(count($selectedItems == 1)){
//      echo "Hello";
//    }
//
// }
// public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
//   echo "in submit";die;
//
// }

}
