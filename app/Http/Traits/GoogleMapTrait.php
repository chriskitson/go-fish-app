<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Http;

trait GoogleMapTrait
{

  public function calculate_distances($origin, $destinations)
  {
    // use google apis to get distances
    $key = env('GOOGLE_MAP_SERVER_KEY', '');
    // batch requests up in 25s
    $destinations_batched = array_chunk($destinations, 25);
    $distances = [];

    foreach ($destinations_batched as $batch) {
      $dest = implode("|", $batch);
      $distances_res = Http::get("https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=" . $origin . "&destinations=" . $dest . "&key=" . $key);
      // $distances_res debug:
      // echo json_encode($distances_res->json());
      if (count($distances_res->json()["rows"]) > 0) {
        $distances_results = array_filter($distances_res->json()["rows"][0]["elements"], function ($d) {
          return !isset($d["status"]) || $d["status"] !== "ZERO_RESULTS";
        });
      } else {
        $distances_results = [];
      }
      $distances =  array_merge($distances, $distances_results);
    }
    return $distances;
  }
}
