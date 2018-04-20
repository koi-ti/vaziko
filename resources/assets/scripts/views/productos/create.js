/**
* Class CreateProductoView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateProductoView = Backbone.View.extend({

        el: '#productos-create',
        template: _.template( ($('#add-producto-tpl').html() || '') ),
        events: {
            'ifChanged #producto_serie': 'serieChange',
            'ifChanged #producto_metrado': 'metradoChange',
            'submit #form-productos': 'onStore'
        },
        parameters: {
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
            // Initialize
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            // Attributes
            this.$wraperForm = this.$('#render-form-producto');

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

            // References
            this.$inputSerie = this.$("#producto_serie");
            this.$inputMetrado = this.$("#producto_metrado");

            // Inputs metrado
            this.$ancho = this.$('#producto_ancho');
            this.$largo = this.$('#producto_largo');

            this.ready();
        },

        serieChange: function (e) {
            var selected = $(e.target).is(':checked');
            if( selected ) {
                this.$inputMetrado.iCheck('uncheck');
                this.$ancho.val(0).prop('disabled', true);
                this.$largo.val(0).prop('disabled', true);
            }else {
                this.$ancho.val(0).prop('disabled', true);
                this.$largo.val(0).prop('disabled', true);
            }
        },

        metradoChange: function (e) {
            var selected = $(e.target).is(':checked');
            if( selected ) {
                this.$inputSerie.iCheck('uncheck');
                this.$ancho.removeAttr('disabled');
                this.$largo.removeAttr('disabled');
            }else {
                this.$ancho.val(0).prop('disabled', true);
                this.$largo.val(0).prop('disabled', true);
            }
        },

        /**
        * Event Create Folder
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
            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();

            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();

            if( typeof window.initComponent.initSelect2 == 'function' )
                window.initComponent.initSelect2();

            if( typeof window.initComponent.initICheck == 'function' )
                window.initComponent.initICheck();
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

                window.Misc.redirect( window.Misc.urlFull( Route.route('productos.show', { productos: resp.id})) );
            }
        }
    });

})(jQuery, this, this.document);
