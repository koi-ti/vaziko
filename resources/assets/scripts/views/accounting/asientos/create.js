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
            'submit #form-asientos': 'onStore',
            'change select#asiento1_documento': 'documentoChanged',
            'change input#asiento2_base': 'baseChanged',
            'change .round-module': 'roundModule'
        },

        /**
        * Constructor Method
        */
        initialize: function () {
            // Events listener
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        /*
        * Render View Element
        */
        render: function () {
            // Attributes
            var attributes = this.model.toJSON();
                attributes.edit = false;
            this.$el.html(this.template(attributes));

            // Reference wrappers
            this.$numero = this.$('#asiento1_numero');
            this.$form = this.$('#form-asientos');
            this.$formItem = this.$('#form-item-asiento');
            this.$inputTasa = this.$("#asiento2_tasa");
            this.$inputValor = this.$("#asiento2_valor");
            this.$inputBase = this.$("#asiento2_base");
            this.spinner = this.$('.spinner-main');
            this.roundempresa = this.$("#empresa_round").val();

            // Fire plugins
            this.ready();
        },

        /**
        * Event change documetno
        */
        documentoChanged: function (e) {
            var documento = $(e.currentTarget).val(),
                _this = this;

            // Clear numero
            this.$numero.val('');

            // If documento exists
            if (documento) {
                window.Misc.setSpinner(this.spinner);
                $.get(window.Misc.urlFull(Route.route('search.documentos', {documento: documento})), function (resp) {
                    window.Misc.removeSpinner(_this.spinner);
                    if (resp) {
                        if (!_.isUndefined(resp.documento_tipo_consecutivo) && !_.isNull(resp.documento_tipo_consecutivo)) {
                            _this.$numero.val(parseInt(resp.documento_consecutivo) + 1 );
                            if (resp.documento_tipo_consecutivo == 'M') {
                                _this.$numero.prop('readonly', false);
                            } else if (resp.documento_tipo_consecutivo == 'A') {
                                _this.$numero.prop('readonly', true);
                            }
                        }
                    }
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
                    data.tercero_nit = (data.tercero_nit || data.asiento1_beneficiario);
                    data.tercero_nombre = (data.tercero_nombre || data.asiento1_beneficiario_nombre);
                    data.round_module = this.roundempresa;

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
                                    parameters: {
                                        data: data,
                                        actions: actions
                                    }
                                });
                                _this.asientoActionView.render();
                            } else {
                                // Default insert
                                _this.model.save(data, {wait: true, patch: true, silent: true});
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

        roundModule: function (e) {
            var valor = this.$(e.currentTarget).inputmask('unmaskedvalue');

            if (parseInt(this.roundempresa)) {
                this.$(e.currentTarget).val(Math.round(valor));
            }
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

                // Redirect to Content Course
                window.Misc.redirect(window.Misc.urlFull(Route.route('asientos.edit', {asientos: resp.id})));
            }
        }
    });

})(jQuery, this, this.document);
