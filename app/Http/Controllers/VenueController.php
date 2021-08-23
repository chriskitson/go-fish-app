<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use App\Models\SearchCache;
use App\Http\Traits\GoogleMapTrait;

class VenueController extends Controller
{

  use GoogleMapTrait;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
  }

  public function all()
  {
    $venues = Venue::get();
    return response()->json($venues);
  }

  public function get($id)
  {
    $venue = Venue::find($id, ['id', 'name', 'address', 'description']);
    return response()->json($venue);
  }

  public function tickets($id)
  {
    $tickets = array(
      array(
        "id" => 1,
        "name" => "Day Ticket (4 fish)",
        "description" => "Full day fishing with 4 fish limit.",
        "cost" => 130,
        "availability" => true
      ),
      array(
        "id" => 2,
        "name" => "Day Ticket (3 fish)",
        "description" => "Full day fishing with 3 fish limit.",
        "cost" => 115,
        "availability" => false
      ),
      array(
        "id" => 3,
        "name" => "Half Day (2 fish)",
        "description" => "From 08.00 – 13.00hrs",
        "cost" => 100,
        "availability" => true
      ),
      array(
        "id" => 4,
        "name" => "Catch & Release",
        "description" => "On Stillwaters Lake only. *Barbless hooks only",
        "cost" => 75,
        "availability" => true
      ),
      array(
        "id" => 5,
        "name" => "Carrier Only",
        "description" => "Trout season 3rd April – 30th September. (All fish returned to river)",
        "cost" => 80,
        "availability" => false
      )
    );
    return response()->json($tickets);
  }

  function search($date, $location)
  {

    // determine location and check if cache exists
    $cache_exists = isset($location) && count(SearchCache::where([
      ['id', '=', $location],
      ['expires', '>=', date('Y-m-d')]
    ])->get()) > 0;

    if ($cache_exists) { // load venues from cached results

      $req = SearchCache::where([
        ['id', '=', $location],
        ['expires', '>=', date('Y-m-d')]
      ])->first();

      $search = $req->search;
      $venues = json_decode($req->data);
    } else { // look up location based data search results

      // get search by place_id
      $search = $this->get_address($location, "place_id");

      // get all venues
      $venues = Venue::get(["id", "name", "address", "place_id"]);

      // set origin
      $origin = 'place_id:' . $location;

      // set destinations
      $destinations = $venues->map(function ($venue) {
        return 'place_id:' . $venue->place_id;
      })->toArray();

      // calculate distances
      $distances = $this->calculate_distances($origin, $destinations);

      // set distances on venue collection, then convert to array
      $venues->map(function ($venue, $index) use ($distances) {
        $venue->distance = $distances[$index]["distance"]["value"];
        $venue->distanceDisplay = $distances[$index]["distance"]["text"];
      });

      // convert to array, filter  and sort
      $results = $venues->toArray();
      $results = array_filter($results, function ($v) {
        return $v["distance"] < 20000;
      });
      usort($results, function ($a, $b) {
        return $a["distance"] > $b["distance"];
      });

      // write to cache expiring in 1 week
      $cache = new SearchCache([
        "id" => $location,
        "search" => $search,
        "data" => json_encode($results),
        "expires" => date('Y-m-d', strtotime(env('CACHE_EXPIRES', '+1 week')))
      ]);
      $cache->save();

    }

    // TODO - work out availability of dates based on distance

    return response()->json(array(
      "results" => $results,
      "search" => $search
    ));
  }
}
