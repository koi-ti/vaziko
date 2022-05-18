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

var paths = {
    'libs': './resources/assets/libs/',
    'adminlte': './resources/assets/libs/AdminLTE/',
    'node': './node_modules/'
}

elixir(function(mix) {
    mix.styles([
        paths.libs + 'jquery-ui/themes/base/core.css',
        paths.libs + 'jquery-ui/themes/base/spinner.css',
        paths.libs + 'jquery-ui/themes/base/theme.css',
        paths.adminlte + 'bootstrap/css/bootstrap.min.css',
        paths.adminlte + 'dist/css/skins/skin-green.min.css',
        paths.adminlte + 'dist/css/skins/skin-red.min.css',
        paths.adminlte + 'plugins/iCheck/minimal/green.css',
        paths.adminlte + 'plugins/select2/select2.min.css',
        paths.adminlte + 'plugins/datepicker/datepicker3.css',
        paths.adminlte + 'plugins/timepicker/bootstrap-timepicker.min.css',
        paths.adminlte + 'dist/css/AdminLTE.min.css',
        paths.libs + 'font-awesome/css/font-awesome.min.css',
        paths.libs + 'datatables.net-bs/css/dataTables.bootstrap.css',
        paths.libs + 'datatables.net-buttons-bs/css/buttons.bootstrap.min.css',
        paths.libs + 'datatables.net-responsive-dt/css/responsive.dataTables.min.css',
        paths.libs + 'alertify.js/src/css/alertify.css',
        paths.libs + 'jquery-ui/themes/base/all.css',
        paths.node + 'fine-uploader/jquery.fine-uploader/fine-uploader-new.css',
        paths.libs + 'fullcalendar/dist/fullcalendar.min.css',
        paths.libs + 'clockpicker/dist/bootstrap-clockpicker.min.css'
    ], 'public/css/vendor.min.css');

    mix.less('../css/app.less', 'public/css/app.min.css');

    mix.scripts([
        paths.adminlte + 'plugins/jQuery/jquery-2.2.3.min.js',
        paths.libs + 'jquery-ui/ui/core.js',
        paths.libs + 'jquery-ui/ui/widget.js',
        paths.libs + 'jquery-ui/ui/spinner.js',
        paths.adminlte + 'bootstrap/js/bootstrap.min.js',
        paths.adminlte + 'dist/js/app.min.js',
        paths.adminlte + 'plugins/fastclick/fastclick.js',
        paths.adminlte + 'plugins/slimScroll/jquery.slimscroll.min.js',
        paths.adminlte + 'plugins/iCheck/icheck.min.js',
        paths.adminlte + 'plugins/select2/select2.full.min.js',
        paths.adminlte + 'plugins/select2/i18n/es.js',
        paths.adminlte + 'plugins/datepicker/bootstrap-datepicker.js',
        paths.adminlte + 'plugins/datepicker/locales/bootstrap-datepicker.es.js',
        paths.adminlte + 'plugins/timepicker/bootstrap-timepicker.min.js',
        paths.libs + 'bootstrap-validator/dist/validator.min.js',
        paths.libs + 'datatables.net/js/jquery.dataTables.min.js',
        paths.libs + 'datatables.net-bs/js/dataTables.bootstrap.min.js',
        paths.libs + 'datatables.net-buttons/js/buttons.html5.js',
        paths.libs + 'jquery.inputmask/dist/jquery.inputmask.bundle.js',
        paths.libs + 'datatables.net-buttons/js/dataTables.buttons.js',
        paths.libs + 'datatables.net-buttons-bs/js/buttons.bootstrap.min.js',
        paths.libs + 'datatables.net-responsive/js/dataTables.responsive.min.js',
        paths.libs + 'accounting.js/accounting.min.js',
        paths.libs + 'underscore/underscore.js',
        paths.libs + 'backbone/backbone.js',
        paths.libs + 'moment/moment.js',
        paths.libs + 'moment/locale/es.js',
        paths.libs + 'chart.js/dist/Chart.js',
        paths.libs + 'alertify.js/dist/js/alertify.js',
        paths.node + 'fine-uploader/jquery.fine-uploader/jquery.fine-uploader.js',
        paths.libs + 'fullcalendar/dist/fullcalendar.min.js',
        paths.libs + 'fullcalendar/dist/locale/es.js',
        paths.libs + 'clockpicker/dist/bootstrap-clockpicker.min.js',
        paths.node + 'jquery.flot/jquery.flot.js',
        paths.node + 'jquery.flot/jquery.flot.**.js',
        paths.libs + 'chartjs-plugin-labels/src/chartjs-plugin-labels.js'
   	], 'public/js/vendor.min.js')
    .scripts([
        '../scripts/models/**/*.js',
        '../scripts/collections/**/*.js',
        '../scripts/views/**/**/*.js',
        '../scripts/helpers/misc.js',
        '../scripts/helpers/routes.min.js',
        '../scripts/routes.js',
        '../scripts/init.js'
    ], 'public/js/app.min.js')

    // Cache busting
    mix.version(['css/app.min.css', 'css/vendor.min.css', 'js/app.min.js', 'js/vendor.min.js']);

    mix.copy(paths.adminlte + 'bootstrap/fonts/', 'public/build/fonts');
    mix.copy(paths.adminlte + 'plugins/iCheck/minimal/green**.png', 'public/build/css');
    mix.copy(paths.node + 'fine-uploader/jquery.fine-uploader/**.gif', 'public/build/css');
    mix.copy(paths.node + 'fine-uploader/jquery.fine-uploader/placeholders/**.png', 'public/build/css/placeholders');
    mix.copy(paths.libs + 'font-awesome/fonts/', 'public/build/fonts');
    mix.copy(paths.libs + 'jquery-ui/themes/base/images/', 'public/build/css/images/');
});
