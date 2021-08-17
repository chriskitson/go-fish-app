const mix = require("laravel-mix");
require("laravel-mix-tailwind");

mix.options({
    postCss: [require("tailwindcss")("./tailwind.config.js")]
});

mix.js("resources/js/pages/home/home-client.js", "public/js")
    .js("resources/js/pages/home/home-server.js", "public/js")
    .js("resources/js/pages/detail/detail-client.js", "public/js")
    .js("resources/js/pages/detail/detail-server.js", "public/js")
    .vue()
    .postCss("resources/css/app.css", "public/css")
    .webpackConfig(require("./webpack.config"))
    .tailwind()
    .sourceMaps()
    .copy("resources/images", "public/images", false);

if (mix.inProduction()) {
    mix.version();
}
