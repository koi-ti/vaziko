/**
* Class DespachopOrdenListView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.DespachopOrdenListView = Backbone.View.extend({

        el: '#browse-orden-despachosp-list',
        events: {
            'click .item-orden-despacho-remove': 'removeOne'
        },
        parameters: {
        	wrapper: null,
            collectionPendientes: null,
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
            this.listenTo( this.collection, 'store', this.storeOne );
            this.listenTo( this.collection, 'sync', this.responseServer);

            this.collection.fetch({ data: this.parameters.dataFilter, reset: true });
        },

        /**
        * Render view contact by model
        * @param Object despachopModel Model instance
        */
        addOne: function (despachopModel) {
            var view = new app.DespachopOrdenItemView({
                model: despachopModel,
                parameters: {
                    edit: this.parameters.edit
                }
            });
            despachopModel.view = view;
            this.$el.append( view.render().el );
        },

        /**
        * Render all view Marketplace of the collection
        */
        addAll: function () {
            this.$el.find('tbody').html('');
            this.collection.forEach( this.addOne, this );
        },

        /**
        * Store despacho
        * @param form element
        */
        storeOne: function (data) {
            var _this = this

            // Set Spinner
            window.Misc.setSpinner( this.parameters.wrapper );

            // Add model in collection
            var despachopModel = new app.DespachopModel();
                despachopModel.save(data, {
                    wait: true,
                    success: function(model, resp) {
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
                            _this.parameters.collectionPendientes.fetch({data: {orden2_orden: _this.parameters.dataFilter.despachop1_orden}, reset: true});
                        }
                    },
                    error: function(model, error) {
                        window.Misc.removeSpinner( _this.parameters.wrapper );
                        alertify.error(error.statusText)
                    }
                });
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
                        dataFilter: { tcontacto_nombre: model.get('tcontacto_nombre'), despachop1_fecha: model.get('despachop1_fecha') },
                        template: _.template( ($('#ordenp-despacho-delete-confirm-tpl').html() || '') ),
                        titleConfirm: 'Eliminar despacho',
                        onConfirm: function () {
                            if ( model instanceof Backbone.Model ) {
                                model.destroy({
                                    success : function(model, resp) {
                                        if (!_.isUndefined(resp.success)) {
                                            window.Misc.removeSpinner( _this.parameters.wrapper );

                                            if ( !resp.success ) {
                                                alertify.error(resp.errors);
                                                return;
                                            }

                                            // Refresh other collection
                                            _this.collection.fetch({data: _this.parameters.dataFilter, reset: true});
                                            _this.parameters.collectionPendientes.fetch({data: {orden2_orden: _this.parameters.dataFilter.despachop1_orden}, reset: true});
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
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {
            window.Misc.setSpinner( this.parameters.wrapper );
        },

        /**
        * response of the server
        */
        responseServer: function ( target, resp, opts ) {
            window.Misc.removeSpinner( this.parameters.wrapper );
        }
   });

})(jQuery, this, this.document);
