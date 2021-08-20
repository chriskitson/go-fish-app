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

  function search($date, $location) {
    $results = array(
      $date,
      $location
    );
    return response()->json($results);
  }

}
