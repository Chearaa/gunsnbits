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
        'gunsnbits.js'
    ]);

    mix.version([
        'public/css/app.css',
        'public/js/all.js'
    ]);

    mix.copy('resources/assets/libs/fontawesome/fonts', 'public/build/fonts');
});
