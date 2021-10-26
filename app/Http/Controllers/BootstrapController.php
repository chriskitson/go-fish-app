<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venue;
use App\Models\RequestCache;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

use App\Http\Traits\GoogleMapTrait;

class BootstrapController extends Controller
{

  use GoogleMapTrait;

  public function __construct()
  {
  }

  public function load(Request $request)
  {

    $c = $request->input('c');
    $lat = $request->input('latitude');
    $lng = $request->input('longitude');

    $response = array();

    // determine location based on cache token
    $cache_exists = isset($c) && count(RequestCache::where([
      ['id', '=', $c],
      ['expires', '>=', date('Y-m-d')]
    ])->get()) > 0;

    if ($cache_exists) { // load from cached request

      $req = RequestCache::where([
        ['id', '=', $c],
        ['expires', '>=', date('Y-m-d')]
      ])->first();

      $response = json_decode($req->data);
    } else {  // look up location based data

      $town = "";
      // $response = "";
      $venues_array = [];

      // get all venues
      $venues = Venue::get(["id", "name", "address", "place_id"]);

      // TODO - if lat/lng NOT set by browser, can it be detected by IP?

      // determine location based on lat lng if supplied
      if (isset($lat) && isset($lng)) {

        // set origin
        $origin = $lat . "," . $lng;

        // set destinations
        $destinations = $venues->map(function ($venue) {
          return 'place_id:' . $venue->place_id;
        })->toArray();

        // calculate distances
        $distances = $this->calculate_distances($origin, $destinations);

        // set distances on venue collection, then convert to array
        $venues->map(function ($venue, $index) use ($distances) {
          $venue->distance = isset($distances[$index]["distance"]) ? $distances[$index]["distance"]["value"] : 0;
          $venue->distanceDisplay = isset($distances[$index]["distance"]) ? $distances[$index]["distance"]["text"] : "";
        });

        // convert to array and sort
        $venues_array = $venues->toArray();
        usort($venues_array, function ($a, $b) {
          return $a["distance"] > $b["distance"];
        });

        // get user town
        $town = $this->get_town($origin);

        // generate cache id
        $cache_id = Str::uuid();

        // create response array
        $response = array(
          "venues" => array_slice($venues_array, 0, 4),
          "userPosition" => array(
            "latitude" => $lat,
            "longitude" => $lng,
            "town" => $town
          ),
          "token" => $cache_id,
        );

        // write to cache expiring in 1 week
        $cache = new RequestCache([
          "id" => $cache_id,
          "data" => json_encode($response),
          "expires" => date('Y-m-d', strtotime(env('CACHE_EXPIRES', '+1 week')))
        ]);
        $cache->save();
      }
    }

    if (Auth::check()) {
      $user = $request->user();
      $response->user = array(
        "userType" => $user->user_type,
        "globalAdmin" => $user->global_admin === 1
      );
    } else {
      $response->user = array(
        "userType" => 0,
        "globalAdmin" => false
      );
    }

    return response()->json($response);
  }
}
