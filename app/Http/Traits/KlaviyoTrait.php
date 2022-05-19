<?php

namespace App\Http\Traits;

use Klaviyo\Client;

trait KlaviyoTrait
{

  public function add_profile($list_id, $email, $first_name, $last_name)
  {
    $client = new Client($_ENV['KLAVIYO_PRIVATE'], $_ENV['KLAVIYO_PUBLIC']);
    $profiles = array(
      "profiles" => [
        array(
          "email" => $email,
          "first_name" => $first_name,
          "last_name" => $last_name,
          "role" => "Fisher"
        )
      ]
    );
    return $client->ListsSegments->subscribe($list_id, $profiles);
  }

  public function add_connected_account_link_to_profile($list_id, $email, $first_name, $last_name, $venue_name, $stripe_link)
  {
    $client = new Client($_ENV['KLAVIYO_PRIVATE'], $_ENV['KLAVIYO_PUBLIC']);
    $profiles = array(
      "profiles" => [
        array(
          "email" => $email,
          "first_name" => $first_name,
          "last_name" => $last_name,
          "role" => "Fishery",
          "$" . "venue_name" => $venue_name,
          "$" . "stripe_link" => $stripe_link,
        )
      ]
    );
    return $client->ListsSegments->subscribe($list_id, $profiles);
  }
}
