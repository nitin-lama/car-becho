<?php

namespace Drupal\custom_action\Plugin\Action;

use Drupal\views_bulk_operations\Action\ViewsBulkOperationsActionBase;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\redirect\Entity\Redirect;

/**
 * Some description.
 *
 * @Action(
 *   id = "compare",
 *   label = @Translation("Compare"),
 *   type = "node",
 *   confirm = TRUE,
 *   requirements = {
 *     "_permission" = "access content",
 *     "_custom_access" = TRUE,
 *   },
 * )
 */

class compare extends ViewsBulkOperationsActionBase {

  use StringTranslationTrait;

  /**
   * {@inheritdoc}
   */

  public function execute($entity = NULL) {
    return $this->t('Some result');
  }

  /**
   * {@inheritdoc}
   */

  public function access($object, AccountInterface $account = NULL, $return_as_object = FALSE) {
    if ($object->getEntityType() === 'node') {
      $access = $object->access('update', $account, TRUE)
        ->andIf($object->status->access('edit', $account, TRUE));
      return $return_as_object ? $access : $access->isAllowed();
    }
    return TRUE;
  }

  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
     $entity_id = [];
     $selectedItems = array_map(function ($listItem)
        {
            return reset($listItem);
          },  $this->context['list']);

      foreach ($selectedItems as $id) {
      $entity_id['id'][] = $id;
      }
    if(count($entity_id['id']) > 1 && count($entity_id['id']) < 4)
    {
      $url1 = http_build_query($entity_id);
      $url = '/compare_page?'. urldecode($url1);
      $response = new RedirectResponse($url);
      return $response->send();
    }
    else
    {
      drupal_set_message(t('You can compare only maximum 3 & minimum 2 products'), 'error');
      $response = new RedirectResponse('/car-becho');
      return $response->send();
    }
  }
}
