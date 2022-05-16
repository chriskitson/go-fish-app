<?php

namespace App\Http\Traits;

trait KlaviyoTrait
{

  public function add_connected_account_link_to_profile($profile, $link)
  {
      echo json_encode(array(
          "profile" => $profile,
          "link" => $link
      ));
  }
  
}
