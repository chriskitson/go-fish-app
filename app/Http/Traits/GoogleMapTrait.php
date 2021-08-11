<?php

namespace App\Http\Traits;
use Illuminate\Support\Facades\Http;

trait GoogleMapTrait {

    public function get_town($origin) {
      // Ref: https://github.com/alexpechkarev/google-maps

      // get user location based on lat lng
      $response = \GoogleMaps::load('geocoding')
        ->setParamByKey('latlng', $origin)
        ->get('results');

      $town_filter = current(array_filter($response["results"][0]["address_components"], function ($a) {
        return in_array("postal_town", $a["types"]);
      }));

      $town = isset($town_filter) ? $town_filter["long_name"] : "";

      return $town;
    }

    public function calculate_distances($origin, $destinations) {
      // use google apis to get distances
      $key = "AIzaSyCsdU2LNn340yztbnjNhjYDeg2Gd4S3x40";

      // batch requests up in 25s
      $destinations_batched = array_chunk($destinations, 25);

      $distances = [];
      foreach ($destinations_batched as $batch) {
        $dest = implode("|", $batch);
        $distances_res = Http::get("https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=" . $origin . "&destinations=" . $dest . "&key=" . $key);
        $distances =  array_merge($distances, $distances_res->json()["rows"][0]["elements"]);
      }

      return $distances;

    }



}

?>