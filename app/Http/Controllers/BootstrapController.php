<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venue;

use App\Http\Traits\GoogleMapTrait;

class BootstrapController extends Controller
{

  use GoogleMapTrait;

  public function __construct()
  {
  }

  public function load(Request $request)
  {

    $lat = $request->input('latitude');
    $lng = $request->input('longitude');
    $town = "";

    // get all venues
    $venues = Venue::get(["id", "name", "address", "place_id"]);

    // TODO - if lat/lng NOT set by browser, can it be detected by IP?

    // determine location based on lat lng if supplied
    if (isset($lat) && isset($lng)) {

      // TODO - is location info cached? If YES use cached values

      // set origin
      $origin = $lat . "," . $lng;

      // set detsinations
      $destinations = $venues->map(function ($venue) {
        return 'place_id:' . $venue->place_id;
      })->toArray();

      // calculate distances
      $distances = $this->calculate_distances($origin, $destinations);

      // set distances on venue collection, then conmvert to array
      $venues->map(function ($venue, $index) use ($distances) {
        $venue->distance = $distances[$index]["distance"]["value"];
        $venue->distanceDisplay = $distances[$index]["distance"]["text"];
      });

      // convert to array and sort
      $venues_array = $venues->toArray();
      usort($venues_array, function ($a, $b) {
        return $a["distance"] > $b["distance"];
      });

      // get user town
      $town = $this->get_town($origin);

    }

    return response()->json(array(
      "venues" => array_slice($venues_array, 0, 4),
      "userPosition" => array(
        "latitude" => $lat,
        "longitude" => $lng,
        "town" => $town
      )
    ));

  }
}
