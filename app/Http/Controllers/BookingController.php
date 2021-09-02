<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Booking;
use App\Models\Venue;
use App\Models\Basket;
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

  public function book(Request $request)
  {

    $user = $request->user();
    $user_id = $user->id;
    $url = $request->url;

    // get tickets from user basket
    $items = Basket::where([
      ['user_id', '=', $user_id]
    ])->get();

    // array to hold booking responses
    $booking_responses = [];
    $booking_success = true;

    // loop through tickets and attempt to create a ticket for each
    foreach ($items as $item) {

      // $date = gmdate("Y-m-d", $date / 1000);
      $date = $item->date;
      $ticket_id = $item->ticket_id;
      $venue_id = $item->venue_id;
      $qty = $item->qty;

      // get ticket info
      $ticket = Ticket::where([
        ['venue_id', '=', $venue_id],
        ['id', '=', $ticket_id]
      ])->get(["daily_limit", "cost", "name"])->first();

      if (isset($ticket)) {

        // get daily limit
        $daily_limit = $ticket->daily_limit;
        $cost = $ticket->cost;

        // count number of bookings
        $bookings = count(Booking::where([
          ['ticket_id', '=', $ticket_id],
          ['confirmed', true]
        ])->whereDate('created_at', $date)->get());

        if ($daily_limit > 0 && $daily_limit >= ($bookings + $qty)) {

          // get venue info
          $venue = Venue::where([
            ['id', '=', $venue_id],
          ])->get(["name", "account"])->first();

          array_push($booking_responses, array(
            "success" => true,
            "id" => $ticket_id,
            "venue" => $venue,
            "ticket" => $venue->name . " - " . $ticket->name,
            "ticket_id" => $ticket_id,
            "qty" => $qty,
            "cost" => $cost,
            "date" => $date
          ));
        } else {
          $booking_success = false;
          array_push($booking_responses, array(
            "success" => false,
            "id" => $ticket_id,
            "status" => "NO_AVAILABILITY"
          ));
        }
      } else {
        $booking_success = false;
        array_push($booking_responses, array(
          "success" => false,
          "id" => $ticket_id,
          "status" => "TICKET_NOT_FOUND"
        ));
      }
    }

    if ($booking_success) {

      // work out booking fee
      $booking_fee = array_sum(array_map(function ($b) {
        return intval($b["qty"]) * $_ENV["BOOKING_FEE"];
      }, $booking_responses));

      // add booking fee
      array_push($booking_responses, array(
        "ticket" => "Booking fee",
        "qty" => 1,
        "cost" => $booking_fee
      ));

      // generate stripe session for payments
      $payment_session = $this->create_checkout_session($booking_responses, "GBP", $ticket->cost * 100, $venue->account, $url);

      // commit all tickets to database
      foreach ($booking_responses as $booking) {
        for ($i = 1; $i === intval($booking["qty"]); $i++) {
          if (isset($booking["ticket_id"])) {
            $booking = new Booking([
              "ticket_id" => $booking["ticket_id"],
              "user_id" => $user_id,
              "session" => $payment_session,
              "date" => $date,
              "cost" => $booking["cost"]
            ]);
            $booking->save();
          }
        }
      };

    } else {
      $payment_session = "";
    }

    return response()->json(array(
      "success" => $booking_success,
      "bookings" => $booking_responses,
      "user" => $user_id,
      "session_id" => $payment_session
    ), 200);

    // $date = gmdate("Y-m-d", $date / 1000);
    // $url = $request->url;

    // // get ticket info
    // $ticket = Ticket::where([
    //   ['venue_id', '=', $venue_id],
    //   ['id', '=', $ticket_id]
    // ])->get(["daily_limit", "cost", "name"])->first();

    // if (isset($ticket)) {

    //   // get daily limit
    //   $daily_limit = $ticket->daily_limit;

    //   // count number of bookings
    //   $bookings = count(Booking::where([
    //     ['ticket_id', '=', $ticket_id],
    //     ['confirmed', true]
    //   ])->whereDate('created_at', $date)->get());

    //   // count number of user bookings
    //   $user_bookings = count(Booking::where([
    //     ['ticket_id', '=', $ticket_id],
    //     ['user_id', '=', $user_id],
    //     ['confirmed', true]
    //   ])->whereDate('created_at', $date)->get());

    //   if ($daily_limit > 0 && $daily_limit > $bookings) {

    //     // get venue info
    //     $venue = Venue::where([
    //       ['id', '=', $venue_id],
    //     ])->get(["name", "account"])->first();

    //     // generate stripe session for payments
    //     $payment_session = $this->create_checkout_session("GBP", $ticket->cost * 100, $venue->name . ": " . $ticket->name, "", $venue->account, $url);

    //     // write booking to DB
    //     $booking = new Booking([
    //       "ticket_id" => $ticket_id,
    //       "user_id" => $user_id,
    //       "session" => $payment_session
    //     ]);
    //     $booking->save();

    //     // is there still availability after this booking?
    //     $many_left = $daily_limit - $bookings;

    //     // get status message
    //     $status = $this->get_booking_status($user_bookings, $many_left);

    //     return response()->json(array(
    //       "success" => true,
    //       "booking_id" => intval($booking->id),
    //       "availability" => $many_left > 0,
    //       "ticket_id" => intval($ticket_id),
    //       "status" => $status,
    //       "user" => $user_bookings,
    //       "session_id" => $payment_session
    //     ));
    //   } else {
    //     return response()->json(array(
    //       "success" => false,
    //       "avaiability" => false
    //     ));
    //   }
    // } else {  // no availability

    //   return response()->json(array(
    //     "success" => false
    //   ), 404);
    // }
  }
}
