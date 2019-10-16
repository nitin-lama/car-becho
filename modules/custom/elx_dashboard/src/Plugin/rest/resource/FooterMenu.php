<?php

namespace Drupal\elx_dashboard\Plugin\rest\resource;

use Drupal\rest\Plugin\ResourceBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\Component\Serialization\Json;
use Drupal\elx_dashboard\Utility\DashboardUtility;
use Drupal\elx_utility\RedisClientBuilder;

/**
 * Provides a Footer Menu.
 *
 * @RestResource(
 *   id = "footer_menu",
 *   label = @Translation("Footer Menu"),
 *   uri_paths = {
 *     "canonical" = "/api/v1/footerMenu"
 *   }
 * )
 */
class FooterMenu extends ResourceBase {

  /**
   * Rest resource.
   *
   * @return \Drupal\rest\ResourceResponse
   *   Json response.
   */
  public function get() {
    // Prepare redis key.
    $key = \Drupal::config('elx_utility.settings')->get('elx_environment') .
     ':footerMenu:' .
     \Drupal::currentUser()->getPreferredLangcode();
    try {
      list($cached_data, $redis_client) =
      RedisClientBuilder::getRedisClientObject($key);
      // Get the data from the redis cache with key value.
      if (!empty($cached_data)) {
        return new JsonResponse($cached_data, 200, [], TRUE);
      }
    }
    catch (\Exception $e) {
      $view_results = $this->getFooterMenuResponse();

      return new JsonResponse($view_results, 200, [], TRUE);
    }
    $view_results = $this->getFooterMenuResponse();
    if (empty($view_results)) {
      return new JsonResponse(Json::encode([]), 204, [], TRUE);
    }
    $key = explode(":", $key);
    $redis_client->set($view_results, $key[0], $key[1], $key[2]);

    return new JsonResponse($view_results, 200, [], TRUE);
  }

  /**
   * Fetch Footer menu.
   *
   * @return json
   *   return json formatted result.
   */
  protected function getFooterMenuResponse() {
    $dashboard_utility = new DashboardUtility();
    // Load social media Menu.
    $social_menu = $dashboard_utility->getMenuByName('social-media',
    'social');
    // Load privacy Menu.
    $privacy_menu = $dashboard_utility->getMenuByName('privacy-menu',
    'privacy');
    $data['socialMenu'] = array_values(array_filter($social_menu));
    $data['privacyMenu'] = array_values(array_filter($privacy_menu));
    $view_results = JSON::encode($data);
    if (is_object($view_results)) {
      $view_results = $view_results->getContent();
    }

    return $view_results;
  }

}
