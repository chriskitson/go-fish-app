const mix = require("laravel-mix");
require("laravel-mix-tailwind");

mix.options({
    postCss: [require("tailwindcss")("./tailwind.config.js")]
});

mix.js("resources/js/app-client.js", "public/js")
    .js("resources/js/app-server.js", "public/js")
    .vue()
    .postCss("resources/css/app.css", "public/css")
    .webpackConfig(require("./webpack.config"))
    .tailwind()
    .sourceMaps();

if (mix.inProduction()) {
    mix.version();
}