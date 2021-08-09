<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venue;

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
    $venues = Venue::get();

    return response()->json(array(
      "venues" => $venues,
      "userPosition" => array(
        "latitude" => $lat,
        "longitude" => $lng,
        "town" => $town
      )
    ));


  }
}
