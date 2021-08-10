<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venue;
use Illuminate\Support\Facades\Http;

class BootstrapController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
  }

  public function load(Request $request)
  {

    $lat = $request->input('latitude');
    $lng = $request->input('longitude');

    // determine location based on lat lng if supplied
    $town = "";
    if (isset($lat) && isset($lng)) {

      // Ref: https://github.com/alexpechkarev/google-maps
      $response = \GoogleMaps::load('geocoding')
        ->setParamByKey('latlng', $lat . ',' . $lng)
        ->get('results');

      $address_components = $response["results"][0]["address_components"];

      $town_filter = current(array_filter($address_components, function ($a) {
        return in_array("postal_town", $a["types"]);
      }));

      $town = isset($town_filter) ? $town_filter["long_name"] : "";
    }

    // get all venues
    $venues = Venue::take(100)->get();

    // use google apis to get distances
    $key = "AIzaSyCsdU2LNn340yztbnjNhjYDeg2Gd4S3x40";
    $origin = $lat . "," . $lng;

    $destinations = $venues->map(function ($venue) {
      return 'place_id:' . $venue->place_id;
    })->toArray();

    $destinations_batched = array_chunk($destinations , 25);

    $distances = [];
    foreach($destinations_batched as $batch) {
      $dest = implode("|", $batch);
      $distances_res = Http::get("https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=" . $origin . "&destinations=" . $dest . "&key=" . $key);
      $distances =  array_merge($distances, $distances_res->json()["rows"][0]["elements"]);
    }

    // set distances
    $venues->map(function ($venue, $index) use ($distances) {
      $venue->distance = $distances[$index]["distance"]["value"];
      $venue->distanceDisplay = $distances[$index]["distance"]["text"];
      $index++;
    });

    return response()->json(array(
      "venues" => $venues->sortBy('distance')->take(4),
      "userPosition" => array(
        "latitude" => $lat,
        "longitude" => $lng,
        "town" => $town
      )
    ));

    //place_id


  }
}
