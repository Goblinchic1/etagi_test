const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.styles([
    'resources/assets/plugins/bootstrap-5.0.2-dist/css/bootstrap.min.css',
    'resources/assets/css/styles.css',
], 'public/assets/css/style.css');


mix.scripts([
    'resources/assets/plugins/jquery/jquery-3.6.0.min.js',
    'resources/assets/plugins/bootstrap-5.0.2-dist/js/bootstrap.min.js',
    'resources/assets/js/scripts.js',
], 'public/assets/js/script.js');

mix.copyDirectory('resources/assets/images', 'public/assets/images/');
