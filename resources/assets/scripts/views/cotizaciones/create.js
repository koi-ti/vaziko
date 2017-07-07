/**
* Class CreateCotizacionView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateCotizacionView = Backbone.View.extend({

        el: '#cotizaciones-create',
        template: _.template( ($('#add-cotizacion-tpl').html() || '') ),
        events: {
            'click .submit-cotizacion': 'submitCotizacion',
            'submit #form-cotizacion': 'onStore',
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
            // Initialize
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

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

            this.$form = this.$('#form-cotizacion');

            // spinner 
            this.spinner = this.$('#spinner-main');

            // to fire plugins
            this.ready();
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

            if( typeof window.initComponent.initDatePicker == 'function' )
                window.initComponent.initDatePicker();
        },

        /**
        * Event submit Asiento
        */
        submitCotizacion: function (e) {
            this.$form.submit();
        },

        /**
        * Event Create cotizacion
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                // Prepare global data
                var data = window.Misc.formToJson( e.target );
                this.model.save( data, {patch: true, silent: true} );
            }
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

                // FacturapView undelegateEvents
                if ( this.createCotizacionView instanceof Backbone.View ){
                    this.createCotizacionView.stopListening();
                    this.createCotizacionView.undelegateEvents();
                }

                // Redirect to Content Course
                Backbone.history.navigate(Route.route('cotizaciones.edit', { cotizaciones: resp.id}), { trigger:true });
            }
        }
    });

})(jQuery, this, this.document);
