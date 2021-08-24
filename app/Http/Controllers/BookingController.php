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

  public function book($venue_id, $ticket_id, $date)
  {

    // TODO - this will be authenicated by user id
    $user_id = 1;
    $date = gmdate("Y-m-d", $date / 1000);

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
      ])->whereDate('created_at', $date)->get());

     // count number of user bookings
      $user_bookings = count(Booking::where([
        ['ticket_id', '=', $ticket_id],
        ['user_id', '=', $user_id]
      ])->whereDate('created_at', $date)->get());

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

  }
}
