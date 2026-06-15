<?php

return [
    // The Stripe product ID whose prices define the available subscription plans.
    // All active prices for this product are fetched dynamically from Stripe.
    // Commission rates are read from each price's metadata ('commission' key).
    'product_id' => env('STRIPE_SUBSCRIPTION_PRODUCT'),

    // The free tier is always available and has no Stripe price attached.
    'commission_only' => [
        'name' => 'Zero monthly fee with commission only',
        'monthly_fee' => 0,
        'commission' => env('STRIPE_COMMISSION_ONLY_RATE', 10),
    ],
];
