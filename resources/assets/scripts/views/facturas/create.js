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
        templateDetail: _.template(($('#add-detail-factura').html() || '') ),
        events: {
            'click .submit-factura' :'submitFactura',
            'submit #form-factura' :'onStore',
            'submit #form-detail-factura' :'onStoreItem',
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
            
            // Render Detail factura
            this.$renderDetail = this.$('#render-detail');
            this.$renderDetail.html( this.templateDetail({}) );

            this.$form = this.$('#form-factura');
            this.$formDetail = this.$('#form-detail-factura');

            this.referenceView();
            this.ready();
        },

        /**
        * Event submit factura1
        */
        submitFactura: function (e) {
            this.$form.submit();
        },

        /**
        * Event Create facturas
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
                    data.detail = window.Misc.formToJson( this.$formDetail );

                this.model.save( data, {patch: true, silent: true} );
            }   
        },  

         /**
        * reference to views
        */
        referenceView: function(){
            // Detalle factura list
            this.detalleFacturaView = new app.DetalleFacturaView({
                collection: this.detalleFactura2List,
                parameters: {
                    edit: false,
                    dataFilter: {
                        'factura1_orden': this.model.get('id')
                    }
                }
            });
        },

        onStoreItem: function(e){
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
                this.detalleFactura2List.trigger( 'store', data );
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

                // CreateFacturaView undelegateEvents
                if ( this.createFacturaView instanceof Backbone.View ){
                    this.createFacturaView.stopListening();
                    this.createFacturaView.undelegateEvents();
                }

                window.Misc.redirect( window.Misc.urlFull( Route.route('facturas.show', { facturas: resp.id})) );
            }
        }
    });
})(jQuery, this, this.document);
