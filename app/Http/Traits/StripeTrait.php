<?php

namespace App\Http\Traits;

trait StripeTrait
{

  public function create_checkout_session($basket_id, $email, $items, $currency, $account_id, $application_fee, $url, $meta_data = [])
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
    }
    $checkout_session = \Stripe\Checkout\Session::create([
      "payment_method_types" => ["card"],
      "client_reference_id" => $basket_id,
      "line_items" => $checkout_items,
      "customer_email" => $email,
      "payment_intent_data" => array(
        "application_fee_amount" => $application_fee,
        "transfer_data" => [
          "destination" => $account_id,
        ]
      ),
      "mode" => "payment",
      "success_url" => $_ENV["STRIPE_RESPONSE_ROOT"] . "/confirm",
      "cancel_url" => $_ENV["STRIPE_RESPONSE_ROOT"] . $url,
    ]);
    return $checkout_session->id;
  }

  public function verify_event($payload, $sig_header)
  {
    \Stripe\Stripe::setApiKey($_ENV["STRIPE_SECRET"]);
    $endpoint_secret = $_ENV["STRIPE_WH_SECRET"];
    $event = null;
    try {
      $event = \Stripe\Webhook::constructEvent(
        $payload,
        $sig_header,
        $endpoint_secret
      );
    } catch (\UnexpectedValueException $e) {
      return false;
    } catch (\Stripe\Exception\SignatureVerificationException $e) {
      return false;
    }
    return true;
  }
}
