@inject('venue', 'App\Http\Controllers\VenueController')
@inject('page', 'App\Http\Controllers\PageController')
@php
$initial_state = array();
// pre-fetch venue data server side
if (isset($venueid)) {   // venue detail
    $initial_state['venueDetail'] = $venue->get($venueid)->original;
    $initial_state['ticketDetail'] = $venue->get($venueid)->original;
    if (isset($date)) {
        $initial_state['venueDetail']['date'] = intval($date);
    }
}
if (isset($venuemanageid)) {
    $initial_state['venueDetail'] = $venue->get_detail($venuemanageid)->original;
    $initial_state['venueDetail']['tickets'] = $venue->get_tickets_detail($venuemanageid)->original;
    $initial_state['venueDetail']['closed'] = $venue->get_closures($venuemanageid)->original;
}
if (isset($date) && isset($location)) {   // venue search
    $initial_state['venueSearchResults'] = $venue->search($date, $location)->original;
    $initial_state['venueSearch'] = array(
        "search" => $venue->get_town_by_place_id($location, "place_id"),
        "detail" => array(
            "place_id" => $location
        )
    );
    $initial_state['dateSearch'] = intval($date);
}
if (isset($categoryid)) {
    $initial_state['venueCategory'] = $venue->get_category($categoryid)->original;
    $initial_state['venueCategoryDetail'] = $venue->get_category_detail($categoryid)->original;
}
$initial_state['path'] = Request::path();
$initial_state['bookingFee'] = $_ENV["BOOKING_FEE"];
if ($initial_state['path'] === 'manage-venues') {
    $initial_state['manageVenues'] = $venue->names()->original;
}
$initial_state['allCategories']  = $venue->get_categories()->original;
$page_title = $page->get_title($initial_state['path']);
@endphp
<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <title>{{ $page_title }}</title>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <script defer src="{{ mix('js/app-client.js') }}"></script>
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDWyDnSq8kJoxf0zSdEQguVEgBBT6kuqUs&libraries=places" async defer></script>
        <script src="https://js.stripe.com/v3/"></script>
    </head>
    <body>
        {!! Ssr::entry('js/app-server.js')->context($initial_state)->render() !!}
        <script>window.__INITIAL_STATE__='{!! json_encode($initial_state, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) !!}';</script>
        <script type="text/javascript">
            const stripe = Stripe("<?php echo $_ENV["STRIPE_KEY"]; ?>");
        </script>
    </body>
</html>