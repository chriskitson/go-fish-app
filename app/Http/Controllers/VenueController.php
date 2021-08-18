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
        "name" => "Day Ticket (4 fish catch)",
        "cost" => 130
      ),
      array(
        "id" => 2,
        "name" => "Day Ticket (3 fish catch)",
        "cost" => 115
      ),
      array(
        "id" => 3,
        "name" => "2 fish ticket, Half Day. From 08.00 – 13.00hrs",
        "cost" => 100
      ),
      array(
        "id" => 4,
        "name" => "Catch & release ticket on Stillwaters Lake only. *Barbless hooks only.",
        "cost" => 75
      ),
      array(
        "id" => 5,
        "name" => "Carrier Only. Trout season 3rd April – 30th September. (All fish returned to river)",
        "cost" => 80
      )
    );
    return response()->json($tickets);
  }
}
