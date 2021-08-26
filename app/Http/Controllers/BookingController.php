<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Booking;
use App\Models\Venue;
use Illuminate\Http\Request;
use App\Http\Traits\BookingTrait;
use App\Http\Traits\StripeTrait;

class BookingController extends Controller
{

  use BookingTrait;
  use StripeTrait;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
  }

  public function book(Request $request, $venue_id, $ticket_id, $date)
  {

    $user = $request->user();
    $user_id = $user->id;

    $date = gmdate("Y-m-d", $date / 1000);
    $url = $request->url;

    // get ticket info
    $ticket = Ticket::where([
      ['venue_id', '=', $venue_id],
      ['id', '=', $ticket_id]
    ])->get(["daily_limit", "cost", "name"])->first();

    if (isset($ticket)) {

      // get daily limit
      $daily_limit = $ticket->daily_limit;

      // count number of bookings
      $bookings = count(Booking::where([
        ['ticket_id', '=', $ticket_id],
        ['confirmed', true]
      ])->whereDate('created_at', $date)->get());

      // count number of user bookings
      $user_bookings = count(Booking::where([
        ['ticket_id', '=', $ticket_id],
        ['user_id', '=', $user_id],
        ['confirmed', true]
      ])->whereDate('created_at', $date)->get());

      if ($daily_limit > 0 && $daily_limit > $bookings) {

        // get venue info
        $venue = Venue::where([
          ['id', '=', $venue_id],
        ])->get(["name", "account"])->first();

        // generate stripe session for payments
        $payment_session = $this->create_checkout_session("GBP", $ticket->cost * 100, $venue->name . ": " . $ticket->name, "", $venue->account, $url);

        // write booking to DB
        $booking = new Booking([
          "ticket_id" => $ticket_id,
          "user_id" => 1,
          "session" => $payment_session
        ]);
        $booking->save();

        // is there still availability after this booking?
        $many_left = $daily_limit - $bookings;

        // get status message
        $status = $this->get_booking_status($user_bookings, $many_left);

        return response()->json(array(
          "success" => true,
          "booking_id" => intval($booking->id),
          "availability" => $many_left > 0,
          "ticket_id" => intval($ticket_id),
          "status" => $status,
          "user" => $user_bookings,
          "session_id" => $payment_session
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
