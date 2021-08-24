<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use App\Models\Ticket;
use App\Models\Booking;
use App\Models\SearchCache;
use App\Http\Traits\GoogleMapTrait;
use App\Http\Traits\BookingTrait;

class VenueController extends Controller
{

  use GoogleMapTrait;
  use BookingTrait;

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

    $user_id = 1;

    // get all available ticket types
    $tickets = Ticket::where([
      ['venue_id', '=', $id]
    ])->get(["id","name","description","cost","daily_limit","venue_id"]);

    // set avaibility based on bookings
    $tickets = $tickets->map(function ($ticket) use($user_id) {

      // count number of existing bookings
      $bookings = count(Booking::where([
        ['ticket_id', '=', $ticket["id"]]
      ])->get());

      // count number of user bookings
      $user_bookings = count(Booking::where([
        ['ticket_id', '=', $ticket["id"]],
        ['user_id', '=', $user_id]
      ])->get());

      $many_left = $ticket["daily_limit"] - $bookings;

      // get status message
      $status = $this->get_booking_status($user_bookings, $many_left);

      // set avaibility
      $ticket["availability"] = $ticket["daily_limit"] > 0 && $ticket["daily_limit"] > $bookings;
      $ticket["status"] = $status;
      $ticket["user"] = $user_bookings;

      return $ticket;
    })->toArray();
    
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
      $results = json_decode($req->data);
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
        return $v["distance"] < env('SEARCH_DISTANCE_LIMIT', 0);
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
      "search" => $search,
      "limit" => env('SEARCH_DISTANCE_LIMIT', 2000),
      "cached" => !$cache_exists
    ));
  }
}
