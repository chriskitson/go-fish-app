<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <title>GoFish!</title>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <script defer src="{{ mix('js/app-client.js') }}"></script>
    </head>
    <body>
        {!! Ssr::entry('js/app-server.js')->render() !!}
    </body>
</html>