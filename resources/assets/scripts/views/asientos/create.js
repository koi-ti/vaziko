/**
* Class CreateAsientoView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateAsientoView = Backbone.View.extend({

        el: '#asientos-create',
        template: _.template( ($('#add-asiento-tpl').html() || '') ),
        events: {
            'change select#asiento1_documento': 'documentoChanged',
            'click .submit-asiento': 'submitAsiento',
            'submit #form-item-asiento': 'onStoreItem',
            'submit #form-asientos': 'onStore'
        },

        /**
        * Constructor Method
        */
        initialize : function() {   
            // Attributes 
            this.$wraperForm = this.$('#render-form-asientos');

            this.asientoCuentasList = new app.AsientoCuentasList();

            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        /*
        * Render View Element
        */
        render: function() {

            var attributes = this.model.toJSON();
            this.$wraperForm.html( this.template(attributes) );
            
            this.$numero = this.$('#asiento1_numero');
            this.$form = this.$('#form-asientos');

            // Prepare account detailt
            this.getCuentasDetalle();

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

            if( typeof window.initComponent.initSelect2 == 'function' )
                window.initComponent.initSelect2();  
        },

        documentoChanged: function(e) {
            var _this = this,
                documento = $(e.currentTarget).val();

            // Clear numero
            _this.$numero.val('');

            if(!_.isUndefined(documento) && !_.isNull(documento) && documento != '') {
                $.ajax({
                    url: window.Misc.urlFull(Route.route('documentos.show', { documentos: documento })),
                    type: 'GET',
                    beforeSend: function() {
                        window.Misc.setSpinner( _this.el );
                    }
                })
                .done(function(resp) {  
                    window.Misc.removeSpinner( _this.el );
                    if( _.isObject( resp ) ) {
                        if(!_.isUndefined(resp.documento_tipo_consecutivo) && !_.isNull(resp.documento_tipo_consecutivo)) {
                            _this.$numero.val(resp.documento_consecutivo + 1);
                            if(resp.documento_tipo_consecutivo == 'M') {
                                _this.$numero.prop('readonly', false);
                            }else if (resp.documento_tipo_consecutivo == 'A'){
                                _this.$numero.prop('readonly', true);
                            }
                        }
                    }
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    window.Misc.removeSpinner( _this.el );
                    alertify.error(thrownError);
                });
            }
        },

        /**
        * Event submit Asiento
        */
        submitAsiento: function (e) {
            this.$form.submit();
        },

        /**
        * Event Create Cuenta
        */
        onStore: function (e) {

            if (!e.isDefaultPrevented()) {
            
                e.preventDefault();
                var data = window.Misc.formToJson( e.target );
                data.cuentas = this.asientoCuentasList.toJSON()

                this.model.save( data, {patch: true, silent: true} );                
            }
        },

        /**
        *  Get asiento cuentas
        */
        getCuentasDetalle: function () {
            var cuentasView = new app.AsientoCuentasListView({
                collection: this.asientoCuentasList,
                parameters: {
                    wrapper: this.el,
                    edit: true
                }
            });
        },

        /**
        * Event add item Asiento Cuentas
        */
        onStoreItem: function (e) {
            // e.preventDefault();             

            // console.log( this.$('#asiento2_valor').val() );
            // this.$('#asiento2_valor').unmask();
            // console.log('-> ', this.$('#asiento2_valor').inputmask('unmaskedvalue') );
            // console.log( this.$('#asiento2_valor').val('jhgjhg') );

            // this.$('#asiento2_valor').inputmask('unmaskedvalue');
            // this.$("[data-currency]").inputmask('unmaskedvalue');

            this.$('#asiento2_valor').inputmask('unmaskedvalue');            
            if (!e.isDefaultPrevented()) {
            
                e.preventDefault();             
                this.asientoCuentasList.trigger( 'store', this.$(e.target) );
            }            
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

                window.Misc.redirect( window.Misc.urlFull( Route.route('asientos.show', { asientos: resp.id})) );
            }
        }
    });

})(jQuery, this, this.document);
