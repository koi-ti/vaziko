/**
* Class AsientoCuentasNifListView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.AsientoNifCuentasListView = Backbone.View.extend({

        el: '#browse-detalle-asienton-list',
        events: {
            'click .item-asienton2-remove': 'removeOne'
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
            this.$debitos = this.$('#total-debitos');
            this.$creditos = this.$('#total-creditos');
            this.$diferencia = this.$('#total-diferencia');

            //Init Attributes
            this.confCollection = {reset: true, data: {}};

            // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner );
            this.listenTo( this.collection, 'store', this.storeOne );
            this.listenTo( this.collection, 'sync', this.responseServer );

            /* if was passed asiento code */
            if (!_.isUndefined(this.parameters.dataFilter.asiento) && !_.isNull(this.parameters.dataFilter.asiento)) {
                this.confCollection.data.asiento = this.parameters.dataFilter.asiento;
                this.collection.fetch(this.confCollection);
            }
        },

        /**
        * Render view task by model
        * @param Object mentoringTaskModel Model instance
        */
        addOne: function (asientoNif2Model) {
            var view = new app.AsientoCuentasNifItemView({
                model: asientoNif2Model,
                parameters: {
                    edit: this.parameters.edit
                }
            });
            asientoNif2Model.view = view;
            this.$el.append(view.render().el);

            // Update total
            this.totalize();
        },

        /**
        * Render all view tast of the collection
        */
        addAll: function () {
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
            var asiento2Model = new app.AsientoNif2Model();
                asiento2Model.save(data, {
                    success: function (model, resp) {
                        if (!_.isUndefined(resp.success)) {
                            window.Misc.removeSpinner(_this.parameters.wrapper);
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
        * Event remove item
        */
        removeOne: function (e) {
            e.preventDefault();

            var resource = $(e.currentTarget).attr("data-resource"),
                model = this.collection.get(resource),
                _this = this;

            if (model instanceof Backbone.Model) {
                model.destroy({
                    success: function (model, resp) {
                        if (!_.isUndefined(resp.success)) {
                            window.Misc.removeSpinner( _this.parameters.wrapper );
                            if (!resp.success) {
                                alertify.error(resp.errors);
                                return;
                            }

                            model.view.remove();
                            _this.collection.remove(model);

                            // Update total
                            _this.totalize();
                        }
                    }
                });
            }
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
        }
   });

})(jQuery, this, this.document);
