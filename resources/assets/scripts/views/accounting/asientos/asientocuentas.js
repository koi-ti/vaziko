/**
* Class AsientoCuentasListView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.AsientoCuentasListView = Backbone.View.extend({

        el: '#browse-detalle-asiento-list',
        templateInfo: _.template( ($('#show-info-asiento2-tpl').html() || '') ),
        events: {
            'click .item-edit': 'editOne',
            'click .item-remove': 'removeOne',
            'click .item-show': 'showOne'
        },
        parameters: {
            wrapper: null,
            edit: false,
            dataFilter: {}
        },

        /**
        * Constructor Method
        */
        initialize: function (opts) {
            // extends parameters
            if (opts !== undefined && _.isObject(opts.parameters))
                this.parameters = $.extend({},this.parameters, opts.parameters);

            // References
            this.$debitos = this.$('.total-debitos');
            this.$creditos = this.$('.total-creditos');
            this.$diferencia = this.$('.total-diferencia');

            // References show attributes
            this.$modal = $('#modal-asiento-show-info-component');

            // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner );
            this.listenTo( this.collection, 'store', this.storeOne );
            this.listenTo( this.collection, 'sync', this.responseServer );

            this.collection.fetch({data: this.parameters.dataFilter, reset: true});
        },

        /**
        * Render view task by model
        * @param Object asiento2Model Model instance
        */
        addOne: function (asiento2Model) {
            var view = new app.AsientoCuentasItemView({
                model: asiento2Model,
                parameters: {
                    edit: this.parameters.edit
                }
            });
            asiento2Model.view = view;
            this.$el.append(view.render().el);

            // Update total
            this.totalize();
        },

        /**
        * Render all view tast of the collection
        */
        addAll: function () {
            this.$el.find('tbody').html('');
            this.collection.forEach(this.addOne, this);
        },

        /**
        * storescuenta
        * @param form element
        */
        storeOne: function (data) {
            var _this = this

            // Set Spinner
            window.Misc.setSpinner(this.parameters.wrapper);

            // Add model in collection
            var asiento2Model = new app.Asiento2Model();
                asiento2Model.save(data, {
                    success: function (model, resp) {
                        if (!_.isUndefined(resp.success)) {
                            window.Misc.removeSpinner( _this.parameters.wrapper );
                            // response success or error
                            var text = resp.success ? '' : resp.errors;
                            if (_.isObject(resp.errors)) {
                                text = window.Misc.parseErrors(resp.errors);
                            }

                            if (!resp.success) {
                                alertify.error(text);
                                return;
                            }

                            // Add model in collection
                            _this.collection.add(model);
                        }
                    },
                    error: function (model, error) {
                        window.Misc.removeSpinner(_this.parameters.wrapper);
                        alertify.error(error.statusText)
                    }
                });
        },

        /**
        * Event edit item
        */
        editOne: function (e) {
            e.preventDefault();

            var resource = $(e.currentTarget).attr("data-resource"),
                model = this.collection.get(resource);

            // Declare data
            var data = {
                asiento2_valor: model.get('asiento2_naturaleza') == 'D' ? model.get('asiento2_debito') : model.get('asiento2_credito'),
                nuevo: model.get('asiento2_nuevo'),
                title: model.get('plancuentas_cuenta') + ' - ' + model.get('plancuentas_nombre') + ' - (EDITANDO)'
            }

            // Set valor
            model.set('asiento2_valor', data.asiento2_valor);

            // Open AsientoActionView
            if (this.asientoActionView instanceof Backbone.View) {
                this.asientoActionView.stopListening();
                this.asientoActionView.undelegateEvents();
            }

            // Open view asiento action
            this.asientoActionView = new app.AsientoActionView({
                model: model,
                collection: this.collection,
                parameters: {
                    data: data,
                    actions: [{
                        action: 'update',
                        success: false
                    }]
                }
            });
            this.asientoActionView.render();
        },

        /**
        * Event remove item
        */
        removeOne: function (e) {
            e.preventDefault();

            var resource = $(e.currentTarget).attr("data-resource"),
                model = this.collection.get(resource),
                _this = this;

            var cancelConfirm = new window.app.ConfirmWindow({
                parameters: {
                    dataFilter: {
                        plancuentas_cuenta: model.get('plancuentas_cuenta'),
                        plancuentas_nombre: model.get('plancuentas_nombre')
                    },
                    template: _.template( ($('#asiento-item-delete-confirm-tpl').html() || '') ),
                    titleConfirm: 'Eliminar cuenta',
                    onConfirm: function () {
                        if (model instanceof Backbone.Model) {
                            model.destroy({
                                wait: true,
                                success: function (model, resp) {
                                    if (!_.isUndefined(resp.success)) {
                                        window.Misc.removeSpinner(_this.parameters.wrapper);
                                        if (!resp.success) {
                                            alertify.error(resp.errors);
                                            return;
                                        }

                                        model.view.remove();
                                        _this.collection.remove(model);
                                        _this.totalize();
                                    }
                                }
                            });
                        }
                    }
                }
            });

            cancelConfirm.render();
        },

        /**
        * Event show item
        */
        showOne: function (e) {
            e.preventDefault();

            var resource = $(e.currentTarget).attr("data-resource"),
                model = this.collection.get(resource).toJSON();

            // Render modal info
            this.$modal.find('.content-modal').empty().html(this.templateInfo(model));

            // Tipo de cuenta (Ninguna)
            if (model.plancuentas_tipo != 'N') {
                this.referenceViews(model);
            }

            this.$modal.modal('show');
        },

        /**
        * reference to views
        */
        referenceViews: function (model) {
            // Detalle asiento list
            this.asientoMovimientosListView = new app.AsientoMovimientosListView({
                collection: new app.AsientoMovimientosList(),
                parameters: {
                    edit: false,
                    dataFilter: {
                        asiento2: model.id
                    }
                }
            });
        },

        /**
        * Render totalize debitos and creditos
        */
        totalize: function () {
            var data = this.collection.totalize();

            if (this.$debitos.length) {
                this.$debitos.html(window.Misc.currency(data.debitos));
            }

            if (this.$creditos.length) {
                this.$creditos.html(window.Misc.currency(data.creditos));
            }

            if (this.$diferencia.length) {
                this.$diferencia.html(window.Misc.currency(data.diferencia));
            }
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function (model, xhr, opts) {
            window.Misc.setSpinner(this.parameters.wrapper);
        },

        /**
        * response of the server
        */
        responseServer: function (model, resp, opts) {
            window.Misc.removeSpinner(this.parameters.wrapper);
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

                this.collection.fetch({data: this.parameters.dataFilter, reset: true});
            }
        }
   });

})(jQuery, this, this.document);
