/**
* Class MainNotificationView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainNotificationView = Backbone.View.extend({

        el: '#notification-main',
        events: {
            'click .btn-search': 'search',
            'click .btn-clear': 'clear',
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            // Attributes
            this.$searchDate = this.$('#search_fecha');
            this.$searchEstado = this.$('#search_estado');

            this.$spinner = $('#spinner-notification');
        },

        /**
        * Event search
        **/
        search: function(e){
            e.preventDefault();
            var _this = this;

            // Update machine
            $.ajax({
                url: window.Misc.urlFull( Route.route( 'notificaciones.index') ),
                type: 'GET',
                data: {
                    searchDate: _this.$searchDate.val(),
                    searchEstado: _this.$searchEstado.val()
                },
                beforeSend: function() {
                    window.Misc.setSpinner( _this.$spinner );
                }
            })
            .done(function(resp) {
                window.Misc.removeSpinner( _this.$spinner );

                _this.$spinner.html( resp );
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                window.Misc.removeSpinner( _this.$spinner );
                alertify.error(thrownError);
            });
        },

        clear: function(e){
            e.preventDefault();
            var _this = this;

            // Update machine
            $.ajax({
                url: window.Misc.urlFull( Route.route( 'notificaciones.index') ),
                type: 'GET',
                beforeSend: function() {
                    window.Misc.setSpinner( _this.$spinner );
                }
            })
            .done(function(resp) {
                window.Misc.removeSpinner( _this.$spinner );

                window.Misc.clearForm( $('#form-koi-search-tercero-component') );
                _this.$spinner.html( resp );
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                window.Misc.removeSpinner( _this.$spinner );
                alertify.error(thrownError);
            });

        },
    });
})(jQuery, this, this.document);
