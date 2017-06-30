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
        templateFp: _.template( ($('#add-detalle-cotizacion-tpl').html() || '') ),
        events: {
            'submit #form-cotizacion': 'onStore',
            'click .add-producto': 'addProducto',
            'click .add-material': 'addMaterial',
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
            // Initialize
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            this.detalleCotizacion2 = new app.DetalleCotizacion2List();
            this.detalleCotizacion3 = new app.DetalleCotizacion3List();

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

            this.$wrapperDetalle = this.$('#render-detalle');
            this.$wrapperDetalle.html( this.templateFp({}) );

            this.spinner = this.$('#spinner-main');

            // Reference views
            this.referenceViews();

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

            if( typeof window.initComponent.initICheck == 'function' )
                window.initComponent.initICheck();

            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();

            if( typeof window.initComponent.initDatePicker == 'function' )
                window.initComponent.initDatePicker();
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            // Detalle cotizacion2 list
            this.detalleCotizacion2ListView = new app.DetalleCotizacion2ListView({
                collection: this.detalleCotizacion2,
                parameters: {
                    wrapper: this.el,
                    edit: true,
                    dataFilter: {
                        'cotizacion': this.model.get('id')
                    }
                }
            });

            // Detalle cotizacion3 list
            this.detalleCotizacion3ListView = new app.DetalleCotizacion3ListView({
                collection: this.detalleCotizacion3,
                parameters: {
                    wrapper: this.el,
                    edit: true,
                    dataFilter: {
                        'cotizacion': this.model.get('id')
                    }
                }
            });
        },

        /**
        * Event Create cotizacion
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                // Prepare global data
                var data = window.Misc.formToJson( e.target );
                	data.cotizacion2 = this.detalleCotizacion2.toJSON();
                this.model.save( data, {patch: true, silent: true} );
            }
        },

        addProducto: function(e){
        	console.log(this.$(e.target).text().trim() == 'Producto' ? 'gaga': 'hoho');
        },

        // /**
        // * Event Create cotizacion
        // */
        // onStoreItem2: function (e) {
        //     if (!e.isDefaultPrevented()) {
        //         e.preventDefault();

        //         // Prepare global data
        //         var data = window.Misc.formToJson( e.target );
        //         console.log(data);
        //         // this.detalleCotizacion2.trigger( 'store' , data );
        //     }
        // },

        // /**
        // * Event Create cotizacion
        // */
        // onStoreItem3: function (e) {
        //     if (!e.isDefaultPrevented()) {
        //         e.preventDefault();

        //         // Prepare global data
        //         var data = window.Misc.formToJson( e.target );
        //         console.log(data);
        //         // this.detalleCotizacion3.trigger( 'store' , data );
        //     }
        // },


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

                // Redirect to Content Course
                window.Misc.redirect( window.Misc.urlFull( Route.route('cotizaciones.show', { cotizaciones: resp.id}) ) );
            }
        }
    });

})(jQuery, this, this.document);
