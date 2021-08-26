<?php

namespace App\Http\Traits;

trait StripeTrait {

  public function create_checkout_session($currency, $amount, $description, $image, $account_id, $url, $meta_data = []) {
    \Stripe\Stripe::setApiKey($_ENV["STRIPE_SECRET"]);
    $checkout_session = \Stripe\Checkout\Session::create([
      "payment_method_types" => ["card"],
      "line_items" => [[
        "price_data" => [
          "currency" => $currency,
          "unit_amount" => $amount,
          "product_data" => [
            "name" => $description,
            // "images" => [ $image ],
          ],
        ],
        "quantity" => 1,
      ]],
      "payment_intent_data" => [
        "application_fee_amount" => round(($amount / 100) * $_ENV["STRIPE_PAYMENT_FEE_PERCENTAGE"]),
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
