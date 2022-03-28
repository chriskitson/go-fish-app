<?php

namespace App\Http\Traits;

trait StripeTrait
{

  public function create_checkout_session($user_id, $email, $items, $currency, $account_id, $application_fee, $url, $meta_data = [])
  {
    \Stripe\Stripe::setApiKey($_ENV["STRIPE_SECRET"]);
    $checkout_items = [];
    foreach ($items as $item) {
      array_push($checkout_items, array(
        "price_data" => array(
          "currency" => $currency,
          "unit_amount" => $item["cost"] * 100,
          "product_data" => [
            "name" => $item["ticket"],
            // "images" => [ $image ],
          ],
        ),
        "quantity" => $item["qty"]
      ));
    };
    $checkout_session = \Stripe\Checkout\Session::create([
      "payment_method_types" => ["card"],
      "client_reference_id" => $user_id,
      "customer_email" => $email,
      "line_items" => $checkout_items,
      "payment_intent_data" => [
        "application_fee_amount" => $application_fee,
        "metadata" => $meta_data,
        "receipt_email" => $email,
      ],
      "mode" => "payment",
      "success_url" => $_ENV["APP_URL"] . "/confirm/{CHECKOUT_SESSION_ID}",
      "cancel_url" => $_ENV["APP_URL"] . "/basket",
      "metadata" => $meta_data
    ], [
      "stripe_account" => $account_id
    ]);
    return $checkout_session->id;
  }

  public function verify_event($payload, $sig_header)
  {
    \Stripe\Stripe::setApiKey($_ENV["STRIPE_SECRET"]);
    $endpoint_secret = $_ENV["STRIPE_WH_SECRET"];
    try {
      $event = \Stripe\Webhook::constructEvent(
        $payload,
        $sig_header,
        $endpoint_secret
      );
      return true;
    } catch (\UnexpectedValueException $e) {
      return false;
    } catch (\Stripe\Exception\SignatureVerificationException $e) {
      return false;
    }
  }

  public function connected_account_create($email, $name) {
    $client = new \Stripe\StripeClient($_ENV["STRIPE_SECRET"]);
    $connected_account = $client->accounts->create([
      "type" => "express",
      "country" => "GB",
      "email" => $email,
      "capabilities" => [
        "card_payments" => ["requested" => true],
        "transfers" => ["requested" => true],
      ],
      // "company" => [
      //   "name" => $name
      // ]
    ]);
    return $connected_account->id;
  }

  public function connected_account_link_create($venue_id, $account_id) {
    $client = new \Stripe\StripeClient($_ENV["STRIPE_SECRET"]);
    $connected_account_link = $client->accountLinks->create([
      "account" => $account_id,
      "refresh_url" => env("APP_URL") . "/expired/" . $venue_id,
      "return_url" => env("APP_URL") . "/manage-venues/" . $venue_id,
      "type" => "account_onboarding",
    ]);
    return $connected_account_link->url;
  }

  public function create_gofish_subscription($product_price_id, $venue_id, $email, $meta_data = [])
  {
    \Stripe\Stripe::setApiKey($_ENV["STRIPE_SECRET"]);
    $checkout_session = \Stripe\Checkout\Session::create([
      "payment_method_types" => ["card"],
      "client_reference_id" => $venue_id,
      "customer_email" => $email,
      "line_items" => [[
        "price" => $product_price_id,
        "quantity" => 1
      ]],
      "metadata" => $meta_data,
      "mode" => "subscription",
      "success_url" => $_ENV["APP_URL"] . "/signup/confirm/{CHECKOUT_SESSION_ID}",
      "cancel_url" => $_ENV["APP_URL"] . "/signup",
      "metadata" => $meta_data
    ]);
    return $checkout_session->id;
  }

}
