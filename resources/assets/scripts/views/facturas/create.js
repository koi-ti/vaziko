/**
* Class CreateFacturaView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateFacturaView = Backbone.View.extend({

        el: '#factura-create',
        template: _.template(($('#add-facturas-tpl').html() || '') ),

        events: {
            'submit #form-factura1' :'onStore',
            'change #factura1_orden' :'changeOrden',
        },
        parameters: {
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            // Attributes
            this.$wraperForm = this.$('#render-form-factura');

            this.detalleFactura2List = new app.DetalleFactura2List();

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
            
            this.$wraperForm.html( this.template(attributes) );
            
            this.$form = this.$('#form-factura1');
            this.ready();
        },

        /**
        * Event Create facturas
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
                this.model.save( data, {patch: true, silent: true} );
            }   
        },  

        changeOrden: function(e){
            this.$ordenp_codigo = this.$(e.currentTarget).val();
            
            // Detalle factura list
            this.detalleFacturaView = new app.DetalleFacturaView({
                collection: this.detalleFactura2List,
                parameters: {
                    edit: false,
                    call: 'create',
                    dataFilter: {
                        factura1_orden: this.$ordenp_codigo
                    }
                }
            });
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
        * Load spinner on the request
        */
        loadSpinner: function (model, xhr, opts) {
            window.Misc.setSpinner( this.el );
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            window.Misc.removeSpinner( this.el );

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
            }
            window.Misc.redirect( window.Misc.urlFull( Route.route('facturas.show', { facturas: resp.id})) );
        }
    });
})(jQuery, this, this.document);
