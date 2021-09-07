<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Booking;
use App\Models\Venue;
use App\Models\Basket;
use App\Models\Transaction;
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

      $basket_id = $item->id;
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
        $bookings = count(Booking::join('transactions', 'transactions.id', 'bookings.transaction_id')->where([
          ['ticket_id', '=', $ticket_id],
          ['confirmed', true]
        ])->whereDate('bookings.created_at', $date)->get('bookings.id'));

        if ($daily_limit > 0 && $daily_limit >= ($bookings + $qty)) {

          // get venue info
          $venue = Venue::where([
            ['id', '=', $venue_id],
          ])->get(["name", "account", "payment_fee"])->first();

          array_push($booking_responses, array(
            "success" => true,
            "id" => $ticket_id,
            "venue" => $venue,
            "ticket" => $venue->name . " - " . $ticket->name . " - " . date("d M Y", strtotime($date)),
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
            "basket_id" => $basket_id,
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
      }, $booking_responses)) * 100;

      // work out booking fee (based on number of tickets)
      $booking_fee = array_sum(array_map(function ($b) {
        return intval($b["qty"]) * $_ENV["BOOKING_FEE"];
      }, $booking_responses));

      $qty = array_sum(array_map(function ($b) {
        return intval($b["qty"]);
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
      $items = array_map(function ($r) {
        return array(
          "cost" =>  $r["cost"],
          "ticket" =>  $r["ticket"],
          "qty" => $r["qty"]
        );
      }, $booking_responses);

      $total = array_sum(array_map(function ($b) {
        return floatval($b["cost"]) * $b["qty"];
      }, $booking_responses)) * 100;

      // generate stripe session for payments
      $payment_session = $this->create_checkout_session($basket_id, $user->email, $items, "GBP", $venue_account_id, $application_fee, $url);

      // create transaction record
      $transaction = new Transaction([
        "session" => $payment_session,
        "qty" => $qty,
        "total" => $total / 100,
        "booking_fee" => $booking_fee,
        "ticket_fee" => $application_fee / 100
      ]);
      $transaction->save();
      $transaction_id = $transaction->id;

      // commit all tickets to database
      foreach ($booking_responses as $booking) {
        for ($i = 1; $i === intval($booking["qty"]); $i++) {
          if (isset($booking["ticket_id"])) {
            $booking = new Booking([
              "ticket_id" => $booking["ticket_id"],
              "user_id" => $user_id,
              "transaction_id" => $transaction_id,
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
      "session_id" => $payment_session,
      "transaction_id" => $transaction_id 
    ), $booking_success ? 200 : 500);
  }

  public function confirm(Request $request)
  {

    $event = null;

    if (!$this->verify_event($request->getContent(), $_SERVER['HTTP_STRIPE_SIGNATURE'])) {
      // handle unverified
      return response()->json(array(
        "success" => false,
        "verify" => false
      ), 400);
    }

    try {
      $event = \Stripe\Event::constructFrom($request->all());
    } catch (\UnexpectedValueException $e) {
      // handle invalid payload
      return response()->json(array(
        "success" => false,
        "verify" => true
      ), 400);
      exit();
    }

    // handle event
    switch ($event->type) {
      case 'checkout.session.completed':

        // clear basket and record payment intent
        $session_id = $event->data->object->id;
        $session_payment_status = $event->data->object->payment_status;
        $basket_id = intval($event->data->object->client_reference_id);
        $payment_intent = $event->data->object->payment_intent;

        // update session payment if paid
        if ($session_payment_status === "paid") {

          $transaction = Transaction::where([
            ['session', '=', $session_id]
          ])->first();

          $transaction->confirmed = 1;
          $transaction->payment = $payment_intent; // e.g. pi_3JWy30Hi5I5M4Wuh1YZXKvRT
          $transaction->save();

          // clear basket
          Basket::where([
            ['id', '=', $basket_id]
          ])->delete();
        }

        break;

      case 'payment_intent.succeeded':

          // record receipt for payment
          $payment_intent_id = $event->data->object->id;
          $payment_receipt_link = implode(", ", array_map(function($c) {
            return $c->receipt_url;
          }, $event->data->object->charges->data));
  
          $transaction = Transaction::where([
            ['payment', '=', $payment_intent_id]
          ])->first();

          $transaction->receipt_link = $payment_receipt_link;
          $transaction->save();
  
          break;
      default:
        echo 'Received unknown event type ' . $event->type;
    }

    http_response_code(200);
  }
}
