@inject('venue', 'App\Http\Controllers\VenueController')
@inject('page', 'App\Http\Controllers\PageController')
@inject('register', 'App\Http\Controllers\RegisterController')
@php
$initial_state = [];
// pre-fetch venue data server side
if (isset($venueid)) {
    // venue detail
    $venue_detail = $venue->get($venueid)->original;
    $initial_state['venueDetail'] = $venue_detail;
    $initial_state['ticketDetail'] = $venue_detail;
    if (isset($date)) {
        $initial_state['venueDetail']['date'] = intval($date);
    }
}
if (isset($venuemanageid)) {
    $initial_state['venueDetail'] = $venue->get_detail($venuemanageid)->original;
    $initial_state['venueDetail']['tickets'] = $venue->get_tickets_detail($venuemanageid)->original;
    $initial_state['venueDetail']['closed'] = $venue->get_closures($venuemanageid)->original;
}
if (isset($date) && isset($location) && request()->get('address') !== '' && request()->get('town') !== '') {
    // venue search
    $initial_state['venueSearchResults'] = $venue->search($date, $location, request()->get('address'))->original;
    $initial_state['venueSearch'] = [
        'search' => request()->get('town'),
        'detail' => [
            'place_id' => $location,
            'address' => request()->get('address')
        ],
    ];
    $initial_state['dateSearch'] = intval($date);
}
if (isset($categoryid)) {
    $initial_state['venueCategory'] = $venue->get_category($categoryid)->original;
    $initial_state['venueCategoryDetail'] = $venue->get_category_detail($categoryid)->original;
}
$initial_state['path'] = Request::path();
$initial_state['bookingFee'] = $_ENV['BOOKING_FEE'];
if ($initial_state['path'] === 'signup' && Request::get('p') !== '') {
    $initial_state['signupPlace'] = [
        'placeId' => Request::get('p'),
        'address' => Request::get('a'),
        'name' => Request::get('n'),
    ];
}
$initial_state['allCategories'] = $venue->get_categories()->original;
$initial_state['prices'] = $register->get_prices();

$page_title = $page->get_title($initial_state['path']);
@endphp
<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <title>{{ $page_title }}</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    @if (isset($date) && isset($location))
        <meta name="robots" content="noindex">
    @endif
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @if (env('GOOGLE_ANALYTICS_TRACKING_KEY') != '')
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo env('GOOGLE_ANALYTICS_TRACKING_KEY'); ?>"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                window.dataLayer.push(arguments);
            }
            gtag('js', new Date());
            gtag('config', '<?php echo env('GOOGLE_ANALYTICS_TRACKING_KEY'); ?>');
        </script>
    @endif
    <script defer src="{{ mix('js/app-client.js') }}"></script>
    @if (env('GOOGLE_MAP_CLIENT_KEY') != '')
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=<?php echo env('GOOGLE_MAP_CLIENT_KEY'); ?>&libraries=places"
                async defer></script>
    @endif
    <script src="https://js.stripe.com/v3/"></script>
</head>

<body>
    {!! Ssr::entry('js/app-server.js')->context($initial_state)->render() !!}
    <script>
        window.__INITIAL_STATE__ = '{!! json_encode($initial_state, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) !!}';
    </script>
    <script>
        window.__STRIPE_PK__ = '<?php echo $_ENV['STRIPE_KEY']; ?>';
    </script>
    @if (env('KLAVIYO_COMPANY') != '')
        <script async type="text/javascript"
                src="https://static.klaviyo.com/onsite/js/klaviyo.js?company_id=<?php echo env('KLAVIYO_COMPANY'); ?>"></script>
    @endif
</body>

</html>
