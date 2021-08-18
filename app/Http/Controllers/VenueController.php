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
}
