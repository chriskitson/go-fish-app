<?php

namespace App\Http\Traits;
use Illuminate\Support\Facades\Http;

trait GoogleMapTrait {

    public function get_town($origin, $key = "latlng") {
      // Ref: https://github.com/alexpechkarev/google-maps

      // get user location based on lat lng
      $response = \GoogleMaps::load('geocoding')
        ->setParamByKey($key, $origin)
        ->get('results');

      if ($response["results"] && count($response["results"]) > 0) {
        $town_filter = current(array_filter($response["results"][0]["address_components"], function ($a) {
          return in_array("postal_town", $a["types"]);
        }));

        $town = isset($town_filter["long_name"]) ? $town_filter["long_name"] : "";
      } else {
        $town = '';
      }

      return $town;
    }

    public function get_address($origin, $key = "latlng") {
      // Ref: https://github.com/alexpechkarev/google-maps

      // get user location based on lat lng
      $response = \GoogleMaps::load('geocoding')
        ->setParamByKey($key, $origin)
        ->get('results');

      return $response["results"][0]["formatted_address"];
      
    }

    public function get_address_data($origin, $key = "latlng") {
      // Ref: https://github.com/alexpechkarev/google-maps
      // get user location based on lat lng
      $response = \GoogleMaps::load('geocoding')
        ->setParamByKey($key, $origin)
        ->get('results');
      if (isset($response["results"]) && count($response["results"]) > 0) {
        return $response["results"][0];
      }
      return null;
    }

    public function get_place_data($place_id) {
      // use google apis to get distances
      $key = env('GOOGLE_MAP_KEY', '');
      $detail_res = Http::get("https://maps.googleapis.com/maps/api/place/details/json?place_id=" . $place_id . "&key=" . $key);
      return $detail_res->json();
    }

    public function calculate_distances($origin, $destinations) {
      // use google apis to get distances
      $key = env('GOOGLE_MAP_KEY', '');

      // batch requests up in 25s
      $destinations_batched = array_chunk($destinations, 25);

      $distances = [];
      foreach ($destinations_batched as $batch) {
        $dest = implode("|", $batch);
        $distances_res = Http::get("https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=" . $origin . "&destinations=" . $dest . "&key=" . $key);
        if (count($distances_res->json()["rows"]) > 0) {
          $distances_results = array_filter($distances_res->json()["rows"][0]["elements"], function($d) {
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

?>