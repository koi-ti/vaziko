/**
* Class ProductopPreCotizacionListView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ProductopPreCotizacionListView = Backbone.View.extend({

        el: '#browse-precotizacion-productop-list',
        events: {
            'click .item-remove': 'removeOne',
            'click .item-clone': 'cloneOne'
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

            // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner);
            this.listenTo( this.collection, 'sync', this.responseServer);

            this.collection.fetch({data: this.parameters.dataFilter, reset: true});
        },

        /**
        * Render view contact by model
        * @param Object precotizacion2Model Model instance
        */
        addOne: function (precotizacion2Model) {
            var view = new app.ProductopPreCotizacionItemView({
                model: precotizacion2Model,
                parameters: {
                    edit: this.parameters.edit
                }
            });
            precotizacion2Model.view = view;
            this.$el.append(view.render().el);
        },

        /**
        * Render all view Marketplace of the collection
        */
        addAll: function () {
            this.collection.forEach(this.addOne, this);
        },

        /**
        * Event remove item
        */
        removeOne: function (e) {
            e.preventDefault();

            var resource = $(e.currentTarget).attr("data-resource"),
                model = this.collection.get(resource),
                _this = this;

            if (model instanceof Backbone.Model) {
                var cancelConfirm = new window.app.ConfirmWindow({
                    parameters: {
                        dataFilter: {
                            productop_nombre: model.get('productop_nombre')
                        },
                        template: _.template( ($('#precotizacion-productop-delete-confirm-tpl').html() || '') ),
                        titleConfirm: 'Eliminar producto',
                        onConfirm: function () {
                            model.destroy({
                                success: function (model, resp) {
                                    if(!_.isUndefined(resp.success)) {
                                        window.Misc.removeSpinner( _this.parameters.wrapper );
                                        if (!resp.success) {
                                            alertify.error(resp.errors);
                                            return;
                                        }

                                        model.view.remove();
                                        _this.collection.remove(model);
                                    }
                                }
                            });
                        }
                    }
                });

                cancelConfirm.render();
            }
        },

        /**
        * Event clone item
        */
        cloneOne: function (e) {
            e.preventDefault();

            var _this = this,
                resource = $(e.currentTarget).attr("data-resource"),
                model = this.collection.get(resource),
                route = window.Misc.urlFull( Route.route('precotizaciones.productos.clonar', { productos: model.get('id') }) ),
                data = { precotizacion2_codigo: model.get('id'), productop_nombre: model.get('productop_nombre') };

            var cloneConfirm = new window.app.ConfirmWindow({
                parameters: {
                    dataFilter: data,
                    template: _.template( ($('#precotizacion-productop-clone-confirm-tpl').html() || '') ),
                    titleConfirm: 'Clonar producto pre-cotización',
                    onConfirm: function () {
                        // Clonar producto
                        window.Misc.cloneModule({
                            'url': route,
                            'wrap': _this.parameters.wrapper,
                            'callback': (function(_this){
                                return function(resp){
                                    window.Misc.successRedirect( resp.msg, window.Misc.urlFull(Route.route('precotizaciones.productos.show', { productos: resp.id })) );
                                }
                            })(_this)
                        });
                    }
                }
            });

            cloneConfirm.render();
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function (target, xhr, opts) {
            window.Misc.setSpinner(this.parameters.wrapper);
        },

        /**
        * response of the server
        */
        responseServer: function (target, resp, opts) {
            window.Misc.removeSpinner(this.parameters.wrapper);
        }
   });

})(jQuery, this, this.document);
