<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use App\Models\Basket;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Traits\BookingTrait;
use App\Http\Traits\StripeTrait;
use App\Http\Traits\KlaviyoTrait;

class WebhookController extends Controller
{

  use BookingTrait;
  use StripeTrait;
  use KlaviyoTrait;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
  }

  public function direct(Request $request)
  {

    $event = null;

    if (!$this->verify_event($request->getContent(), $_SERVER["HTTP_STRIPE_SIGNATURE"], env("STRIPE_DIRECT_WH_SECRET"))) {
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
      case "checkout.session.completed":

        $this->subscription_session($event);

        break;

      default:
        echo "Received unknown event type " . $event->type;
    }

    http_response_code(200);
  }

  public function connect(Request $request)
  {

    $event = null;

    if (!$this->verify_event($request->getContent(), $_SERVER["HTTP_STRIPE_SIGNATURE"], env("STRIPE_CONNECT_WH_SECRET"))) {
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
      case "checkout.session.completed":

        $this->booking_session($event);

        break;

      case "checkout.session.expired":

        $this->booking_session_failed($event);

        break;

      case "payment_intent.succeeded":

        $this->booking_receipt($event);

        break;
      default:
        echo "Received unknown event type " . $event->type;
    }

    http_response_code(200);
  }

  public function booking_session($event)
  {
    // clear basket and record payment intent
    $session_id = $event->data->object->id;
    $session_payment_status = $event->data->object->payment_status;
    $user_id = intval($event->data->object->client_reference_id);
    $payment_intent = $event->data->object->payment_intent;

    // update session payment if paid
    if ($session_payment_status === "paid") {

      $transaction = Transaction::where([
        ["session", "=", $session_id]
      ])->first();

      if (isset($transaction)) {
        $transaction->confirmed = 1;
        $transaction->payment = $payment_intent; // e.g. pi_3JWy30Hi5I5M4Wuh1YZXKvRT
        $transaction->save();

        // track successful payment event in Klaviyo
        $this->track_payment_success($transaction);
      }

      // clear basket
      Basket::where([
        ["user_id", "=", $user_id]
      ])->delete();
    }
  }

  public function booking_session_failed($event)
  {
    // track failed/expired payment event in Klaviyo
    $session_id = $event->data->object->id;

    $transaction = Transaction::where([
      ["session", "=", $session_id]
    ])->first();

    if (isset($transaction)) {
      $this->track_payment_failed($transaction);
    }
  }

  public function booking_receipt($event)
  {

    sleep(1); // pause for a second to allow write transaction to db (race condition)

    // record receipt for payment
    $payment_intent_id = $event->data->object->id;
    $payment_receipt_link = implode(", ", array_map(function ($c) {
      return $c->receipt_url;
    }, $event->data->object->charges->data));

    $transaction = Transaction::where([
      ["payment", "=", $payment_intent_id]
    ])->first();

    if (isset($transaction)) {
      $transaction->receipt_link = $payment_receipt_link;
      $transaction->save();
    }
  }

  public function subscription_session($event)
  {
    // clear basket and record payment intent
    $session_id = $event->data->object->id;
    $session_payment_status = $event->data->object->payment_status;
    $venue_id = intval($event->data->object->client_reference_id);
    $subscription_ref = $event->data->object->subscription;

    // update session payment if paid
    if ($session_payment_status === "paid") {

      $venue = Venue::where([
        ["checkout_session", "=", $session_id]
      ])->first();

      if (isset($venue)) {
        $venue->account_payment_confirmed = 1;
        $venue->active = 1; // now visible on website
        $venue->account_payment_reference = $subscription_ref; // e.g. pi_3JWy30Hi5I5M4Wuh1YZXKvRT
        $venue->save();

        // TODO - send klaviyo transactional email confirming payment
      }
    }
  }

  public function subscription_receipt($event)
  {


    sleep(1); // pause for a second to allow write transaction to db (race condition)
    
    // record receipt for payment
    $subscription_id = $event->data->object->id;

    $venue = Venue::where([
      ["account_payment_reference", "=", $subscription_id]
    ])->first();

    if (isset($venue)) {
      // $venue->account_payment_receipt = $payment_receipt_link;
      $venue->save();
    }
  }
}
