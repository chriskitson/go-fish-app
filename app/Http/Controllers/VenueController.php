<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use App\Models\VenueClosed;
use App\Models\Category;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Booking;
use App\Models\SearchCache;
use App\Models\RequestCache;
use App\Http\Traits\GoogleMapTrait;
use App\Http\Traits\BookingTrait;
use App\Http\Traits\StripeTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class VenueController extends Controller
{

  use GoogleMapTrait;
  use BookingTrait;
  use StripeTrait;

  public $USE_GOOGLE = False;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->USE_GOOGLE = env('GOOGLE_ENABLE', False);
  }

  public function check_in_range($start_date, $end_date, $date)
  {
    // Convert to timestamp
    $start = strtotime($start_date);
    $end = strtotime($end_date);
    $check = strtotime($date);

    // Check that user date is between start & end
    return (($start <= $check) && ($check <= $end));
  }

  public function clear_cache()
  {
    SearchCache::truncate();
    RequestCache::truncate();
  }

  public function clean_web($str)
  {
    $str = str_replace("\\n", "<br/>", $str);
    $str = str_replace("\n", "<br/>", $str);
    $str = str_replace("’", "'", $str);
    return $str;
  }

  public function clean_admin($str)
  {
    // https://www.thorntech.com/2012/07/4-things-you-must-do-when-putting-html-in-json/
    $str = str_replace("\n", "\\n", $str);
    $str = str_replace("<br/>", "\\n", $str);
    $str = str_replace("/", "\/", $str);
    $str = str_replace("’", "'", $str);
    return $str;
  }

  public function get_day($day)
  {
    $days_of_week = array('sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday');
    return $days_of_week[$day];
  }

  public function all()
  {
    $venues = Venue::orderBy("name", "ASC")->where([["deleted", "=", 0]])->get()->toarray();
    return response()->json($venues);
  }

  public function names()
  {
    $venues = Venue::orderBy("name", "ASC")->where([["deleted", "=", 0]])->get(["id", "name"]);
    return response()->json($venues);
  }

  public function manage_venues(Request $request)
  {
    $user = $request->user();
    $is_global_admin = $user->global_admin == 1;
    $venues = [];
    if ($is_global_admin) {
      $venues = Venue::orderBy("name", "ASC")->where([["deleted", "=", 0]])->get();
      foreach ($venues as $v) {
        $v->claimed =  $v->claimed;
        $v->claimed_user =  $v->claimed_user;
        $v->payment_active =  $v->payment_active;
      }
      $venues = array_map(function ($v) {
        return array(
          "id" => $v["id"],
          "name" => $v["name"],
          "claimed" => $v["claimed"],
          "claimed_user" => $v["claimed_user"],
          "payment_active" => $v["payment_active"],
        );
      }, $venues->toArray());
    }
    return response()->json($venues);
  }

  public function get($id)
  { // for front end website display
    $venue = Venue::find($id, ["id", "name", "address", "phone", "description", "rules", "image", "place_id", "place_data_updated", "rating"]);
    // is venue managed?
    $venue_user = User::where("venue_id", "=", $venue->id);
    $venue_managed = $venue_user->count() > 0 && $venue_user->first()->hasVerifiedEmail();
    // clean up fields for display
    $venue->description = $this->clean_web($venue->description);
    $venue->rules = $this->clean_web($venue->rules);
    
    // get reviews and photos (cached in db)
    $venue_data = Venue::find($id, ["photos", "reviews"]);
    $venue->photos = json_decode($venue_data->photos);
    $venue->reviews = json_decode($venue_data->reviews);

    $venue["managed"] = $venue_managed;
    $venue["ticket_count"] = Ticket::where([
      ["venue_id", "=", $venue->id]
    ])->count();
    return response()->json($venue);
  }

  public function get_detail($id)
  { // for admin display
    $venue = Venue::find($id);
    $venue->description = $this->clean_admin($venue->description);
    $venue->rules = $this->clean_admin($venue->rules);
    if ($venue->account_payment_confirmed == 1 && isset($venue->account_payment_reference) && $venue->account_payment_reference !== "") { // has active subscription
      // get subscription details from stripe
      $subscription_confirmed = true;
      $subscription_amount = ($this->get_gofish_subscription($venue->account_payment_reference)->plan->amount / 100);
    } else {
      $subscription_confirmed = false;
      $subscription_amount = null;
    }
    $fields = array(
      "id" => $venue->id,
      "name" => $venue->name,
      "image" => $venue->image,
      "address" => $venue->address,
      "phone" => $venue->phone,
      "description" => $venue->description,
      "place_id" => $venue->place_id,
      "rules" => $venue->rules,
      "account" => $venue->account,
      "subscription" => array(
        "confirmed" => $subscription_confirmed,
        "reference" => $venue->account_payment_reference,
        "type" => $venue->subscription,
        "amount" => $subscription_amount
      ),
      "days" => array(
        "sunday" => $venue->open_sunday == 1,
        "monday" => $venue->open_monday == 1,
        "tuesday" => $venue->open_tuesday == 1,
        "wednesday" => $venue->open_wednesday == 1,
        "thursday" => $venue->open_thursday == 1,
        "friday" => $venue->open_friday == 1,
        "saturday" => $venue->open_saturday == 1
      )
    );
    return response()->json($fields);
  }

  public function get_closures($id)
  { // for admin display
    $closed = VenueClosed::where([
      ["venue_id", "=", $id]
    ])->orderBy("start_date", "ASC")->get(["id", "start_date", "end_date"]);
    return response()->json($closed);
  }

  public function get_tickets_detail($id)
  {
    $tickets = Ticket::where([
      ["venue_id", "=", $id]
    ])->get()->toArray();
    $tickets = array_map(function ($t) {
      $t["name"] = $this->clean_admin($t["name"]);
      $t["description"] = $this->clean_admin($t["description"]);
      return $t;
    }, $tickets);
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
    $date_day_of_week = intval(gmdate("w", $request->input("d") / 1000));
    $date_day_of_week = $this->get_day($date_day_of_week);

    // is the venue closed on this date?
    $closed_ranges = VenueClosed::where([
      ["venue_id", "=", $id]
    ])->get();

    $closed = false;

    foreach ($closed_ranges as $range) {
      if (!$closed && $this->check_in_range($range->start_date, $range->end_date, $date)) {
        $closed = true;
      }
    }

    if ($closed) {
      return response()->json([]);
    }

    // get all available ticket types
    $tickets = Ticket::join("venues", "tickets.venue_id", "venues.id")->where([
      ["venue_id", "=", $id],
      ["open_" . $date_day_of_week, "=", True]
    ])->orderBy("name", "ASC")->get(["tickets.id", "tickets.name", "tickets.description", "tickets.cost", "tickets.daily_limit", "venue_id"]);

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
    return $this->USE_GOOGLE === True ? $this->get_town($place_id, "place_id") : "";
  }

  function search($date, $location)
  {

    $date = gmdate("Y-m-d", $date / 1000);
    $date_day_of_week = intval(gmdate("w", strtotime($date)));
    $date_day_of_week = $this->get_day($date_day_of_week);

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
    
    } elseif ($this->USE_GOOGLE === True) { // look up location based data search results

      // get search by place_id
      $search = $this->get_address($location, "place_id");

      // get all venues
      $venues = Venue::where([
        ["place_id", "!=", ""],
        ["deleted", "=", 0],
        ["active", "=", 1]
      ])->get(["id", "name", "place_id", "image", "rating", "photos"]);

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
        if (isset($distances[$index]["distance"])) {
          $venue->distance = $distances[$index]["distance"]["value"];
          $venue->distanceDisplay = $distances[$index]["distance"]["text"];
        } else {
          $venue->distance = "999999999999";
          $venue->distanceDisplay = "Unknown";
        }
      });

      // convert to array, filter  and sort
      $results = $venues->toArray();

      // map venues to display fields
      $results = array_map(function ($v) {
        $image = "#";
        // use google photos if image missing
        if ((!isset($v["image"]) || $v["image"] === "") && isset($v["photos"]) && $v["photos"] !== "") {
          $photos = json_decode($v["photos"]);  // pull from google photos
          if (isset($photos) && count($photos) > 0) {
            $image = $photos[0]->url;
          }
        } else {
          $image = $v["image"];
        }
        return array(
          "id" => $v["id"],
          "name" => $v["name"],
          "image" => $image,
          "rating" => $v["rating"],
          "distance" => $v["distance"],
          "place_id" => $v["place_id"],
          "distanceDisplay" => $v["distanceDisplay"]
        );
      }, $results);

      $results = array_filter($results, function ($v) {
        return $v["distance"] < env("SEARCH_DISTANCE_LIMIT", 0);
      });
      // sort by distance
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
    
    } else {  // no access to Google or cache, so no results returned
      $search = "";
      $results = [];
    }

    if (count($results) > 0) {

      foreach ($results as $result) {

        if (isset($result)) {

          $venue_id = $result->id;

          // check tickets
          $tickets = Ticket::join("venues", "tickets.venue_id", "venues.id")->where([
            ["venue_id", "=", $venue_id],
            ["open_" . $date_day_of_week, "=", True]
          ])->get("tickets.*")->filter(function ($ticket) use ($date) {
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

      // sort by tickets available
      // usort($results, function ($a, $b) {
      //   return (count($a->tickets) > 0) < (count($b->tickets) > 0);
      // });
    }

    // clean results
    $results = array_map(function ($result) {
      $result->name = $this->clean_web($result->name);
      $result->tickets = array_map(function ($ticket) {
        $ticket["name"] = $this->clean_web($ticket["name"]);
        $ticket["description"] = $this->clean_web($ticket["description"]);
        return $ticket;
      },  $result->tickets);
      return $result;
    }, (array) $results);

    return response()->json(array(
      "results" => $results,
      "search" => $search,
      "limit" => env("SEARCH_DISTANCE_LIMIT", 2000),
      "cached" => !$cache_exists
    ));
  }

  public function delete(Request $request, $id)
  {
    $user = $request->user();
    $is_global_admin = $user->global_admin == 1;

    if ($is_global_admin && $id > 0) { // soft delete venue

      Venue::where([
        ["id", "=", $id]
      ])->update(array(
        "deleted" => 1
      ));

      // clear cached requests
      $this->clear_cache();

      return response()->json(array(
        "id" => $id
      ));
    } else {
      return response("Unauthorized", 401);
    }
  }

  public function create_venue(Request $request)
  {
    $user = $request->user();
    $is_global_admin = $user->global_admin == 1;

    if ($is_global_admin) {

      $validators = [
        "name" => ["required", "string"],
        "description" => ["required", "string"],
        // "account" => ["required", "string"],
        "image" => ["required", "string"],
        "rules" => ["required", "string"],
        "address" => ["required", "string", "max:255"],
        "phone" => ["required", "string", "max:45"],
        "place_id" => ["required", "string", "max:45"],
      ];

      $validator = Validator::make($request->all(), $validators);

      if ($validator->fails()) {
        $error_response = $validator->messages();
        return response()->json($error_response, 400);
      }

      $fields = array(
        "name" => $request->name,
        "description" => $request->description,
        "rules" => $request->rules,
        "address" => $request->address,
        "phone" => $request->phone,
        "place_id" => $request->place_id,
        "image" => $request->image,
        "account" => $request->account,
        "open_sunday" => $request->open_sunday,
        "open_monday" => $request->open_monday,
        "open_tuesday" => $request->open_tuesday,
        "open_wednesday" => $request->open_wednesday,
        "open_thursday" => $request->open_thursday,
        "open_friday" => $request->open_friday,
        "open_saturday" => $request->open_saturday
      );

      $venue = new Venue($fields);
      $venue->save();
      $venue_id = $venue->id;

      Venue::where([
        ["id", "=", $venue_id],
        ["deleted", "=", 0]
      ])->update($fields);

      // clear cached requests
      $this->clear_cache();

      return response()->json(Venue::find($venue_id, ["id", "name", "description", "rules", "address", "phone", "place_id"]));
    } else {
      return response("Unauthorized", 401);
    }
  }

  public function manage_details(Request $request, $venue_id)
  {

    $user = $request->user();
    $is_admin = $user->user_type == 2 && $user->venue_id == $venue_id;
    $is_global_admin = $user->global_admin == 1;
    $is_verified =  $user->hasVerifiedEmail();
    if (($is_admin && $is_verified) || $is_global_admin) {

      $validators = [
        "name" => ["required", "string"],
        "description" => ["required", "string"],
        "rules" => ["required", "string"],
        "address" => ["required", "string", "max:255"],
        "phone" => ["required", "string", "max:45"],
        "place_id" => ["required", "string", "max:45"],
      ];

      // if ($is_global_admin) {
      //   $validators = array_merge($validators,  [
      //     "account" => ["required", "string"],
      //   ]);
      // }

      $validator = Validator::make($request->all(), $validators);

      if ($validator->fails()) {
        $error_response = $validator->messages();
        return response()->json($error_response, 400);
      }

      $fields = [
        "name" => $request->name,
        "description" => $request->description,
        "rules" => $request->rules,
        "address" => $request->address,
        "phone" => $request->phone,
        "place_id" => $request->place_id,
        "open_sunday" => $request->open_sunday,
        "open_monday" => $request->open_monday,
        "open_tuesday" => $request->open_tuesday,
        "open_wednesday" => $request->open_wednesday,
        "open_thursday" => $request->open_thursday,
        "open_friday" => $request->open_friday,
        "open_saturday" => $request->open_saturday
      ];

      if ($is_global_admin) {
        $fields = array_merge($fields,  [
          "account" => $request->account
        ]);
      }

      Venue::where([
        ["id", "=", $venue_id]
      ])->update($fields);

      // clear cached requests
      $this->clear_cache();

      return response()->json(Venue::find($venue_id, ["name", "description", "account", "rules", "address", "phone", "place_id"]));
    } else {
      return response("Unauthorized", 401);
    }
  }

  public function manage_ticket(Request $request, $venue_id)
  {

    $user = $request->user();
    $is_admin = $user->user_type == 2 && $user->venue_id == $venue_id;
    $is_global_admin = $user->global_admin == 1;

    if ($is_admin || $is_global_admin) {

      $validators = [
        "id" => ["required", "integer"],
        "name" => ["required", "string", "max:255"],
        "description" => ["required", "string", "max:255"],
        "daily_limit" => ["required", "integer"],
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
    $is_admin = $user->user_type == 2 && $user->venue_id == $venue_id;
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

  public function upload_image(Request $request, $venue_id)
  {

    $user = $request->user();
    $is_admin = $user->user_type == 2 && $user->venue_id == $venue_id;
    $is_global_admin = $user->global_admin == 1;

    if ($is_admin || $is_global_admin) {

      $validator = Validator::make($request->all(), [
        'image' => 'required|image:jpeg,png,jpg,gif,svg|max:2048'
      ]);

      if ($validator->fails()) {
        return response("Invalid image", 400);
      }

      $upload_folder = 'venues';
      $image = $request->file('image');
      $image_uploaded_path = $image->store($upload_folder, 'public');
      $image_url = Storage::disk('public')->url($image_uploaded_path);

      // update database
      Venue::where([
        ["id", "=", $venue_id]
      ])->update(array(
        "image" => $image_url
      ));

      $image_response = array(
        "image_name" => basename($image_uploaded_path),
        "image_url" => $image_url,
        "mime" => $image->getClientMimeType()
      );

      return response($image_response, 200);
    } else {
      return response("Unauthorized", 401);
    }
  }

  public function delete_image(Request $request, $venue_id)
  {

    $user = $request->user();
    $is_admin = $user->user_type == 2 && $user->venue_id == $venue_id;
    $is_global_admin = $user->global_admin == 1;

    if ($is_admin || $is_global_admin) {

      Venue::where([
        ["id", "=", $venue_id]
      ])->update(array(
        "image" => ""
      ));
    } else {
      return response("Unauthorized", 401);
    }
  }

  public function get_category_detail($id)
  {
    // is it numerical?
    if (is_numeric($id)) {
      $category = Category::find($id, ["id", "name", "image"]);
    } else {
      if ($id === "latest") {
        $category = array(
          "id" => "latest",
          "name" => "Latest Fisheries",
          "image" => "/images/bg1.jpg"
        );
      } elseif ($id === "best") {
        $category = array(
          "id" => "best",
          "name" => "Best Fisheries",
          "image" => "/images/bg1.jpg"
        );
      } elseif ($id === "near") {
        $category = array(
          "id" => "near",
          "name" => "Fisheries Near Me",
          "image" => "/images/bg1.jpg"
        );
      }
    }
    return response()->json($category);
  }

  public function get_categories()
  {
    // used for footer links
    $categories = Category::inRandomOrder()->limit(10)->get(["id", "name"]);
    return response()->json($categories);
  }

  public function get_category($id)
  {

    if (is_numeric($id)) { // location based

      $category = Category::find($id, ["key", "value", "results", "results_updated"]);

      if (isset($category)) {

        $category_key = $category->key;
        $category_value = $category->value;

        // are results older than cache amount
        if (time() - strtotime($category->results_updated) > $_ENV["CACHE_CATEGORIES"] && env('OFFLINE_MODE', True) === False) {

          // get all venues
          $venues = Venue::where([
            ["place_id", "!=", ""],
            ["deleted", "=", 0]
          ])->get(["id", "name", "address", "phone", "place_id", "image", "place_meta", "rating", "photos"])->toArray();

          // loop through all venues
          foreach ($venues as $venue) {
            // check if meta exist (if not, then fetch and save for future use)
            if ((!isset($venue->place_meta) || $venue->place_meta === "") && $this->USE_GOOGLE === True) {
              $place_meta = json_encode($this->get_address_data($venue["place_id"], "place_id"));
              $venue["place_meta"] = $place_meta;
              Venue::where([
                ["id", "=", $venue["id"]]
              ])->update(array(
                "place_meta" => $place_meta
              ));
            }
          }

          // filter venues based on location category
          $venues = array_filter($venues, function ($venue) use ($category_key, $category_value) {
            $place_meta = json_decode($venue["place_meta"]);
            if (isset($place_meta) && $place_meta !== "") {
              $place_component_match = current(array_filter($place_meta->address_components, function ($component) use ($category_key) {
                return in_array($category_key, $component->types);
              }));
            } else {
              $place_component_match = null;
            }
            if ($place_component_match) {
              return $place_component_match->long_name === $category_value;
            } else {
              return false;
            }
          });

          // cache results
          Category::find($id)->update(array(
            "results" => json_encode($venues),
            "results_updated" => Carbon::now()
          ));
        } else {

          // use cached results 
          $venues = json_decode($category->results);
        }
      } else {
        $venues = [];
      }
    } else {
      if ($id === "latest") {
        $venues = Venue::orderBy("created_at", "desc")->limit(12)->where([["deleted", "=", 0], ["active", "=", 1]])->get(["id", "name", "image", "rating", "photos"])->toArray();   // select 12 random venues
      } elseif ($id === "best") {
        $venues = Venue::orderBy("rating", "desc")->limit(12)->where([["deleted", "=", 0], ["active", "=", 1]])->get(["id", "name", "image", "rating", "photos"])->toArray();   // select 12 rating
      } else {
        $venues = []; // return done, browser will fetch with client location
      }
    }

    // map venues to display fields
    $venues = array_map(function ($v) {
      $image = "#";

      $v = (array)$v;

      // use google photos if image missing
      if ((!isset($v["image"]) || $v["image"] === "") && isset($v["photos"]) && $v["photos"] !== "") {
        $photos = json_decode($v["photos"]);  // pull from google photos
        if (isset($photos) && count($photos) > 0) {
          $image = $photos[0]->url;
        }
      } else {
        $image = $v["image"];
      }
      return array(
        "id" => $v["id"],
        "name" => $v["name"],
        "image" => $image,
        "rating" => $v["rating"]
      );
    }, (array)$venues);
    return response()->json($venues);
  }

  public function closed_add(Request $request, $id)
  {

    $user = $request->user();
    $is_admin = $user->user_type == 2 && $user->venue_id == $id;
    $is_global_admin = $user->global_admin == 1;

    if ($is_admin || $is_global_admin) {

      $validators = [
        "start" => ["required", "date"],
        "end" => ["required", "date"]
      ];

      $validator = Validator::make($request->all(), $validators);

      if ($validator->fails()) {
        $error_response = $validator->messages();
        return response()->json($error_response, 400);
      }

      $date_range = new VenueClosed([
        "venue_id" =>  $id,
        "start_date" => $request->start,
        "end_date" => $request->end
      ]);

      $date_range->save();

      return response()->json(VenueClosed::find($date_range->id, ["id", "start_date", "end_date"]));
    } else {
      return response("Unauthorized", 401);
    }
  }

  public function closed_delete(Request $request, $venue_id, $id)
  {
    $user = $request->user();
    $is_admin = $user->user_type == 2 && $user->venue_id == $venue_id;
    $is_global_admin = $user->global_admin == 1;

    if ($is_admin || $is_global_admin) {

      VenueClosed::where([
        ["id", "=", $id],
        ["venue_id", "=", $venue_id],
      ])->delete();
    } else {
      return response("Unauthorized", 401);
    }
  }

  public function near(Request $request)
  {

    $lat = $request->input('latitude');
    $lng = $request->input('longitude');
    $o = $request->input('o');

    $venues_array = [];
    $town = "";

    // get all venues
    $venues = Venue::where([["deleted", "=", 0], ["active", "=", 1]])->get(["id", "name", "address", "phone", "place_id", "image", "photos", "rating"]);

    // determine location based on lat lng
    if ($this->USE_GOOGLE === True && isset($o) || (isset($lat) && isset($lng))) {

      // set origin
      $origin = isset($o) ? $o : $lat . "," . $lng;

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
    } else {   // bring back random venues as we don't know location (no access to Google)

      $venues_array = array_map(function ($v) use ($venues) {
        return $venues[$v];
      }, array_rand($venues->toArray(), 12));
    }
    // map venues to display fields
    $venues_array = array_map(function ($v) {
      $image = "#";
      // use google photos if image missing
      if ((!isset($v["image"]) || $v["image"] === "") && isset($v["photos"]) && $v["photos"] !== "") {
        $photos = json_decode($v["photos"]);  // pull from google photos
        if (isset($photos) && count($photos) > 0) {
          $image = $photos[0]->url;
        }
      } else {
        $image = $v["image"];
      }
      return array(
        "id" => $v["id"],
        "name" => $v["name"],
        "image" => $image,
        "rating" => $v["rating"]
      );
    }, $venues_array);
    return response()->json(array(
      "venues" => $venues_array,
      "town" => $town,
    ));
  }

  public function account_create(Request $request, $id)
  {
    $user = $request->user();
    $is_admin = $user->user_type == 2 && $user->venue_id == $id;
    $is_global_admin = $user->global_admin == 1;
    $venue_id = $user->venue_id;
    $user_email = $user->email;

    if ($is_admin || $is_global_admin && ($venue_id === $id)) {

      // get venue info
      $venue = Venue::find($venue_id);
      $venue_name = $venue->name;
      $account_id = $venue->account;

      // create stripe connected account for receiving payments (if one doesn't exist)
      if (!isset($account_id) || $account_id === "") {
        $account_id = $this->connected_account_create($user_email, $venue_name);
      }

      // generate stripe signup link for account (to provide bank details for payments to fishery)
      $account_link = $this->connected_account_link_create($venue_id, $account_id);

      // update venue with stripe info
      Venue::where([
        ["id", "=", $venue_id]
      ])->update(array(
        "account_link" => $account_link,
        "account" => $account_id
      ));

      return response()->json(array(
        "success" => true,
        "venue_id" => $venue_id,
        "accountLink" => $account_link,
        "account" => $account_id
      ));
    } else {
      return response("Unauthorized", 401);
    }
  }


  public function subscription_create(Request $request, $id)
  {

    $user = $request->user();
    $is_admin = $user->user_type == 2 && $user->venue_id == $id;
    $is_global_admin = $user->global_admin == 1;
    $venue_id = $user->venue_id;
    $user_email = $user->email;

    if ($is_admin || $is_global_admin && ($venue_id === $id)) {

      // create stripe subscription checkout session (for monthly fee to GOFish)
      $checkout_session_id = $this->create_gofish_subscription(env("STRIPE_SUBSCRIPTION_PRODUCT_LITE"), $venue_id, $user_email);

      // get venue info
      $venue = Venue::find($venue_id);
      $venue_name = $venue->name;
      $account_id = $venue->account;

      // create stripe connected account for receiving payments (if one doesn't exist)
      if (!isset($account_id) || $account_id === "") {
        $account_id = $this->connected_account_create($user_email, $venue_name);
      }

      // generate stripe signup link for account (to provide bank details for payments to fishery)
      $account_link = $this->connected_account_link_create($venue_id, $account_id);

      // update venue with stripe info
      Venue::where([
        ["id", "=", $venue_id]
      ])->update(array(
        "checkout_session" => $checkout_session_id,
        "account_link" => $account_link,
        "account" => $account_id
      ));

      return response()->json(array(
        "success" => true,
        "session_id" => $checkout_session_id  // create session for subscription
      ));
    } else {
      return response("Unauthorized", 401);
    }
  }

  public function subscription_cancel(Request $request, $id)
  {
    $user = $request->user();
    $is_admin = $user->user_type == 2 && $user->venue_id == $id;
    $is_global_admin = $user->global_admin == 1;
    $venue_id = $user->venue_id;

    if ($is_admin || $is_global_admin && ($venue_id === $id)) {

      // cancel subscription
      $venue = Venue::find($venue_id);
      $subscription = $venue->account_payment_reference;

      // update venue
      $venue->update([
        "account_payment_confirmed" => 0,
        "account_payment_reference" => ""
      ]);

      $this->cancel_gofish_subscription($subscription); // cancel stripe subscription

      return response()->json(array(
        "success" => true,
        "session_id" => $subscription
      ));
    } else {
      return response("Unauthorized", 401);
    }
  }
}
