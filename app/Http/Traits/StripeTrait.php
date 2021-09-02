<?php

namespace App\Http\Traits;

trait StripeTrait
{

  public function create_checkout_session($items, $currency, $amount, $account_id, $url, $meta_data = [])
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
      "line_items" => $checkout_items,
      "payment_intent_data" => [
        "application_fee_amount" => round(($amount / 100) * $_ENV["TICKET_FEE_PERCENTAGE"]),
        "transfer_data" => [
          "destination" => $account_id,
        ],
        "metadata" => $meta_data
      ],
      "mode" => "payment",
      "success_url" => $_ENV["STRIPE_RESPONSE_ROOT"] . "/confirm",
      "cancel_url" => $_ENV["STRIPE_RESPONSE_ROOT"] . $url,
      "metadata" => $meta_data
    ]);
    return $checkout_session->id;
  }
}
