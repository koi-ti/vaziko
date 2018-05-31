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
            'click .submit-factura' :'submitFactura',
            'submit #form-factura' :'onStore',
            'submit #form-detail-factura' :'onStoreItem',
            'change #factura1_fecha_vencimiento' :'changeVencimiento'
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            // Attributes
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
            this.$el.html( this.template(attributes) );

            this.$form = this.$('#form-factura');
            this.$formdetail = this.$('#form-detail-factura');

            // wrapper $detail
            this.$wrapperdetail = this.$('#wrapper-detalle-factura');
            this.$fechavencimiento = this.$('#factura1_fecha_vencimiento');
            this.formapago = this.$('#tercero_formapago');
            this.spinner = this.$('#spinner-main');

            this.referenceView();
            this.ready();
        },

        /**
        * reference to views
        */
        referenceView: function(){
           // Detalle factura list
           this.detalleFacturaView = new app.DetalleFacturaView({
               collection: this.detalleFactura2List,
               parameters: {
                   wrapper: this.$wrapperdetail,
                   form: this.$formdetail,
                   edit: true,
                   dataFilter: {
                       factura1_orden: this.model.get('id')
                   }
               }
           });
        },

        changeVencimiento: function(e){
            e.preventDefault();

            var formapago = parseInt( this.formapago.val() );
            if( formapago > 0){
                var fecha = this.$(e.currentTarget).val().split('-');

                var nuevafecha = new Date(fecha[0], fecha[1]-1, fecha[2]);
                    nuevafecha.setDate(nuevafecha.getDate() + formapago);

                    year = nuevafecha.getFullYear();
                    month = nuevafecha.getMonth()+1;
                    day = nuevafecha.getDate();

                this.$fechavencimiento.val( year+'-'+month+'-'+day );
            }
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
                    data.detalle = this.detalleFactura2List.toJSON();

                this.model.save( data, {patch: true, silent: true} );
            }
        },

        /**
        * Event Create detalle facturas
        */
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
            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();

            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();

            if( typeof window.initComponent.initDatePicker == 'function' )
                window.initComponent.initDatePicker();

            if( typeof window.initComponent.initSelect2 == 'function' )
                window.initComponent.initSelect2();
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
