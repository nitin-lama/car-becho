<?php

namespace Drupal\subscribe_task\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\Response;

class Subscribe extends ControllerBase  {
  public function test()  {
    $status = 0;
    $user_id = \Drupal::currentUser()->id();
    $nid = \Drupal::request()->query->get('nid');
    if($nid) {
      $conn = Database::getConnection();
      $conn->insert('subscribe')->fields(
        [
            'UID' => $user_id,
            'NID' => $nid
        ]
      )->execute();
    $status = 1;
    }
    $response = new Response();
    json_encode($response->setContent($status));
    return $response;
  }
}
