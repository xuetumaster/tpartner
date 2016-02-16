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

    mix.copy('node_modules/jquery/dist/jquery.js','resources/assets/js/vendors/jquery.js')
    mix.copy('node_modules/bootstrap/dist/js/bootstrap.js','resources/assets/js/vendors/bootstrap.js')
    mix.copy('node_modules/vue/dist/vue.js','resources/assets/js/vendors/vue.js')
    mix.copy('node_modules/tether/dist/js/tether.js','resources/assets/js/vendors/tether.js')
    
    mix.scripts(['vendors/jquery.js','vendors/tether.js','vendors/bootstrap.js','vendors/vue.js'], 'public/js/vendors.js');

    mix.version(['css/app.css','js/vendors.js']);

    //mix.browserSync({'proxy':'tpartner.app'});
});
