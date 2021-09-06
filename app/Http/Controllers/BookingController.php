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

    // verify all tickets are from the same venue
    $venue_count = count(array_unique(array_map(function ($item) {
      return $item["venue_id"];
    }, $items->toArray())));

    if ($venue_count > 1) {
      return response()->json(array(
        "success" => false,
        "message" => "MULTIPLE_VENUES"
      ), 500);
    }

    // loop through tickets and attempt to create a ticket for each
    foreach ($items as $item) {

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
          ])->get(["name", "account", "payment_fee"])->first();

          array_push($booking_responses, array(
            "success" => true,
            "id" => $ticket_id,
            "venue" => $venue,
            "ticket" => $venue->name . " - " . $ticket->name . " - " . $date,
            "ticket_id" => $ticket_id,
            "qty" => $qty,
            "cost" => $cost,
            "date" => $date,
            "account" => $venue->account,
            "payment_fee" => $venue->payment_fee
          ));
        } else {
          $booking_success = false;
          array_push($booking_responses, array(
            "success" => false,
            "basket_id" => $ticket_id,
            "status" => "NO_AVAILABILITY"
          ));
        }
      } else {
        $booking_success = false;
        array_push($booking_responses, array(
          "success" => false,
          "basket_id" => $ticket_id,
          "status" => "TICKET_NOT_FOUND"
        ), 404);
      }
    }

    if ($booking_success) {

      // work out application fee (based on % share of tickets only NOT booking fee)
      $application_fee = array_sum(array_map(function ($b) {
        return ((floatval($b["cost"]) * $b["qty"]) / 100) * $b["payment_fee"];
      }, $booking_responses));

      // work out booking fee (based on number of tickets)
      $booking_fee = array_sum(array_map(function ($b) {
        return intval($b["qty"]) * $_ENV["BOOKING_FEE"];
      }, $booking_responses));

      // venue account
      $venue_account_id = $booking_responses[0]["account"];

      // add booking fee to items
      array_push($booking_responses, array(
        "ticket" => "Booking fee",
        "qty" => 1,
        "cost" => $booking_fee
      ));

      // prepare tickets for stripe
      $items = array_map(function($r) {
        return array(
          "cost" =>  $r["cost"],
          "ticket" =>  $r["ticket"],
          "qty" => $r["qty"]
        );
      }, $booking_responses);

      // generate stripe session for payments
      $payment_session = $this->create_checkout_session($user->email, $items, "GBP", $venue_account_id, $application_fee, $url);

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
    ), $booking_success ? 200 : 500);

    
  }
}
