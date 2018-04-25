/**
* Class CreatePreCotizacionView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreatePreCotizacionView = Backbone.View.extend({

        el: '#precotizaciones-create',
        template: _.template( ($('#add-precotizacion-tpl').html() || '') ),
        events: {
            'click .submit-precotizacion': 'submitForm',
            'submit #form-precotizaciones': 'onStore',
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            // Events
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        /*
        * Render View Element
        */
        render: function() {
            var attributes = this.model.toJSON();
                attributes.edit = false;

            this.$el.html( this.template(attributes) );
            this.$form = this.$('#form-precotizaciones');
            this.spinner = this.$('#spinner-main');

            this.ready();
        },

        /**
        * Event submit productop
        */
        submitForm: function (e) {
            this.$form.submit();
        },

        /**
        * Event Create orden
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
                this.model.save( data, {patch: true, silent: true} );
            }
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();

            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();

            if( typeof window.initComponent.initInputMask == 'function' )
                window.initComponent.initInputMask();

            if( typeof window.initComponent.initDatePicker == 'function' )
                window.initComponent.initDatePicker();
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function (model, xhr, opts) {
            window.Misc.setSpinner( this.spinner );
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            window.Misc.removeSpinner( this.spinner );

            if(!_.isUndefined(resp.success)) {
                // response success or error
                var text = resp.success ? '' : resp.errors;
                if( _.isObject( resp.errors ) ) {
                    text = window.Misc.parseErrors(resp.errors);
                }

                if( !resp.success ) {
                    alertify.error(text);
                    return;
                }

                // CreatePreCotizacionView undelegateEvents
                if ( this.createPreCotizacionView instanceof Backbone.View ){
                    this.createPreCotizacionView.stopListening();
                    this.createPreCotizacionView.undelegateEvents();
                }

                // Redirect to edit precotizaciones
                Backbone.history.navigate(Route.route('precotizaciones.edit', { precotizaciones: resp.id}), { trigger:true });
            }
        }
    });

})(jQuery, this, this.document);
