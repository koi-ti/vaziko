/**
* Class AsientoActionView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.AsientoActionView = Backbone.View.extend({

        el: '#asiento-content',
        // Produccion
        templateOrdenp: _.template( ($('#searchordenp-asiento-tpl').html() || '') ),
        // Proveedores
        templateFacturap: _.template( ($('#rfacturap-asiento-tpl').html() || '') ),
        templateAddFacturap: _.template( ($('#add-rfacturap-asiento-tpl').html() || '') ),
        templateCuotasFacturap: _.template( ($('#add-rfacturap2-asiento-tpl').html() || '') ),
        // Cartera
        templateCartera: _.template( ($('#rcartera-asiento-tpl').html() || '') ),
        templateCommentsFactura: _.template( ($('#add-comments-tpl').html() || '') ),
        // Inventario
        templateInventario: _.template( ($('#add-inventario-asiento-tpl').html() || '') ),
        templateAddItemRollo: _.template( ($('#add-itemrollo-asiento-tpl').html() || '') ),
        templateChooseItemsRollo: _.template( ($('#choose-itemrollo-asiento-tpl').html() || '') ),
        templateAddSeries: _.template( ($('#add-series-asiento-tpl').html() || '') ),
        // Editar
        templateUpdate: _.template( ($('#edit-info-asiento2-tpl').html() || '') ),
        events: {
            // Produccion
            'submit #form-create-ordenp-asiento-component-source': 'onStoreItemOrdenp',
            // Proveedores
            'submit #form-create-asiento-component-source': 'onStoreItemFacturap',
            'change input#facturap1_factura': 'facturapChanged',
            // Cartera
            'submit #form-create-cartera-component-source': 'onStoreItemFactura',
            'change .factura-koi-component': 'facturaChange',
            // Inventario
            'submit #form-create-inventario-asiento-component-source': 'onStoreItemInventario',
            'change .evaluate-producto-movimiento-asiento': 'evaluateProductoInventario',
            // Update
            'change .round-module': 'roundModule',
            'submit #form-edit-asiento-component-source': 'onStoreItem',

            'hidden.bs.modal': 'closeModal'
        },
        parameters: {
            data: {},
            actions: {}
        },

        /**
        * Constructor Method
        */
        initialize: function (opts) {
            // extends parameters
            if (opts !== undefined && _.isObject(opts.parameters))
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            // Reference modals (update, ordenp, facturap, inventario, factura)
            this.$modalUp = this.$('#modal-asiento-edit-component');
            this.$modalOp = this.$('#modal-asiento-ordenp-component');
            this.$modalFp = this.$('#modal-asiento-facturap-component');
            this.$modalIn = this.$('#modal-asiento-inventario-component');
            this.$modalCt = this.$('#modal-asiento-cartera-component');

            // Initialize collections (cuotas, rollos, series, pendientes, update)
            this.cuotasFPList = new app.CuotasFPList();
            this.itemRolloINList = new app.ItemRolloINList();
            this.productoSeriesINList = new app.ProductoSeriesINList();
            this.detalleFactura4List = new app.DetalleFactura4List();

			// Events Listeners
            this.listenTo( this.cuotasFPList, 'reset', this.addAllCuotasFacturap );
            this.listenTo( this.itemRolloINList, 'reset', this.addAllItemRolloInventario );

            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.collection, 'sync', this.responseServer );
        },

        /*
        * Render View Element
        */
        render: function () {
    		this.runAction();
		},

		/**
        * Run actions
        */
        runAction: function () {
            var resp = this.evaluateNextAction(),
        		_this = this,
	            stuffToDo = {
	                'facturap': function () {
	                    _this.$modalFp.find('.content-modal').empty().html(_this.templateFacturap(_this.parameters.data));

	                    // Reference facturap
	                   	_this.referenceFacturap();
	                },

                    'cartera': function () {
                        _this.$modalCt.find('.content-modal').empty().html(_this.templateCartera(_this.parameters.data));

                        // Reference cartera
                        _this.referenceCartera();
                    },

	                'ordenp': function () {
                        _this.$modalOp.find('.content-modal').empty().html(_this.templateOrdenp(_this.parameters.data));

                        // Reference ordenp
                        _this.referenceOrdenp();
                    },

                    'inventario': function () {
                        _this.$modalIn.find('.content-modal').empty().html(_this.templateInventario(_this.parameters.data));

	                 	// Reference inventario
	            		_this.referenceInventario();
	                },

                    'update': function () {
                        _this.$modalUp.find('.modal-title').text(_this.parameters.data.title);
                        _this.$modalUp.find('.content-modal').empty().html(_this.templateUpdate(_this.model.toJSON()));

                        // Reference update collections
                        _this.referenceUpdate();
                    },

	                'store': function () {
                        _this.onStoreItem();
	                }
	            };

            if (stuffToDo[resp.action]) {
                stuffToDo[resp.action]();
            }
        },

        /**
        * Evaluate first action account
        */
        evaluateNextAction: function () {
            for (var index = this.parameters.actions.length - 1; index >= 0; --index) {
                action = this.parameters.actions[index];

                if (!action.success) {
                    return action;
                }
            }
            return {action: 'store'};
        },

        /**
        * Set success action
        */
        setSuccessAction: function (action) {
            for (var index = this.parameters.actions.length - 1; index >= 0; --index) {
                item = this.parameters.actions[index];

                if (item.action == action) {
                    item.success = true;
                }
            }
        },

        /**
        * is last action
        */
        isLastAction: function (action) {
            for (var index = this.parameters.actions.length - 1; index >= 0; --index) {
                item = this.parameters.actions[index];

                if (!item.success && item.action != action) {
                    return false;
                }
            }
            return true;
        },

        /**
        * Validate action item asiento2 (facturap, ordenp, inventario, cartera)
        */
        validateAction: function (options) {
            options || (options = {});

            var defaults = {
                    'callback': null,
                    'action': null
                },
                data = {},
                settings = {}
                _this = this;

            settings = $.extend({}, defaults, options);

            // Prepare global data
            data.action = settings.action;
            data = $.extend({}, this.parameters.data, data);

            // Prepare global route
            _this.url = window.Misc.urlFull(Route.route('asientos.detalle.validate'));

            if (_.has(data, "plancuentasn_cuenta"))
                _this.url = window.Misc.urlFull(Route.route('asientosnif.detalle.validate'));

            // Validate action
            $.ajax({
                url: _this.url,
                type: 'POST',
                data: data,
                beforeSend: function() {
                    window.Misc.setSpinner(_this.$wraper);
                }
            })
            .done(function (resp) {
                window.Misc.removeSpinner(_this.$wraper);
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

                    // return callback
                    if (({}).toString.call(settings.callback).slice(8,-1) === 'Function')
                        settings.callback( resp );
                }

            })
            .fail(function (jqXHR, ajaxOptions, thrownError) {
                window.Misc.removeSpinner( settings.wrap );
                alertify.error(thrownError);
            });
        },

        /**
        * Reference facturap
        */
        referenceFacturap: function () {
            this.$wraper = this.$('#modal-asiento-wrapper-facturap');
            this.$wraperFormFp = this.$('#content-invoice');
            this.$wraperErrorFp = this.$('#error-eval-facturap');

            // Hide errors
            this.$wraperErrorFp.hide().empty();

            // Open modal
            this.$modalFp.modal('show');
        },

        /*
        * Facturap changed
        */
        facturapChanged: function (e) {
            e.preventDefault();

            // Hide errors && Empty Form
            this.$wraperErrorFp.hide().empty();
            this.$wraperFormFp.empty();

            // Evaluate account
            window.Misc.evaluateFacturap({
                'facturap': $(e.currentTarget).val(),
                'naturaleza': this.parameters.data.asiento2_naturaleza,
                'tercero': this.parameters.data.tercero_nit,
                'wrap': this.$wraperFormFp,
                'callback': (function (_this) {
                    return function (resp) {
                        if (resp.actions) {
                            // stuffToDo Response success
                            var stuffToDo = {
                                add: function () {
                                    // AddFacturapView
                                    _this.$wraperFormFp.html(_this.templateAddFacturap());
                                    _this.ready();
                                },
                                quota: function () {
                                    // QuotaFacturapView
                                    _this.$wraperFormFp.html(_this.templateCuotasFacturap());
                                    _this.$wraperCuotasFp = _this.$('#browse-rfacturap2-list');

                                    // Get cuotas list
                                    _this.cuotasFPList.fetch({reset: true, data: {facturap1: resp.facturap}});
                                }
                            };

                            if (stuffToDo[resp.action]) {
                                stuffToDo[resp.action]();
                            }
                        } else {
                            // No actions
                            if (!_.isUndefined(resp.message) && !_.isNull(resp.message) && resp.message != '') {
                                _this.$wraperErrorFp.empty().append(resp.message);
                                _this.$wraperErrorFp.show();
                            }
                        }
                    }
                })(this)
            });
        },

        /**
        * Render view task by model
        * @param Object facturap2Model Model instance
        */
        addOneCuotaFacturap: function (facturap2Model) {
            var view = new app.CuotasFPListView({
                model: facturap2Model
            });

            this.$wraperCuotasFp.append(view.render().el);
            this.ready();
        },

        /**
        * Render all view tast of the collection
        */
        addAllCuotasFacturap: function () {
            this.cuotasFPList.forEach(this.addOneCuotaFacturap, this);
        },

        /**
        * Event add item facturap
        */
        onStoreItemFacturap: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                // Prepare global data
                this.parameters.data = $.extend({}, this.parameters.data, window.Misc.formToJson(e.target));

                // Evaluate account
                this.validateAction({
                    'action': 'facturap',
                    'callback': (function (_this) {
                        return function (resp) {
                            if (resp.success) {
                                // Set action success
                                _this.setSuccessAction('facturap', _this.parameters.actions);

                                // Close modal
                                if (!_this.isLastAction('facturap')) {
                                    _this.$modalFp.modal('hide');
                                }

                                // Next action
                                _this.runAction();
                            }
                        }
                    })(this)
                });
            }
        },

        /**
        * Reference cartera
        */
        referenceCartera: function () {
            this.$wraper = this.$('#modal-asiento-wrapper-cartera');
            this.$wraperFormCt = this.$('#content-cartera');
            this.$wraperErrorCt = this.$('#error-eval-cartera');
            this.$wraperTable = this.$('#wrapper-table-factura');

            // Hide errors
            this.$wraperErrorCt.hide().empty();

            // Remove hide wraper table
            this.$wraperTable.removeAttr('hidden');

            // Open modal
            this.$modalCt.modal('show');
        },

        /**
        *   Change Factura Exists Cartera
        */
        facturaChange: function(e) {
            e.preventDefault();

            // Detalle list
            this.factura4ListView = new app.Factura4ListView({
                collection: this.detalleFactura4List,
                parameters: {
                    edit: false,
                    template: _.template(($('#factura-item-list-tpl').html() || '')),
                    call: 'asiento',
                    dataFilter: {
                        factura: this.$('#factura1_referencia').val()
                    }
                }
            });
        },

        /**
        * Event add item cartera
        */
        onStoreItemFactura: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                // Extend attributes
                this.parameters.data = $.extend({}, this.parameters.data, window.Misc.formToJson(e.target));

                // Evaluate account
                this.validateAction({
                    'action': 'cartera',
                    'callback': (function (_this) {
                        return function (resp) {
                            if (resp.success) {
                                // Set action success
                                _this.setSuccessAction('cartera', _this.parameters.actions);

                                // Close modal
                                if (!_this.isLastAction('cartera')) {
                                    _this.$modalCt.modal('hide');
                                }

                                // Next action
                                _this.runAction();
                            }
                        }
                    })(this)
                });
            }
        },

        /**
        * Reference orden
        */
        referenceOrdenp: function () {
            this.$wraper = this.$('#modal-asiento-wrapper-ordenp');
            this.$wraperFormOp = this.$modalOp.find('.content-modal');
            this.$wraperErrorOp = this.$('#error-search-orden-asiento2');

            // Hide errors
            this.$wraperErrorOp.hide().empty();

            // Open modal
            this.$modalOp.modal('show');
        },

        /**
        * Event add item ordenp
        */
        onStoreItemOrdenp: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                // Prepare global data
                this.parameters.data = $.extend({}, this.parameters.data, window.Misc.formToJson(e.target));

                // Evaluate account
                this.validateAction({
                    'action': 'ordenp',
                    'callback': (function (_this) {
                        return function (resp) {
                            if (resp.success) {
                                // Set action success
                                _this.setSuccessAction('ordenp', _this.parameters.actions);

                                // Close modal
                                if(!_this.isLastAction('ordenp')) {
                                    _this.$modalOp.modal('hide');
                                }

                                // Next action
                                _this.runAction();
                            }
                        }
                    })(this)
                });
            }
        },

        /**
        * Reference inventario
        */
        referenceInventario: function () {
            this.$wraper = this.$('#modal-asiento-wrapper-inventario');
            this.$wraperFormIn = this.$modalIn.find('.content-modal');
            this.$wraperDetailIn = this.$modalIn.find('#content-detail-inventory');
            this.$wraperErrorIn = this.$('#error-inventario-asiento2');

            this.$inputInProducto = this.$('#producto_codigo');
            this.$inputInUnidades = this.$('#movimiento_cantidad');
            this.$inputInSucursal = this.$('#movimiento_sucursal');

            // Hide errors
            this.$wraperErrorIn.hide().empty();
            this.$inputInUnidades.hide();

            // Open modal
            this.$modalIn.modal('show');
        },

        /*
        * Evaluar producto inventario
        */
        evaluateProductoInventario: function(e) {
            var producto = this.$inputInProducto.val(),
                sucursal = this.$inputInSucursal.val(),
                _this = this;

            // Empty wrapper detail
            this.$wraperDetailIn.empty();

            if (producto && sucursal) {
                $.ajax({
                    url: window.Misc.urlFull(Route.route('productos.search')),
                    type: 'GET',
                    data: {producto_codigo: producto},
                    beforeSend: function() {
                        _this.$wraperErrorIn.hide().empty();
                        window.Misc.setSpinner(_this.$wraperFormIn);
                    }
                })
                .done(function (resp) {
                    window.Misc.removeSpinner(_this.$wraperFormIn);
                    if (resp.success) {
                        // Show input unidades
                        _this.$inputInUnidades.show();
                        unidades = _this.$inputInUnidades.val();

                        // Si no maneja unidades
                        if (!parseInt(resp.producto_unidades)) {
                            // Unidades
                            _this.$wraperErrorIn.empty().append('No es posible realizar movimientos para productos que no manejan unidades');
                            _this.$wraperErrorIn.show();
                            return;
                        } else if (parseInt(resp.producto_metrado)) {
                            // Metrado
                            if (_this.parameters.data.asiento2_naturaleza == 'D') {
                                // Items rollo view
                                _this.$wraperDetailIn.html( _this.templateAddItemRollo( ) );
                                _this.$wraperItemRollo = _this.$('#browse-itemtollo-list');

                                for (var item = 1; item <= unidades; item++) {
                                    _this.addOneItemRolloInventario(new app.ItemRolloModel({id: item}))
                                }

                            } else {
                                // Items rollo view
                                _this.$wraperDetailIn.html(_this.templateChooseItemsRollo());
                                _this.$wraperItemRollo = _this.$('#browse-chooseitemtollo-list');

                                // Get item rollo list
                                _this.itemRolloINList.fetch({reset: true, data: {producto: resp.id, sucursal: sucursal}});
                            }

                        } else if (parseInt(resp.producto_serie)) {
                            // Series
                            if (_this.parameters.data.asiento2_naturaleza == 'D') {
                                // Items series view
                                _this.$wraperDetailIn.html(_this.templateAddSeries());
                                _this.$wraperSeries = _this.$('#browse-series-list');

                                for (var item = 1; item <= unidades; item++) {
                                    _this.addOneSerieInventario(new app.ProductoModel({id: item}))
                                }
                            } else {
                                _this.$inputInUnidades.val(1).hide();

                            }
                        }
                    }
                })
                .fail(function (jqXHR, ajaxOptions, thrownError) {
                    _this.$wraperErrorIn.empty().append(thrownError);
                    _this.$wraperErrorIn.show();
                });
            }
        },

        /**
        * Render view task by model
        * @param Object ItemRolloModel Model instance
        */
        addOneItemRolloInventario: function (ItemRolloModel, choose) {
            var view = new app.ItemRolloINListView({
                model: ItemRolloModel,
                parameters: {
                    choose: (choose || false)

                }
            });

            this.$wraperItemRollo.append(view.render().el);
            this.ready();
        },

        /**
        * Render all view tast of the collection
        */
        addAllItemRolloInventario: function () {
            var _this = this;
            this.itemRolloINList.forEach(function(model, index) {
                _this.addOneItemRolloInventario(model, true)
            });
        },

        /**
        * Render view task by model
        * @param Object Producto Model instance
        */
        addOneSerieInventario: function (ProductoModel) {
            var view = new app.ProductoSeriesINListView({
                model: ProductoModel
            });

            this.$wraperSeries.append(view.render().el);
            this.ready();
        },

        /**
        * Event add item inventario
        */
        onStoreItemInventario: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                // Prepare global data
                this.parameters.data = $.extend({}, this.parameters.data, window.Misc.formToJson(e.target));

                // Evaluate account
                this.validateAction({
                    'action': 'inventario',
                    'callback': (function (_this) {
                        return function (resp) {
                            if (resp.success) {
                                // Set action success
                                _this.setSuccessAction('inventario', _this.parameters.actions);

                                // Close modal
                                if (!_this.isLastAction('inventario')) {
                                    _this.$modalIn.modal('hide');
                                }

                                // Inventario modifica valor item asiento por el valor del costo del movimiento
                                if (!_.isUndefined(resp.asiento2_valor) && !_.isNull(resp.asiento2_valor) && resp.asiento2_valor != _this.parameters.data.asiento2_valor) {
                                    _this.parameters.data.asiento2_valor = resp.asiento2_valor;
                                }

                                // Next action
                                _this.runAction();
                            }
                        }
                    })(this)
                });
            }
        },

        /**
        * Event add item Asiento Cuentas
        */
        onStoreItem: function (e) {
            // If callbacks is form
            if (this.parameters.actions[0].action == 'update') {
                e.preventDefault();

                var data = window.Misc.formToJson(e.target);
                this.model.save(data, {wait: true, patch: true, silent: true});
            } else {
                // Model exist
                if (!this.model.isNew()) {
                    // Insert item
                    this.collection.trigger('store', this.parameters.data);
                } else {
                    // Create model
                    this.model.save(this.parameters.data, {wait: true, patch: true, silent: true});
                }
            }
        },

        /**
        * Reference update
        */
        referenceUpdate: function () {
            // Reference wrapper render content
            if (this.model.get('plancuentas_tipo').indexOf(['N', 'I']) !== -1) {
                this.referenceViews();
            }

            this.$modalUp.modal('show');
            this.ready();
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            this.asientoMovimientosList = new app.AsientoMovimientosList();

            // Detalle asiento list
            this.asientoMovimientosListView = new app.AsientoMovimientosListView({
                el: $('#wrapper-movimientos-edit'),
                collection: this.asientoMovimientosList,
                parameters: {
                    edit: true,
                    nuevo: this.model.get('asiento2_nuevo'),
                    dataFilter: {
                        asiento2: this.model.get('id')
                    }
                }
            });
        },

        /**
        * Change Valor
        */
        roundModule: function (e) {
            var valor = this.$(e.currentTarget).inputmask('unmaskedvalue');

            if (parseInt(this.parameters.data.empresa_round)) {
                this.$(e.currentTarget).val(Math.round(valor));
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

            if (typeof window.initComponent.initInputMask == 'function')
                window.initComponent.initInputMask();

            if (typeof window.initComponent.initDatePicker == 'function')
                window.initComponent.initDatePicker();

            if (typeof window.initComponent.initICheck == 'function')
                window.initComponent.initICheck();
        },

        /**
        * Event delegate view
        */
        closeModal: function (e) {
            // delegate this view
            if (this instanceof Backbone.View) {
                this.stopListening();
                this.undelegateEvents();
            }
        },

        /**
        * response of the server
        */
        responseServer: function (model, resp, opts) {
            if (!_.isUndefined(resp.success)) {
                if (resp.success) {
                    // Close modals
                    this.$modalOp.modal('hide');
                    this.$modalIn.modal('hide');
                    this.$modalFp.modal('hide');
                    this.$modalCt.modal('hide');
                    this.$modalUp.modal('hide');

                    window.Misc.clearForm($('#form-item-asiento'));
                }
            }
        }
    });

})(jQuery, this, this.document);
