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
.js('resources/js/suggestions.js', 'public/js')
	.css('resources/css/app.css', 'public/css')
	.css('resources/css/app-mobile.css', 'public/css')
// .sass('resources/sass/app-boot.scss', 'public/css');
   //  .sourceMaps();

mix.copyDirectory('resources/img', 'public/img');
mix.copyDirectory('resources/fonts', 'public/fonts');
mix.copy('resources/js/subspecs.js', 'public/js');
mix.copy('resources/js/register.js', 'public/js');
mix.copy('resources/js/uploads.js', 'public/js');