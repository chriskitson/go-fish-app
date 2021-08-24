<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Booking;
use App\Http\Traits\BookingTrait;

class BookingController extends Controller
{

  use BookingTrait;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
  }

  public function book($venue_id, $ticket_id)
  {

    // TODO - this will be authenicated by user id
    $user_id = 1;

    // get ticket info
    $ticket = Ticket::where([
      ['venue_id', '=', $venue_id],
      ['id', '=', $ticket_id]
    ])->get(["daily_limit"])->first();

    if (isset($ticket)) {
      
      // get daily limit
      $daily_limit = $ticket->daily_limit;

      // count number of bookings
      $bookings = count(Booking::where([
        ['ticket_id', '=', $ticket_id]
      ])->get());

     // count number of user bookings
      $user_bookings = count(Booking::where([
        ['ticket_id', '=', $ticket_id],
        ['user_id', '=', $user_id]
      ])->get());

      if ($daily_limit > 0 && $daily_limit > $bookings) {

        // write booking to DB
        $booking = new Booking([
          "ticket_id" => $ticket_id,
          "user_id" => 1
        ]);
        $booking->save();

        // is there still availability after this booking?
        $many_left = $daily_limit - ($bookings + 1);

        // get status message
        $status = $this->get_booking_status($user_bookings + 1, $many_left);

        return response()->json(array(
          "success" => true,
          "booking_id" => intval($booking->id),
          "availability" => $many_left > 0,
          "ticket_id" => intval($ticket_id),
          "status" => $status,
          "user" => ($user_bookings + 1)
        ));

      } else {
        return response()->json(array(
          "success" => false,
          "avaiability" => false
        ));
      }
    } else {  // no availability

      return response()->json(array(
        "success" => false
      ), 404);

    }





    // // set avaibility based on bookings
    // $tickets = $tickets->map(function ($ticket) {

    //   // count number of existing bookings


    //   // set avaibility
    //   $ticket["availability"] = $ticket["daily_limit"] > 0 && $ticket["daily_limit"] > $bookings;

    //   return $ticket;
    // })->toArray();

    //   // write to cache expiring in 1 week
    //   $cache = new SearchCache([
    //     "id" => $location,
    //     "search" => $search,
    //     "data" => json_encode($results),
    //     "expires" => date('Y-m-d', strtotime(env('CACHE_EXPIRES', '+1 week')))
    //   ]);
    //   $cache->save();


    // return response()->json($tickets);
  }
}
