<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Venue;
use App\Http\Traits\UtilTrait;
use App\Http\Traits\StripeTrait;
use App\Http\Traits\KlaviyoTrait;

class RegisterController extends Controller
{

  use UtilTrait;
  use StripeTrait;
  use KlaviyoTrait;

  public function __construct() {}

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

    // get info
    $login_link = env('APP_URL', '') . '/signup/confirm';
    $name = $user->name;
    $email = $user->email;

    // add user to klaviyo
    if (env('KLAVIYO_FISHER_LIST', '') !== '') {
      $list_id = env('KLAVIYO_FISHER_LIST');
      $first_name = $this->split_name($name)[0];
      $last_name = $this->split_name($name)[1];
      // add user info to Klaviyo
      $this->add_profile($list_id, $email, $first_name, $last_name);
    }

    // send welcome email to user
    // TODO - replace with Klaviyo flow
    Mail::send('emails.welcomefisher', ['name' => $name, 'login_link' => $login_link], function ($m) use ($name, $email) {
      $m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
      $m->to($email, $name);
      $m->subject('Welcome to GoFish');
    });

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
      "subscription" => ["required", "string", "max:255"],
      "payment_model" => ["required", "string", "max:255"]
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
      $venue_managed = User::where("venue_id", "=", $venue_id)->count() > 0;
    } else {  // set up new venue

      $plans = $this->get_prices();
      $selected_plan = null;
      foreach ($plans as $plan) {
        if ($plan['id'] === $data['payment_model']) {
          $selected_plan = $plan;
          break;
        }
      }

      $subscription_name = $selected_plan ? $selected_plan['name'] : 'Commission-only';
      $payment_fee = $selected_plan ? $selected_plan['commission'] : 10;

      $venue = Venue::create([
        "name" => $data["fisheryName"],
        "address" => $data["address"],
        "place_id" => $data["placeId"],
        "active" => 0, // mark as inactive until session is complete (webhook will mark as active)
        "subscription" => $subscription_name,
        "payment_model" => $data["payment_model"],
        "payment_fee" => $payment_fee,
        "checkout_session" => ""
      ]);
      $venue->save();

      $venue_id = $venue->id;
      $venue_managed = false;
    }

    // if venue is active then don't proceed
    if ($venue_managed) {
      return response()->json(array(
        "success" => false,
        "venue_managed" => true
      ), 409);
    }

    // generate code for verification
    $confirmation_code = $this->random_str(30);

    // create new user and associate with venue
    $user = User::create([
      "name" => $data["name"],
      "email" => $data["email"],
      "password" => Hash::make($data["password"]),
      "user_type" => 2,
      "venue_id" => $venue_id,
      "confirmation_code" => $confirmation_code
    ]);
    $user->save();

    // lookup venue info
    $venue = Venue::find($venue_id);
    $venue_name = $venue->name;
    $venue_address = $venue->address;

    // generate verification link and send email to admin
    // TODO - replace with Klaviyo flow
    $verify_link = env('APP_URL', '') . '/api/verify?id=' . $user->id . '&code=' . $confirmation_code;
    Mail::send('emails.signup', ['email' => $data['email'], 'venue_name' => $venue_name, 'venue_address' => $venue_address, 'verify_link' => $verify_link, 'name' =>  $data['name']], function ($m) use ($verify_link) {
      $m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
      $m->to(env('MAIL_APPROVALS_TO', env('MAIL_APPROVALS_TO')));
      $m->subject('New GoFish Fishery Registration');
    });

    // 

    return response()->json(array(
      "success" => true,
      "venue_id" => $venue_id
    ));
  }

  public function get_subscription(Request $request, $session)
  {

    // get venue
    $venue = Venue::where([
      ["account_payment_confirmed", "=", 1],
      ["checkout_session", "=", $session]
    ])->distinct()->first(["name", "id", "account_link", "subscription"]);

    return response()->json($venue);
  }

  public function verify(Request $request)
  {  // verify account

    if ($request->has('id') && $request->has('code')) {

      $id = $request->input('id');
      $code = $request->input('code');

      // find user
      $user = User::where([
        'id' => $id,
        'confirmation_code' => $code
      ])->first();

      // mark as verified
      $user->markEmailAsVerified();

      // generate login link
      $login_link = env('APP_URL', '') . '/signup/confirm';
      $name = $user->name;
      $email = $user->email;

      // look up venue
      $venue = Venue::find($user->venue_id);
      $account_id = $venue->account;

      // create stripe connected account for receiving payments (if one doesn't exist)
      if (!isset($account_id) || $account_id === "" || $account_id === "none") {
        $account_id = $this->connected_account_create($email, $venue->name);
        // update account against venue
        $venue->update(array(
          "account" => $account_id
        ));
      }

      // generate stripe signup link for account (to provide bank details for payments to fishery)
      $account_link = $this->connected_account_link_create($venue->id, $account_id);

      // update venue with account link
      $venue->update(array(
        "account_link" => $account_link
      ));

      // Activate venue immediately if they are on a free plan (monthly fee is 0)
      $plans = $this->get_prices();
      $selected_plan = null;
      foreach ($plans as $p) {
        if ($p['id'] === $venue->payment_model) {
          $selected_plan = $p;
          break;
        }
      }
      if ($selected_plan && $selected_plan['monthly_fee'] == 0) {
        $venue->update([
          'active' => 1,
          'account_payment_confirmed' => 1,
        ]);
      }

      // generate account link from venue page
      $account_link = env('APP_URL', '') . '/manage-venues/' . $venue->id . '?tab=Payment';

      if (env('KLAVIYO_FISHERY_LIST', '') !== '') {
        $list_id = env('KLAVIYO_FISHERY_LIST');
        $first_name = $this->split_name($name)[0];
        $last_name = $this->split_name($name)[1];
        // add user info to Klaviyo
        $this->add_connected_account_link_to_profile($list_id, $email, $first_name, $last_name, $venue->name, $account_link);
      }

      // send welcome email to user
      // TODO - replace with Klaviyo flow
      Mail::send('emails.welcome', ['name' => $name, 'login_link' => $login_link, 'stripe_link' => $account_link], function ($m) use ($name, $login_link, $email) {
        $m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
        $m->to($email, $name);
        $m->subject('New GoFish Account');
      });

      return redirect()->route('home');  // redirect to confirm route

    } else {
      return response()->json([
        'status' => 500,
        'message' => 'Invalid request'
      ]);
    }
  }

  public function get_prices()
  {
    return \Illuminate\Support\Facades\Cache::remember('stripe_billing_plans', 86400, function () {
      $result = [];

      // Fetch all active prices for the product from Stripe
      $product_id = config('billing.product_id');
      if ($product_id) {
        try {
          $client = new \Stripe\StripeClient(env("STRIPE_SECRET"));
          $prices = $client->prices->all([
            'product' => $product_id,
            'active' => true,
          ]);

          foreach ($prices->data as $price) {
            $amount = $price->unit_amount / 100;
            $currency = strtoupper($price->currency) === 'GBP' ? '£' : '$';
            $commission = isset($price->metadata['commission']) ? (float) $price->metadata['commission'] : 5;

            $result[] = [
              'id' => $price->id,
              'name' => "{$currency}{$amount} per month with {$commission}% commission",
              'monthly_fee' => $amount,
              'commission' => $commission,
              'stripe_price_id' => $price->id,
            ];
          }

          // Sort by monthly fee ascending (free tier first, then cheapest paid)
          usort($result, function ($a, $b) {
            return $a['monthly_fee'] <=> $b['monthly_fee'];
          });
        } catch (\Exception $e) {
          // If Stripe API fails, return just the commission-only plan
        }
      }

      return $result;
    });
  }
}
