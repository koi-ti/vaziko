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
            'submit #form-factura' :'onStore',
            'submit #form-detalle-factura' :'onStoreItem',
            'change .change-impuestos' :'changeImpuestos'
        },

        /**
        * Constructor Method
        */
        initialize: function () {
            // Attributes
            this.detalleFactura2List = new app.DetalleFactura2List();
            this.impuestos = {};

            // Events
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        /*
        * Render View Element
        */
        render: function () {
            var attributes = this.model.toJSON();
            this.$el.html( this.template(attributes) );

            // Declare wrappers
            this.$formdetalle = this.$('#form-detalle-factura');
            this.spinner = this.$('.spinner-main');

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
                   wrapper: this.spinner,
                   edit: true
               }
           });
        },

        changeImpuestos: function(e){
            var value = $(e.currentTarget).inputmask('unmaskedvalue'),
                key = $(e.currentTarget).attr('id');
                total =  this.detalleFactura2List.totalize().subtotal + $('#iva-create').inputmask('unmaskedvalue') - $('#rtefuente-create').inputmask('unmaskedvalue') - $('#rteica-create').inputmask('unmaskedvalue') - $('#rteiva-create').inputmask('unmaskedvalue');
                $('#total-create').html(window.Misc.currency(total))
                this.impuestos[key] = value;
        },

        /**
        * Event Create facturas
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
                    data.detalle = this.detalleFactura2List.toJSON();
                    data.impuestos = this.impuestos;

                this.model.save( data, {patch: true, silent: true} );
            }
        },

        /**
        * Event Create detalle facturas
        */
        onStoreItem: function(e){
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson(e.target);
                this.detalleFactura2List.trigger('store', data, this.$formdetalle);
            }
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if (typeof window.initComponent.initValidator == 'function')
                window.initComponent.initValidator();

            if (typeof window.initComponent.initToUpper == 'function')
                window.initComponent.initToUpper();

            if (typeof window.initComponent.initDatePicker == 'function')
                window.initComponent.initDatePicker();

            if (typeof window.initComponent.initSelect2 == 'function')
                window.initComponent.initSelect2();
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function (model, xhr, opts) {
            window.Misc.setSpinner(this.spinner);
        },

        /**
        * response of the server
        */
        responseServer: function (model, resp, opts) {
            window.Misc.removeSpinner(this.spinner);
            if (!_.isUndefined(resp.success)) {
                // response success or error
                var text = resp.success ? '' : resp.errors;
                if (_.isObject(resp.errors)) {
                    text = window.Misc.parseErrors(resp.errors);
                }

                if (!resp.success) {
                    alertify.error(text);
                    return;
                }

                // Redirect if ok
                window.Misc.redirect(window.Misc.urlFull(Route.route('facturas.show', {facturas: resp.id})));
            }
        }
    });
})(jQuery, this, this.document);
