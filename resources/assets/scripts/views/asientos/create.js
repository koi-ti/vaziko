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
            'change input#asiento2_base': 'baseChanged',
            'submit #form-asientos': 'onStore',
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            // Attributes
            this.$modalFactura = $('#modal-facturap-component');
            this.asientoCuentasList = new app.AsientoCuentasList();

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

            this.$numero = this.$('#asiento1_numero');
            this.$form = this.$('#form-asientos');
            this.$formItem = this.$('#form-item-asiento');
            this.$inputTasa = this.$("#asiento2_tasa");
            this.$inputValor = this.$("#asiento2_valor");
            this.$inputBase = this.$("#asiento2_base");
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
        * Event Create Cuenta
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                // Prepare global data
                var data = window.Misc.formToJson( e.target );
                
                // Definir tercero
                data.tercero_nit = data.tercero_nit ? data.tercero_nit : data.asiento1_beneficiario;
                data.tercero_nombre = data.tercero_nombre ? data.tercero_nombre : data.asiento1_beneficiario_nombre;

                window.Misc.evaluateActionsAccount({
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
                                    collection: _this.asientoCuentasList,
                                    parameters: {
                                        data: data,
                                        actions: actions
                                    }
                                });
                                _this.asientoActionView.render();
                            }else{
                                // Default insert
                                _this.model.save( data, {patch: true, silent: true} );
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

                // FacturapView undelegateEvents
                if ( this.createFacturapView instanceof Backbone.View ){
                    this.createFacturapView.stopListening();
                    this.createFacturapView.undelegateEvents();
                }

                // AsientoActionView undelegateEvents
                if ( this.asientoActionView instanceof Backbone.View ){
                    this.asientoActionView.stopListening();
                    this.asientoActionView.undelegateEvents();
                }

                if ( resp.id == '' && resp.nif != '' ) {
                    // Redirect to Content Course
                    window.Misc.redirect( window.Misc.urlFull( Route.route('asientosnif.edit', { asientosnif: resp.nif}), { trigger:true }));

                }else{
                    // Redirect to Content Course
                    Backbone.history.navigate(Route.route('asientos.edit', { asientos: resp.id}), { trigger:true });
                }
            }
        }
    });

})(jQuery, this, this.document);
