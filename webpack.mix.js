const mix = require("laravel-mix");

mix.js("resources/js/app-client.js", "public/js")
    .js("resources/js/app-server.js", "public/js")
    .vue()
    .postCss("resources/css/app.css", "public/css", [require("tailwindcss")]);
