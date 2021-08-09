<?php

namespace App\Http\Controllers;

use App\Models\Venue;

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
      // $data = Venue::paginate(500);
      // if($data){
      //   $response['message'] = 'Data Found Successfully';
      //    $response['status'] = 200;
      // }else{
      //   $response['message'] = 'Data Not Found';
      //    $response['status'] = 404;
      // }
      // $response['data'] = $data;
      // return response()->json($response);

      $data = Venue::get();
      return response()->json($data);

    }
    
}
