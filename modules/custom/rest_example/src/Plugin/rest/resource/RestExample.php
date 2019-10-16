<?php

namespace Drupal\rest_example\Plugin\rest\resource;

use Drupal\rest\ModifiedResourceResponse;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Provides a resource to get view modes by entity and bundle.
 *
 * @RestResource(
 *   id = "rest_example",
 *   label = @Translation("Rest example"),
 *   uri_paths = {
 *     "canonical" = "/rest/api/get/node/{type}"
 *   }
 * )
 */
class RestExample extends ResourceBase {

  /**
   * Responds to GET requests.
   *
   * @return \Drupal\rest\ResourceResponse
   *   The HTTP response object.
   *
   * @throws \Symfony\Component\HttpKernel\Exception\HttpException
   *   Throws exception expected.
   */
  public function get($type = NULL) {
    // You must to implement the logic of your REST Resource here.
    // Use current user after pass authentication to validate access.
    if (!(\Drupal::currentUser())->hasPermission('access content')) {
       throw new AccessDeniedHttpException();
     }
    if($type == 'product-page') {
      $nids = \Drupal::entityQuery('node')->condition('type','Products')->execute();
      if($nids){
        $nodes =  \Drupal\node\Entity\Node::loadMultiple($nids);
        foreach ($nodes as $key => $value) {
          $data[] = ['id' => $value->id(),'title' => $value->getTitle()];
        }
      }
    }
    else {
      echo 'This page was not found';
    }
    $response = new ResourceResponse($data);
    // In order to generate fresh result every time (without clearing
    // the cache), you need to invalidate the cache.
    $response->addCacheableDependency($data);
    return $response;
  }

}
