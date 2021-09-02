@inject('venue', 'App\Http\Controllers\VenueController')
@php
$initial_state = array();
// pre-fetch venue data server side
if (isset($venueid)) {   // venue detail
    $initial_state['venueDetail'] = $venue->get($venueid)->original;
    $initial_state['ticketDetail'] = $venue->get($venueid)->original;
}
if (isset($date) && isset($location)) {   // venue search
    $initial_state['venueSearchResults'] = $venue->search($date, $location)->original;
}
$initial_state['path'] = Request::path();
$initial_state['bookingFee'] = $_ENV["BOOKING_FEE"];
@endphp
<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <title>GoFish! - Find the best fisheries near you</title>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <script defer src="{{ mix('js/app-client.js') }}"></script>
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDWyDnSq8kJoxf0zSdEQguVEgBBT6kuqUs&libraries=places" async defer></script>
        <script src="https://js.stripe.com/v3/"></script>
    </head>
    <body>
        {!! Ssr::entry('js/app-server.js')->context($initial_state)->render() !!}
        <script>window.__INITIAL_STATE__='{!! str_replace("'", "\'", json_encode($initial_state)) !!}';</script>
        <script type="text/javascript">
            const stripe = Stripe("<?php echo $_ENV["STRIPE_KEY"]; ?>");
        </script>
    </body>
</html>