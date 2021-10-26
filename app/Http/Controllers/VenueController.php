<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use App\Models\Ticket;
use App\Models\Booking;
use App\Models\SearchCache;
use App\Http\Traits\GoogleMapTrait;
use App\Http\Traits\BookingTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
    $venues = Venue::orderBy("name", "ASC")->get();
    return response()->json($venues);
  }

  public function get($id)
  {
    $venue = Venue::find($id, ["id", "name", "address", "description"]);
    return response()->json($venue);
  }

  public function get_detail($id)
  {
    $venue = Venue::find($id);
    return response()->json($venue);
  }

  public function get_tickets_detail($id)
  {
    $tickets = Ticket::where([
      ["venue_id", "=", $id]
    ])->get();
    return response()->json($tickets);
  }

  public function ticket_format($ticket, $date, $user_id)
  {

    $bookings = count(Booking::join("transactions", "transactions.id", "bookings.transaction_id")->where([
      ["ticket_id", "=", $ticket["id"]],
      ["confirmed", true]
    ])->whereDate("bookings.created_at", $date)->get("bookings.id"));

    // count number of user bookings
    $user_bookings = count(Booking::join("transactions", "transactions.id", "bookings.transaction_id")->where([
      ["ticket_id", "=", $ticket["id"]],
      ["user_id", "=", $user_id],
      ["confirmed", true]
    ])->whereDate("bookings.created_at", $date)->get("bookings.id"));

    $many_left = $ticket["daily_limit"] - $bookings;

    // get status message
    $status = $this->get_booking_status($user_bookings, $many_left);

    // set avaibility
    $ticket["availability"] = $ticket["daily_limit"] > 0 && $ticket["daily_limit"] > $bookings;
    $ticket["status"] = $status;
    $ticket["user"] = $user_bookings;

    return $ticket;
  }

  public function tickets(Request $request, $id)
  {

    $user = $request->user();
    $user_id = isset($user) ? $user->id : 0;

    $date = gmdate("Y-m-d", $request->input("d") / 1000);

    // get all available ticket types
    $tickets = Ticket::where([
      ["venue_id", "=", $id]
    ])->orderBy("name", "ASC")->get(["id", "name", "description", "cost", "daily_limit", "venue_id"]);

    // set avaibility based on bookings
    $tickets = $tickets->map(function ($ticket) use ($user_id, $date) {
      return $this->ticket_format($ticket, $date, $user_id);
    })->toArray();

    return response()->json($tickets);
  }

  public function ticket(Request $request, $venue_id, $id)
  {

    $user = $request->user();
    $user_id = isset($user) ? $user->id : 0;

    $date = gmdate("Y-m-d", $request->input("d") / 1000);

    // get all available ticket types
    $ticket = Ticket::where([
      ["id", "=", $id],
      ["venue_id", "=", $venue_id]
    ])->first(["id", "name", "description", "cost", "daily_limit", "venue_id"])->toArray();

    $ticket = $this->ticket_format($ticket, $date, $user_id);

    return response()->json($ticket);
  }

  function get_town_by_place_id($place_id)
  {
    return $this->get_town($place_id, "place_id");
  }

  function search($date, $location)
  {

    $date = gmdate("Y-m-d", $date / 1000);

    // determine location and check if cache exists
    $cache_exists = isset($location) && count(SearchCache::where([
      ["id", "=", $location]
    ])->get()) > 0;

    if ($cache_exists) { // load venues from cached results

      $req = SearchCache::where([
        ["id", "=", $location]
      ])->first();

      $search = $req->search;
      $results = json_decode($req->data);
    } else { // look up location based data search results

      // get search by place_id
      $search = $this->get_address($location, "place_id");

      // get all venues
      $venues = Venue::get(["id", "name", "address", "place_id"]);

      // set origin
      $origin = "place_id:" . $location;

      // set destinations
      $destinations = $venues->map(function ($venue) {
        return "place_id:" . $venue->place_id;
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
        return $v["distance"] < env("SEARCH_DISTANCE_LIMIT", 0);
      });
      usort($results, function ($a, $b) {
        return $a["distance"] > $b["distance"];
      });

      // write to cache expiring in 1 week
      $cache = new SearchCache([
        "id" => $location,
        "search" => $search,
        "data" => json_encode($results),
        "expires" => date("Y-m-d", strtotime(env("CACHE_EXPIRES", "+1 week")))
      ]);
      $cache->save();

      // read results back from cache (better performance)
      $results = json_decode($cache->data);
    }

    if (count($results) > 0) {

      foreach ($results as $result) {

        if (isset($result)) {

          $venue_id = $result->id;

          // check tickets
          $tickets = Ticket::where([
            ["venue_id", "=", $venue_id]
          ])->get()->filter(function ($ticket) use ($date) {
            // get daily limit
            $daily_limit = $ticket->daily_limit;
            // count number of bookings
            $bookings = count(Booking::join("transactions", "transactions.id", "bookings.transaction_id")->where([
              ["ticket_id", "=", $ticket->id],
              ["confirmed", true]
            ])->whereDate("bookings.created_at", $date)->get("bookings.id"));
            // return available tickets
            return $daily_limit > 0 && $daily_limit > $bookings;
          })->values()->toArray();

          $result->tickets = $tickets;
        }
      }
    }

    return response()->json(array(
      "results" => $results,
      "search" => $search,
      "limit" => env("SEARCH_DISTANCE_LIMIT", 2000),
      "cached" => !$cache_exists
    ));
  }

  public function manage_details(Request $request, $venue_id)
  {

    $user = $request->user();
    $is_admin = false; // TODO
    $is_global_admin = $user->global_admin == 1;

    if ($is_admin || $is_global_admin) {

      $validators = [
        "description" => ["required", "string"],
        "rules" => ["required", "string"],
        "address" => ["required", "string", "max:255"],
        "place_id" => ["required", "string", "max:45"],
      ];

      $validator = Validator::make($request->all(), $validators);

      if ($validator->fails()) {
        $response["response"] = $validator->messages();
        return $response;
      }

      $fields = array(
        "description" => $request->description,
        "rules" => $request->rules,
        "address" => $request->address,
        "place_id" => $request->place_id
      );

      Venue::where([
        ["id", "=", $venue_id]
      ])->update($fields);

      return response()->json(Venue::find($venue_id, ["description", "rules", "address", "place_id"]));
    } else {
      return response("Unauthorized", 401);
    }
  }

  public function manage_ticket(Request $request, $venue_id)
  {

    $user = $request->user();
    $is_admin = false; // TODO
    $is_global_admin = $user->global_admin == 1;

    if ($is_admin || $is_global_admin) {

      $validators = [
        "id" => ["required", "integer"],
        "name" => ["required", "string", "max:255"],
        "description" => ["required", "string", "max:255"],
        "daily_limit" => ["required", "integer", "max:255"],
        "cost" => ["required", "regex:/^\d+(\.\d{1,2})?$/"],
      ];

      $validator = Validator::make($request->all(), $validators);

      if ($validator->fails()) {
        $response["response"] = $validator->messages();
        return $response;
      }

      $fields = array(
        "name" => $request->name,
        "description" => $request->description,
        "daily_limit" => $request->daily_limit,
        "cost" => $request->cost,
        "venue_id" => $venue_id
      );

      if ($request->id > 0) { // update existing ticket
        
        Ticket::where([
          ["id", "=", $request->id],
          ["venue_id", "=", $venue_id],
        ])->update($fields);
        $ticket_id = $request->id;

      } else {  // add new ticket

        $ticket = new Ticket($fields);
        $ticket->save();
        $ticket_id = $ticket->id;
      }

      return response()->json(Ticket::find($ticket_id, ["id", "name", "description", "daily_limit", "cost"]));
    } else {
      return response("Unauthorized", 401);
    }
  }

  public function delete_ticket(Request $request, $venue_id, $ticket_id)
  {

    $user = $request->user();
    $is_admin = false; // TODO
    $is_global_admin = $user->global_admin == 1;

    if ($is_admin || $is_global_admin) {

      if ($ticket_id > 0) { // delete existing ticket
        
        Ticket::where([
          ["id", "=", $ticket_id],
          ["venue_id", "=", $venue_id],
        ])->delete();

      }

      return response()->json(array(
        "id" => $ticket_id
      ));
    } else {
      return response("Unauthorized", 401);
    }
  }
}
