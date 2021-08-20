@inject('venue', 'App\Http\Controllers\VenueController')
@php
$initial_state = array();
// pre-fetch venue data server side
if (isset($id)) {
    $initial_state['venueDetail'] = $venue->get($id)->original;
}
$initial_state['path'] = $path;
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
    </head>
    <body>
        {!! Ssr::entry('js/app-server.js')->context($initial_state)->render() !!}
        <script>window.__INITIAL_STATE__='{!! json_encode($initial_state) !!}';</script>
    </body>
</html>