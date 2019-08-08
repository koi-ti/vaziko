/**
* Class CreateTrasladoView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateTrasladoView = Backbone.View.extend({

        el: '#traslados-create',
        template: _.template( ($('#add-traslado-tpl').html() || '') ),
        events: {
            'click .submit-traslado': 'submitTraslado',
            'submit #form-item-traslado': 'onStoreItem',
            'submit #form-traslado': 'onStore',
        },
        parameters: {},

        /**
        * Constructor Method
        */
        initialize: function (opts) {
            // Initialize
            if (opts !== undefined && _.isObject(opts.parameters))
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            // Attributes
            this.$wraperForm = this.$('#render-form-traslado');

            this.trasladoProductosList = new app.TrasladoProductosList();

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
            this.$wraperForm.html(this.template(attributes));

            // References
            this.$form = this.$('#form-traslado');
            this.$formItem = this.$('#form-item-traslado');

            // Reference views
            this.referenceViews();
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            // Detalle traslado list
            this.productosListView = new app.TrasladoProductosListView({
                collection: this.trasladoProductosList,
                parameters: {
                    wrapper: this.el,
                    edit: true
                }
            });
        },

        /**
        * Event submit traslado
        */
        submitTraslado: function (e) {
            this.$form.submit();
        },

        /**
        * Event Create Folder
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
                    data.detalle = this.trasladoProductosList.toJSON()
                this.model.save(data, {wait: true, patch: true, silent: true});
            }
        },

        /**
        * Event add item detalle traslado
        */
        onStoreItem: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = data = window.Misc.formToJson( e.target );
                    data.tipo = 'S';
                    data.sucursal = this.$('#traslado1_sucursal').val();
                    data.destino = this.$('#traslado1_destino').val();

                    window.Misc.evaluateActionsInventory({
                        'data': data,
                        'wrap': this.$el,
                        'callback': (function (_this) {
                            return function (action, tipo, producto) {
                                // Open InventarioActionView
                                if (_this.inventarioActionView instanceof Backbone.View) {
                                    _this.inventarioActionView.stopListening();
                                    _this.inventarioActionView.undelegateEvents();
                                }

                                _this.inventarioActionView = new app.InventarioActionView({
                                    model: _this.model,
                                    collection: _this.trasladoProductosList,
                                    parameters: {
                                        data: data,
                                        action: action,
                                        tipo: tipo,
                                        producto: producto,
                                        form:_this.$formItem
                                    }
                                });
                                _this.inventarioActionView.render();
                            }
                        })(this)
                    });
            }
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function (model, xhr, opts) {
            window.Misc.setSpinner(this.el);
        },

        /**
        * response of the server
        */
        responseServer: function (model, resp, opts) {
            window.Misc.removeSpinner(this.el);
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

                window.Misc.redirect(window.Misc.urlFull(Route.route('traslados.show', {traslados: resp.id})));
            }
        }
    });

})(jQuery, this, this.document);
