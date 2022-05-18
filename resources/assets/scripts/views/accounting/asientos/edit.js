/**
* Class EditAsientoView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.EditAsientoView = Backbone.View.extend({

        el: '#asientos-create',
        template: _.template( ($('#add-asiento-tpl').html() || '') ),
        events: {
            'submit #form-asientos': 'onStore',
            'submit #form-item-asiento': 'onStoreItem',
            'change input#asiento2_base': 'baseChanged',
            'change .round-module': 'roundModule'
        },

        /**
        * Constructor Method
        */
        initialize: function () {
            // Attributes
            this.asientoCuentasList = new app.AsientoCuentasList();

            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        /*
        * Render View Element
        */
        render: function () {
            // Attributes
            var attributes = this.model.toJSON();
                attributes.edit = true;
            this.$el.html(this.template(attributes));

            // Reference wrappers
            this.$numero = this.$('#asiento1_numero');
            this.$form = this.$('#form-asientos');
            this.$formItem = this.$('#form-item-asiento');
            this.$inputTasa = this.$("#asiento2_tasa");
            this.$inputValor = this.$("#asiento2_valor");
            this.$inputBase = this.$("#asiento2_base");
            this.$inputDocumento = this.$("#asiento1_documento");
            this.roundempresa = this.$("#empresa_round").val();
            this.spinner = this.$('.spinner-main');

            // If tipo consecutivo A:automatico, M:manual
            if (this.model.get('documento_tipo_consecutivo') == 'A') {
                this.$numero.prop('readonly', true);
            }

            // Reference views
            this.referenceViews();
            this.ready();
		},

        /**
        * reference to views
        */
        referenceViews: function () {
            // Detalle asiento list
            this.cuentasListView = new app.AsientoCuentasListView({
                collection: this.asientoCuentasList,
                parameters: {
                    wrapper: this.spinner,
                    edit: true,
                    dataFilter: {
                        asiento: this.model.get('id')
                    }
                }
            });
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if (typeof window.initComponent.initToUpper == 'function')
                window.initComponent.initToUpper();

            if (typeof window.initComponent.initICheck == 'function')
                window.initComponent.initICheck();

            if (typeof window.initComponent.initSelect2 == 'function')
                window.initComponent.initSelect2();

            if (typeof window.initComponent.initValidator == 'function')
                window.initComponent.initValidator();

            if (typeof window.initComponent.initDatePicker == 'function')
                window.initComponent.initDatePicker();

            if (typeof window.initComponent.initInputMask == 'function')
                window.initComponent.initInputMask();
        },

        /**
        * Event Create Cuenta
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson(e.target);
                    data.cuentas = this.asientoCuentasList.toJSON();
                this.model.save( data, {wait: true, patch: true, silent: true});
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
                    data.asiento = this.model.get('id');
                    data.tercero_nit = (data.tercero_nit || this.model.get('tercero_nit'));
                    data.tercero_nombre = (data.tercero_nombre || this.model.get('tercero_nombre'));
                    data.round_module = this.roundempresa;

                // Evaluate account
                window.Misc.evaluateActionsAccount({
                    'data': data,
                    'wrap': this.spinner,
                    'callback': (function (_this) {
                        return function (actions) {
                            if (Array.isArray(actions) && actions.length > 0) {
                                // Open AsientoActionView
                                if (_this.asientoActionView instanceof Backbone.View) {
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
                            } else {
                                // Default insert
                                _this.asientoCuentasList.trigger('store', data);
                                window.Misc.clearForm(_this.$formItem);
                            }
                        }
                    })(this)
                });
            }
        },

        /**
        * Change base
        */
        baseChanged: function (e) {
            var tasa = this.$inputTasa.val(),
                ica = this.$inputTasa.data('ica'),
                base = this.$inputBase.inputmask('unmaskedvalue'),
                _this = this;

            // Set valor
            if (!_.isUndefined(tasa) && !_.isNull(tasa) && tasa > 0) {
                if (parseInt(this.roundempresa)) {
                    this.$inputValor.val(Math.round( (tasa * base) / (ica ? 1000 : 100)));
                } else {
                    this.$inputValor.val((tasa * base) / (ica ? 1000 : 100));
                }
            } else {
                // Case without plancuentas_tasa
                this.$inputValor.val('');
            }
        },

        /**
        * Change Valor
        */
        roundModule: function (e) {
            var valor = this.$(e.currentTarget).inputmask('unmaskedvalue');

            if (parseInt(this.roundempresa)) {
                this.$(e.currentTarget).val(Math.round(valor));
            }
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
                if (_.isObject( resp.errors )) {
                    text = window.Misc.parseErrors(resp.errors);
                }

                if (!resp.success) {
                    alertify.error(text);
                    return;
                }

                // Redirect to show view
                window.Misc.redirect(window.Misc.urlFull( Route.route('asientos.show', {asientos: resp.id})));
            }
        }
    });

})(jQuery, this, this.document);
