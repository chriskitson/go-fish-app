<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use Illuminate\Support\Facades\Http;

class VenueController extends Controller
{
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


    $venues = Venue::all();

    // $venues->map(function ($venue) {

    //   // use google apis
    //   $key = "AIzaSyCsdU2LNn340yztbnjNhjYDeg2Gd4S3x40";
    //   $search = urlencode($venue->name);
    //   $response = Http::get("https://maps.googleapis.com/maps/api/place/nearbysearch/json?key=" . $key . "&sensor=false&location=55.021245699999994,-6.495662599999999&radius=147022&keyword=" . $search);

    //   // get place_id
    //   if (isset($response->json()["results"]) && count($response->json()["results"]) > 0) {
    //     $venue->place_id = $response->json()["results"][0]["place_id"];
    //   } else {
    //     echo $venue->name;
    //   }

    //   $venue->save();
    // });




    return response()->json($venues);
  }
}
