let mix = require('laravel-mix');

require('tailwindcss');
require('laravel-mix-purgecss');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/assets/js/app.js', 'public/js')
   .less('resources/assets/less/app.less', 'public/css')
   .tailwind()
   .purgeCss()
   .browserSync('');

if (mix.inProduction()) {
    mix.version();
}

