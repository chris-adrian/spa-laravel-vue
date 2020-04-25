const mix = require('laravel-mix');

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

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')
   .styles([
      'node_modules/animate.css/source/_base.css',
      'node_modules/animate.css/source/fading_entrances/*',
      'node_modules/animate.css/source/fading_exits/*',
      'node_modules/animate.css/source/sliding_entrances/*',
      'node_modules/animate.css/source/sliding_exits/*',
   ], 'public/css/animate.css');
