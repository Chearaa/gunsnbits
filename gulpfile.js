var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.sass('app.scss');

    mix.scripts([
        '../libs/jquery/jquery-2.2.4.min.js',
        '../libs/bootstrap/js/bootstrap.min.js',
        '../libs/typeahead/bootstrap-typeahead.min.js',
        '../../../node_modules/moment/moment.js',
        '../../../node_modules/moment/locale/de.js',
        '../libs/bootstrap-datetimepicker/bootstrap-datetimepicker.js',
        '../../../node_modules/croppie/croppie.js',
        '../../../node_modules/jquery-match-height/jquery.matchHeight.js',
        '../libs/owl/owl.carousel.js',
        '../libs/lightbox/lightbox.js',
    ]);

    mix.version([
        'public/css/app.css',
        'public/js/all.js'
    ]);

    mix.copy('resources/assets/libs/fontawesome/fonts', 'public/build/fonts');
    mix.copy('resources/assets/libs/bootstrap/fonts', 'public/build/fonts/bootstrap');
    mix.copy('resources/assets/libs/countdownTimer/jquery.countdownTimer.min.js', 'public/js');
    mix.copy('resources/assets/libs/dropzone/dropzone.js', 'public/js');
    mix.copy('resources/assets/libs/owl/owl.carousel.css', 'public/css');
    mix.copy('resources/assets/libs/lightbox/lightbox.css', 'public/css');
});
