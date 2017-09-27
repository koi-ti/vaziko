/**
* Class EditAsientoNifView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.EditAsientoNifView = Backbone.View.extend({

        el: '#asientosnif-create',
        template: _.template( ($('#add-asienton-tpl').html() || '') ),
        templateFp: _.template( ($('#add-rfacturap-tpl').html() || '') ),
        events: {
            'change select#asienton1_documento': 'documentoChanged',
            'submit #form-item-asienton': 'onStoreItem',
            'change input#asienton2_base': 'baseChanged',
            'click .submit-asienton': 'submitAsiento',
            'submit #form-asientosn': 'onStore',
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            // Attributes
            this.asientoNifCuentasList = new app.AsientoNifCuentasList();

            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        /*
        * Render View Element
        */
        render: function() {

            var attributes = this.model.toJSON();
            attributes.edit = true;
            this.$el.html( this.template(attributes) );

            this.$numero = this.$('#asienton1_numero');
            this.$form = this.$('#form-asientosn');
            this.$formItem = this.$('#form-item-asienton');
            this.$inputTasa = this.$("#asienton2_tasa");
            this.$inputValor = this.$("#asienton2_valor");
            this.$inputBase = this.$("#asienton2_base");
            this.$inputDocumento = this.$("#asienton1_documento");
            this.spinner = this.$('#spinner-main');

            // Reference views
            this.referenceViews();

            // to fire plugins
            this.ready();

            // to change document
            if(this.model.get('documento_tipo_consecutivo') == 'A'){
                this.$inputDocumento.change();
            }
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

            if( typeof window.initComponent.initInputMask == 'function' )
                window.initComponent.initInputMask();
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            // Detalle asiento list
            this.cuentasListView = new app.AsientoNifCuentasListView({
                collection: this.asientoNifCuentasList,
                parameters: {
                    wrapper: this.spinner,
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
                        window.Misc.setSpinner( _this.spinner );
                    }
                })
                .done(function(resp) {
                    window.Misc.removeSpinner( _this.spinner );
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
                    window.Misc.removeSpinner( _this.spinner );
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
                this.model.save( data, {patch: true, silent: true} );
            }
        },

        /**
        * Event add item Asiento Cuentas
        */
        onStoreItem: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                // Prepare global data
                var data = window.Misc.formToJson( e.target );
                data.asienton1_id = this.model.get('id');

                // Definir tercero
                data.tercero_nit = data.tercero_nit ? data.tercero_nit : this.model.get('tercero_nit');
                data.tercero_nombre = data.tercero_nombre ? data.tercero_nombre : this.model.get('tercero_nombre');

                // Default insert
                    // this.asientoNifCuentasList.trigger( 'store', data );
                    // window.Misc.clearForm( this.$formItem );  
                // Evaluate account
                window.Misc.evaluateActionsAccountNif({
                    'data': data,
                    'wrap': this.spinner,
                    'callback': (function (_this) {
                        return function ( actions )
                        {
                            if( Array.isArray( actions ) && actions.length > 0 ) {
                                // Open AsientoActionView
                                if ( _this.asientoActionView instanceof Backbone.View ){
                                    _this.asientoActionView.stopListening();
                                    _this.asientoActionView.undelegateEvents();
                                }

                                _this.asientoActionView = new app.AsientoActionView({
                                    model: _this.model,
                                    collection: _this.asientoNifCuentasList,
                                    parameters: {
                                        data: data,
                                        actions: actions
                                    }
                                });
                                _this.asientoActionView.render();
                            }else{
                                // Default insert
                                _this.asientoNifCuentasList.trigger( 'store', data );
                                window.Misc.clearForm( _this.$formItem );   
                            }
                        }
                    })(this)
                });
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

                // Redirect to show view
                window.Misc.redirect( window.Misc.urlFull( Route.route('asientosnif.edit', { asientosnif: resp.id}) ) );
            }
        }
    });

})(jQuery, this, this.document);
