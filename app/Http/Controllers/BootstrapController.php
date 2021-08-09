<?php

namespace App\Http\Controllers;

use App\Models\Venue;

class BootstrapController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function load()
    {
      $venues = Venue::get();
      return response()->json(array(
        "venues" => $venues
      ));

    }
    
}
