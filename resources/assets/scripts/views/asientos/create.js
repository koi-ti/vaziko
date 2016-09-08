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
        templateFp: _.template( ($('#add-rfacturap-tpl').html() || '') ),
        events: {
            'change select#asiento1_documento': 'documentoChanged',
            'click .submit-asiento': 'submitAsiento',
            'click .pre-save-asiento': 'submitPreSaveAsiento',
            'submit #form-item-asiento': 'onStoreItem',
            'submit #form-create-facturap-component': 'onStoreFacturap',
            'change input#asiento2_base': 'baseChanged',
            'submit #form-asientos': 'onStore',
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            // Attributes
            this.$modalFactura = $('#modal-facturap-component');
            this.$wraperForm = this.$('#render-form-asientos');

            this.asientoCuentasList = new app.AsientoCuentasList();

            // Pre-save default false
            this.preSave = false;

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

            this.$numero = this.$('#asiento1_numero');
            this.$form = this.$('#form-asientos');
            this.$formItem = this.$('#form-item-asiento');
            this.$inputTasa = this.$("#asiento2_tasa");
            this.$inputValor = this.$("#asiento2_valor");
            this.$inputBase = this.$("#asiento2_base");

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

            if( typeof window.initComponent.initSelect2 == 'function' )
                window.initComponent.initSelect2();

            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();

            if( typeof window.initComponent.initDatePicker == 'function' )
                window.initComponent.initDatePicker();
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            // Detalle asiento list
            this.cuentasListView = new app.AsientoCuentasListView({
                collection: this.asientoCuentasList,
                parameters: {
                    wrapper: this.el,
                    edit: true,
                    dataFilter: {
                        'asiento': this.model.get('id')
                    }
                }
            });
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
        * Event submit Asiento (Pre-guardado)
        */
        submitPreSaveAsiento: function (e) {
            this.preSave = true;
            this.$form.submit();
        },

        /**
        * Event submit Asiento
        */
        submitAsiento: function (e) {
            this.preSave = false;
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
                data.preguardado = this.preSave;

                this.model.save( data, {patch: true, silent: true} );
            }
        },

        /**
        * Event Create Cuenta
        */
        onStoreFacturap: function (e) {

            if (!e.isDefaultPrevented()) {

                e.preventDefault();

                var data = $.extend({}, window.Misc.formToJson( e.target ), window.Misc.formToJson( this.$formItem ));
                data.asiento2_base = this.$inputBase.inputmask('unmaskedvalue');
                data.asiento2_valor = this.$inputValor.inputmask('unmaskedvalue');

                this.asientoCuentasList.trigger( 'store', data );

                // Open hide facturap
                this.$modalFactura.modal('hide');
            }
        },

        /**
        * Event add item Asiento Cuentas
        */
        onStoreItem: function (e) {
            var _this = this;

            if (!e.isDefaultPrevented()) {

                e.preventDefault();
                var data = window.Misc.formToJson( e.target );
                this.asientoCuentasList.trigger( 'store', data );

                // Search plancuenta
                // $.ajax({
                //     url: window.Misc.urlFull(Route.route('plancuentas.search')),
                //     type: 'GET',
                //     data: { plancuentas_cuenta: data.plancuentas_cuenta },
                //     beforeSend: function() {
                //         window.Misc.setSpinner( _this.el );
                //     }
                // })
                // .done(function(resp) {
                //     window.Misc.removeSpinner( _this.el );
                //     if(resp.success) {
                //         // Evaluate others actions
                //         // Facturap
                //         // && !_.isUndefined(resp.plancuentas_tipo) && !_.isNull(resp.plancuentas_tipo) && resp.plancuentas_tipo == 'P'
                //         if(!_.isUndefined(resp.plancuentas_naturaleza) && !_.isNull(resp.plancuentas_naturaleza) && resp.plancuentas_naturaleza == 'C') {
                //             _this.$modalFactura.find('.content-modal').html( _this.templateFp({ }) );
                //             // to fire plugins
                //             _this.ready();
                //             // Open modal facturap
                //             _this.$modalFactura.modal('show');

                //         }else{
                //             _this.asientoCuentasList.trigger( 'store', data );
                //         }
                //     }
                // })
                // .fail(function(jqXHR, ajaxOptions, thrownError) {
                //     window.Misc.removeSpinner( _this.el );
                //     alertify.error(thrownError);
                // });
            }
        },

        /**
        * Change base
        */
        baseChanged: function(e) {
            var _this = this;

            var tasa = this.$inputTasa.val();
            var base = this.$inputBase.inputmask('unmaskedvalue');

            // Set valor
            if(!_.isUndefined(tasa) && !_.isNull(tasa) && tasa > 0) {
                this.$inputValor.val( (tasa * base) / 100 );
            }else{
                // Case without plancuentas_tasa
                this.$inputValor.val('');
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
