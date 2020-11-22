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


mix.js('resources/js/app.js', 'public/build')
.sass('resources/sass/app.scss', 'public/build');



mix.styles([
  'public/css/sweetalert2.css',
  'public/dt/datatables.min.css',
  'public/css/fontawesome-all.min.css',
  'public/css/m-custom-scrollbar.min.css',
  'public/dp/jquery-ui.min.css',
  'public/dp/jquery-ui.theme.css',
  'public/css/morris.css',
], 'public/build/vendor.min.css');

mix.styles([
  'public/css/style.css',
], 'public/build/style.min.css');


mix.scripts([
  'public/js/sweetalert2.js',
  'public/dt/datatables.min.js',
  'public/dp/jquery-ui.min.js',
  'public/js/sortable.js',
  'public/js/m-custom-scrollbar.min.js',
  'public/js/raphael-min.js',
  'public/js/morris.min.js',
  'public/js/date_fns.min.js',
], 'public/build/vendor.min.js');

mix.scripts([
  'public/js/scripts.js',
],  'public/build/scripts.min.js');


mix.styles([
  'public/css/style-login.css',
], 'public/build/style-login.min.css');
