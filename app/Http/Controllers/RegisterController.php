<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Venue;
use App\Http\Traits\StripeTrait;

class RegisterController extends Controller
{

  use StripeTrait;

  public function __construct()
  {
  }

  public function register(Request $request) // fisherman
  {

    $data = $request->all();

    $validator = Validator::make($data, [
      "name" => ["required", "string", "max:255"],
      "email" => ["required", "string", "email", "max:255", "unique:users"],
      "password" => ["required", "string", "min:8", "confirmed"],
    ]);

    if ($validator->fails()) {
      return response()->json(array(
        "success" => false,
        "errors" => $validator->messages()
      ));
    }

    $user = User::create([
      "name" => $data["name"],
      "email" => $data["email"],
      "password" => Hash::make($data["password"]),
      "user_type" => 1
    ]);
    $user->save();

    return response()->json(array(
      "success" => true,
      "email" => $user->email
    ));
  }

  public function signup(Request $request)  // fishery
  {

    $data = $request->all();

    $validator = Validator::make($data, [
      "fisheryName" => ["required", "string", "max:255"],
      "placeId" => ["required", "string", "max:255"],
      "address" => ["required", "string", "max:255"],
      "name" => ["required", "string", "max:255"],
      "email" => ["required", "string", "email", "max:255", "unique:users"],
      "password" => ["required", "string", "min:8", "confirmed"],
      "subscription" => ["required", "string", "max:255"]
    ]);

    if ($validator->fails()) {
      return response()->json(array(
        "success" => false,
        "errors" => $validator->messages()
      ));
    }

    // does venue exist by place_id?
    if (Venue::where("place_id", "=", $data["placeId"])->exists()) {

      // venue exists, get info
      $venue_id = Venue::where("place_id", "=", $data["placeId"])->first()->id;
      $account_id = Venue::where("place_id", "=", $data["placeId"])->first()->account;
      $venue_active = Venue::where("place_id", "=", $data["placeId"])->first()->active;
      $checkout_session_id = "";

    } else {  // set up new venue

      $venue = Venue::create([
        "name" => $data["fisheryName"],
        "address" => $data["address"],
        "place_id" => $data["placeId"],
        "active" => 0, // mark as inactive until session is complete (webhook will mark as active)
        "subscription" => $data["subscription"],
        "checkout_session" => ""
      ]);
      $venue->save();

      $venue_id = $venue->id;
      $account_id = "";
      $venue_active = false;
      $checkout_session_id = "";
    }

    // if venue is active then don't proceed
    if ($venue_active) {
      return response()->json(array(
        "success" => false,
        "venue_active" => true
      ), 409);
    }

    // create new user and associated with venue
    $user = User::create([
      "name" => $data["name"],
      "email" => $data["email"],
      "password" => Hash::make($data["password"]),
      "user_type" => 2,
      "venue_id" => $venue_id
    ]);
    $user->save();
    $user_id = $user->id;

    // create stripe subscription checkout session (for monthly fee to GOFish)
    $checkout_session_id = $this->create_gofish_subscription("price_1KiKPoHi5I5M4WuheVX53d4W", $venue_id, $data["email"]);

    // create stripe connected account for receiving payments (if one doesn't exist)
    if (!isset($account_id) || $account_id === "") { 
      $account_id = $this->connected_account_create($data["email"], $data["fisheryName"]);
    }

    // generate stripe signup link for account (to provide bank details for payments to fishery)
    $account_link = $this->connected_account_link_create($venue_id, $account_id);

    // update venue with stripe info
    Venue::where([
      ["id", "=", $venue_id]
    ])->update(array(
      "checkout_session" => $checkout_session_id,
      "account_link" => $account_link,
      "account" => $account_id
    ));

    return response()->json(array(
      "success" => true,
      "session_id" => $checkout_session_id  // create session for subscription
    ));
  }

  public function signup_confirm(Request $request)
  {

    $event = null;

    if (!$this->verify_event($request->getContent(), $_SERVER["HTTP_STRIPE_SIGNATURE"])) {
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

        // clear basket and record payment intent
        $session_id = $event->data->object->id;
        $session_payment_status = $event->data->object->payment_status;
        $venue_id = intval($event->data->object->client_reference_id);
        $payment_intent = $event->data->object->payment_intent;

        // update session payment if paid
        if ($session_payment_status === "paid") {

          $venue = Venue::where([
            ["checkout_session", "=", $session_id]
          ])->first();

          $venue->account_payment_confirmed = 1;
          $venue->account_payment_reference = $payment_intent; // e.g. pi_3JWy30Hi5I5M4Wuh1YZXKvRT
          $venue->save();

          // TODO - send klaviyo transactional email confirming payment
            

        }

        break;

      case "payment_intent.succeeded":

        // record receipt for payment
        $payment_intent_id = $event->data->object->id;
        $payment_receipt_link = implode(", ", array_map(function ($c) {
          return $c->receipt_url;
        }, $event->data->object->charges->data));

        sleep(1); // pause for a second to allow write transaction to db (race condition)

        $venue = Venue::where([
          ["account_payment_reference", "=", $payment_intent_id]
        ])->first();

        $venue->account_payment_receipt = $payment_receipt_link;
        $venue->save();

        break;
      default:
        echo "Received unknown event type " . $event->type;
    }

    http_response_code(200);
  }

}
