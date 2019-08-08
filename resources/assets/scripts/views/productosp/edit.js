/**
* Class EditProductopView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.EditProductopView = Backbone.View.extend({

        el: '#productosp-create',
        template: _.template( ($('#add-productop-tpl').html() || '') ),
        events: {
            'ifChanged .change-productop-abierto-koi-component': 'changedAbierto',
            'ifChanged .change-productop-cerrado-koi-component': 'changedCerrado',
            'ifChanged .change-productop-3d-koi-component': 'changed3d',
            'change #productop_tipoproductop': 'changeTypeProduct',
            'click .submit-productosp': 'submitProductop',
            'submit #form-productosp': 'onStore',
            'submit #form-productosp2': 'onStoreTip',
            'submit #form-productosp3': 'onStoreArea',
            'submit #form-productosp4': 'onStoreMaquina',
            'submit #form-productosp5': 'onStoreMaterial',
            'submit #form-productosp6': 'onStoreAcabado'
        },
        parameters: {},

        /**
        * Constructor Method
        */
        initialize: function (opts) {
            // Initialize
            if (opts !== undefined && _.isObject(opts.parameters))
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            this.tipsList = new app.TipsList();
            this.areasList = new app.AreasList();
            this.maquinasList = new app.MaquinasList();
            this.materialesList = new app.MaterialesList();
            this.acabadosList = new app.AcabadosList();

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
                attributes.edit = true;

            this.$el.html(this.template(attributes));
            this.$form = this.$('#form-productosp');
            this.spinner = this.$('#spinner-main');

            this.$inputAbierto = $('#productop_abierto');
            this.$inputAbiertoAncho = $('#productop_ancho_med');
            this.$inputAbiertoAlto = $('#productop_alto_med');

            this.$inputCerrado = $('#productop_cerrado');
            this.$inputCerradoAncho = $('#productop_c_med_ancho');
            this.$inputCerradoAlto = $('#productop_c_med_alto');

            this.$input3d = $('#productop_3d');
            this.$input3dAncho = $('#productop_3d_ancho_med');
            this.$input3dAlto = $('#productop_3d_alto_med');
            this.$input3dProfundidad = $('#productop_3d_profundidad_med');

            this.$subtypeproduct = this.$('#productop_subtipoproductop');

            // Reference views && ready
            this.referenceViews();
            this.ready();
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            // Tips list
            this.tipsListView = new app.TipsListView( {
                collection: this.tipsList,
                parameters: {
                    edit: true,
                    wrapper: this.$('#wrapper-productop-tips'),
                    dataFilter: {
                        productop_id: this.model.get('id')
                    }
               }
            });

            // Areas list
            this.areasListView = new app.AreasListView( {
                collection: this.areasList,
                parameters: {
                    edit: true,
                    wrapper: this.$('#wrapper-productop-areas'),
                    dataFilter: {
                        productop_id: this.model.get('id')
                    }
               }
            });

            // Areas list
            this.maquinasListView = new app.MaquinasListView( {
                collection: this.maquinasList,
                parameters: {
                    edit: true,
                    wrapper: this.$('#wrapper-productop-maquinas'),
                    dataFilter: {
                        productop_id: this.model.get('id')
                    }
               }
            });

            // Materiales list
            this.materialesListView = new app.MaterialesListView( {
                collection: this.materialesList,
                parameters: {
                    edit: true,
                    wrapper: this.$('#wrapper-productop-materiales'),
                    dataFilter: {
                        productop_id: this.model.get('id')
                    }
               }
            });

            // Acabados list
            this.acabadosListView = new app.AcabadosListView( {
                collection: this.acabadosList,
                parameters: {
                    edit: true,
                    wrapper: this.$('#wrapper-productop-acabados'),
                    dataFilter: {
                        productop_id: this.model.get('id')
                    }
               }
            });
        },

        /**
        * Event submit productop
        */
        submitProductop: function (e) {
            this.$form.submit();
        },

        /**
        * Event Create Folder
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
                this.model.save(data, {wait: true, patch: true, silent: true});
            }
        },

        changedAbierto: function (e) {
            var selected = $(e.target).is(':checked');
            if (selected) {
                this.$input3d.iCheck('uncheck');
                this.$input3d.iCheck('disable');
                this.$input3dAncho.prop('disabled', true).val('');
                this.$input3dAlto.prop('disabled', true).val('');
                this.$input3dProfundidad.prop('disabled', true).val('');
            } else {
                this.$input3d.iCheck('enable');
                this.$input3dAncho.prop('disabled', false);
                this.$input3dAlto.prop('disabled', false);
                this.$input3dProfundidad.prop('disabled', false);
            }
        },

        changedCerrado: function (e) {
            var selected = $(e.target).is(':checked');
            if (selected) {
                this.$input3d.iCheck('uncheck');
                this.$input3d.iCheck('disable');
                this.$input3dAncho.prop('disabled', true).val('');
                this.$input3dAlto.prop('disabled', true).val('');
                this.$input3dProfundidad.prop('disabled', true).val('');
            } else {
                this.$input3d.iCheck('enable');
                this.$input3dAncho.prop('disabled', false);
                this.$input3dAlto.prop('disabled', false);
                this.$input3dProfundidad.prop('disabled', false);
            }
        },

        changed3d: function (e) {
            var selected = $(e.target).is(':checked');
            if (selected) {
                // Abierto
                this.$inputAbierto.iCheck('uncheck');
                this.$inputAbierto.iCheck('disable');
                this.$inputAbiertoAncho.prop('disabled', true).val('');
                this.$inputAbiertoAlto.prop('disabled', true).val('');

                // Cerrado
                this.$inputCerrado.iCheck('uncheck');
                this.$inputCerrado.iCheck('disable');
                this.$inputCerradoAncho.prop('disabled', true).val('');
                this.$inputCerradoAlto.prop('disabled', true).val('');
            } else {
                // Abierto
                this.$inputAbierto.iCheck('enable');
                this.$inputAbiertoAncho.prop('disabled', false);
                this.$inputAbiertoAlto.prop('disabled', false);

                // Cerrado
                this.$inputCerrado.iCheck('enable');
                this.$inputCerradoAncho.prop('disabled', false);
                this.$inputCerradoAlto.prop('disabled', false);
            }
        },

        changeTypeProduct: function (e) {
            var typeproduct = this.$(e.currentTarget).val(),
                _this = this;

            if (typeof(typeproduct) !== 'undefined' && !_.isUndefined(typeproduct) && !_.isNull(typeproduct) && typeproduct != '') {
                $.ajax({
                    url: window.Misc.urlFull(Route.route('subtipoproductosp.index', {typeproduct: typeproduct})),
                    type: 'GET',
                    beforeSend: function () {
                        window.Misc.setSpinner(_this.spinner);
                    }
                })
                .done(function (resp) {
                    window.Misc.removeSpinner(_this.spinner);
                    _this.$subtypeproduct.empty().val(0);
                    _this.$subtypeproduct.append("<option value=></option>");
                    _.each(resp, function (item) {
                        _this.$subtypeproduct.append("<option value=" + item.id + ">" + item.subtipoproductop_nombre + "</option>");
                    });

                })
                .fail(function (jqXHR, ajaxOptions, thrownError) {
                    window.Misc.removeSpinner(_this.spinner);
                    alertify.error(thrownError);
                });
            } else {
                this.$subtypeproduct.empty().val(0);
            }
        },

        /**
        * Event Create Tip
        */
        onStoreTip: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                // Prepare global data
                var data = window.Misc.formToJson( e.target );
                this.tipsList.trigger('store', data);
            }
        },

        /**
        * Event Create area
        */
        onStoreArea: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                // Prepare global data
                var data = window.Misc.formToJson( e.target );
                this.areasList.trigger('store', data);
            }
        },

        /**
        * Event Create maquina
        */
        onStoreMaquina: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                // Prepare global data
                var data = window.Misc.formToJson( e.target );
                this.maquinasList.trigger('store', data);
            }
        },

        /**
        * Event Create material
        */
        onStoreMaterial: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                // Prepare global data
                var data = window.Misc.formToJson( e.target );
                this.materialesList.trigger('store', data);
            }
        },

        /**
        * Event Create acabado
        */
        onStoreAcabado: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                // Prepare global data
                var data = window.Misc.formToJson( e.target );
                this.acabadosList.trigger('store', data);
            }
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if (typeof window.initComponent.initToUpper == 'function')
                window.initComponent.initToUpper();

            if (typeof window.initComponent.initSelect2 == 'function')
                window.initComponent.initSelect2();

            if (typeof window.initComponent.initICheck == 'function')
                window.initComponent.initICheck();

            if (typeof window.initComponent.initValidator == 'function')
                window.initComponent.initValidator();
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

                // Redirect to edit productop
                window.Misc.redirect(window.Misc.urlFull(Route.route('productosp.show', {productosp: resp.id})));
            }
        }
    });

})(jQuery, this, this.document);
