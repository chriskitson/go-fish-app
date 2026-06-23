<?php

return [
    // The Stripe product ID whose prices define the available subscription plans.
    // All active prices for this product are fetched dynamically from Stripe.
    // Commission rates are read from each price's metadata ('commission' key).
    'product_id' => env('STRIPE_SUBSCRIPTION_PRODUCT'),
];
