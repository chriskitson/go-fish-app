<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venue;
use App\Models\Category;
use App\Models\User;
use App\Models\RequestCache;
use App\Models\SearchCache;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

use App\Http\Traits\GoogleMapTrait;
use App\Http\Traits\StripeTrait;

class BootstrapController extends Controller
{

    use GoogleMapTrait;
    use StripeTrait;

    public $USE_GOOGLE = False;

    public function __construct()
    {
        // $this->USE_GOOGLE = env('GOOGLE_ENABLE', False);
        $this->USE_GOOGLE = False;
    }

    private function split_name($name)
    {
        $name = trim($name);
        $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
        $first_name = trim(preg_replace('#' . $last_name . '#', '', $name));
        return array($first_name, $last_name);
    }

    public function cache_bust(Request $request)
    {
        $user = $request->user();
        $is_global_admin = $user->global_admin == 1;
        if ($is_global_admin) {
            RequestCache::truncate();
            SearchCache::truncate();
            Category::where([
                ["results", "!=", ""]
            ])->update([
                "results" => "",
                "results_updated" => null
            ]);
            return response("Busted!", 200);
        } else {
            return response("Unauthorized", 401);
        }
    }

    public function load(Request $request)
    {

        $c = $request->input('c');
        $lat = $request->input('latitude');
        $lng = $request->input('longitude');

        $town = "";
        $origin = "";

        $response = (object)[];

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
            $venues = Venue::where([["deleted", "=", 0], ["visible", "=", 1]])->get(["id", "name", "address", "place_id", "image", "rating", "photos", "active"]);

            // determine location based on lat lng if supplied
            if ($this->USE_GOOGLE === True && isset($lat) && isset($lng)) {

                // TODO - removed due to load on requests

                // // set origin
                // $origin = $lat . "," . $lng;

                // // set destinations
                // $destinations = $venues->map(function ($venue) {
                //   return 'place_id:' . $venue->place_id;
                // })->toArray();

                // // calculate distances
                // $distances = $this->calculate_distances($origin, $destinations);

                // // set distances on venue collection, then convert to array
                // $venues->map(function ($venue, $index) use ($distances) {
                //   $venue->distance = isset($distances[$index]["distance"]) ? $distances[$index]["distance"]["value"] : 0;
                //   $venue->distanceDisplay = isset($distances[$index]["distance"]) ? $distances[$index]["distance"]["text"] : "";
                // });

                // // convert to array and sort
                // $venues_array = $venues->toArray();
                // usort($venues_array, function ($a, $b) {
                //   return $a["distance"] > $b["distance"];
                // });

                // // get user town
                // $town = $this->get_town($origin);

                // // generate cache id
                // $cache_id = Str::uuid();

                // // create response array
                // $response = (object) array(
                //   "venues" => array_slice($venues_array, 0, 4),
                //   "userPosition" => array(
                //     "latitude" => $lat,
                //     "longitude" => $lng,
                //     "town" => $town,
                //     "origin" => $lat . "," . $lng
                //   ),
                //   "token" => $cache_id,
                // );

                // // write to cache expiring in 1 week
                // $cache = new RequestCache([
                //   "id" => $cache_id,
                //   "data" => json_encode($response),
                //   "expires" => date('Y-m-d', strtotime(env('CACHE_EXPIRES', '+1 week')))
                // ]);
                // $cache->save();

            } else {  // bring back random venues as we don't know location

                $venues_random = array_map(function ($v) use ($venues) {
                    return $venues[$v];
                }, array_rand($venues->toArray(), 4));

                $response = (object) array(
                    "venues" => $venues_random,  // return random
                    "userPosition" => null,
                    "token" => null
                );
            }
        }

        if (Auth::check()) {
            $user = $request->user();
            // store location details against user account
            if ($town !== "" && $origin !== "") {
                User::find($user->id)->update([
                    "town" => $town,
                    "origin" => $origin
                ]);
            }
        }

        // add location based categories
        $parent_id = $request->input('parent_id');
        $categories_query = Category::query();

        if (isset($parent_id) && is_numeric($parent_id)) {
            $categories_query->forParent($parent_id);
        } else {
            $categories_query->inRandomOrder()->limit(4);
        }

        $response->categories = $categories_query->get(["id", "name", "image", "parent_id"])->toArray();
        $response->allCategories = Category::where('key', 'administrative_area_level_1')->orderBy('name', 'ASC')->get(["id", "name"])->toArray();

        $response->stripe = array(
            "percentage" => env('STRIPE_PERCENTAGE_FEE'),
            "fixed" => env('STRIPE_FIXED_FEE'),
            "currency" => env('CURRENCY')
        );

        return response()->json($response);
    }

    public function user(Request $request)
    {

        $response = (object)[];

        if (Auth::check()) {
            $user = $request->user();
            $name = $this->split_name($user->name);
            $response->user = array(
                "userType" => $user->user_type,
                "globalAdmin" => $user->global_admin === 1,
                "verified" =>  $user->global_admin === 1 ? true : $user->hasVerifiedEmail(),
                "email" => $user->email,
                "firstName" => $name[0],
                "lastName" => $name[1],
            );
            // if user is fishery owner then return venue indo
            if ($user->user_type === 2 && $user->venue_id != '') {
                // look up venue for user and return first
                $venue = Venue::find($user->venue_id, ["id", "name"]);
                $response->user["venue"] = $venue;
            }
        } else {
            $response->user = array(
                "userType" => 0,
                "globalAdmin" => false,
                "verified" => false,
                "email" => "",
                "firstName" => "",
                "lastName" => ""
            );
        }

        return response()->json($response);
    }
}
