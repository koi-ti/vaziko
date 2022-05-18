/**
* Class TransportesProductopOrdenListView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.TransportesProductopOrdenListView = Backbone.View.extend({

        el: '#browse-orden-producto-transportes-list',
        events: {
            'click .item-producto-transporte-orden-remove': 'removeOne',
            'click .item-producto-transporte-orden-edit': 'editOne',
            'click .item-producto-transporte-orden-success': 'successEdit'
        },
        parameters: {
        	wrapper: null,
            dataFilter: {}
        },

        /**
        * Constructor Method
        */
        initialize: function (opts) {
            // extends parameters
            if (opts !== undefined && _.isObject(opts.parameters))
                this.parameters = $.extend({},this.parameters, opts.parameters);

            // Render total
            this.$total = this.$('#total');

            // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'store', this.storeOne );
            this.listenTo( this.collection, 'request', this.loadSpinner );
            this.listenTo( this.collection, 'sync', this.responseServer );

            if (this.parameters.dataFilter.orden2)
                this.collection.fetch({ data: this.parameters.dataFilter, reset: true });
        },

        /**
        * Render view contact by model
        * @param Object ordenp10Model Model instance
        */
        addOne: function (ordenp10Model) {
            var view = new app.TransportesProductopOrdenItemView({
                model: ordenp10Model,
                parameters: {
                    edit: this.parameters.edit
                }
            });
            ordenp10Model.view = view;
            this.$el.append(view.render().el);
        },

        /**
        * Render all view Marketplace of the collection
        */
        addAll: function () {
            this.$el.find('tbody').html('');
            this.collection.forEach(this.addOne, this);

            this.totalize();
        },

        /**
        * store
        * @param form element
        */
        storeOne: function (data, form) {
            var _this = this;

            // Set Spinner
            window.Misc.setSpinner(this.parameters.wrapper);

            // Add model in collection
            var ordenp10Model = new app.Ordenp10Model();
                ordenp10Model.save(data, {
                    success: function (model, resp) {
                        if (!_.isUndefined(resp.success)) {
                            window.Misc.removeSpinner(_this.parameters.wrapper);
                            var text = resp.success ? '' : resp.errors;
                            if (_.isObject(resp.errors)) {
                                text = window.Misc.parseErrors(resp.errors);
                            }

                            if (!resp.success) {
                                alertify.error(text);
                                return;
                            }

                            // Add model in collection
                            window.Misc.clearForm(form);
                            _this.collection.add(model);
                            _this.totalize();
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
                var removeConfirm = new window.app.ConfirmWindow({
                    parameters: {
                        dataFilter: {
                            nombre: model.get('transporte_nombre') || model.get('orden10_nombre')
                        },
                        template: _.template( ($('#orden-delete-transporte-confirm-tpl').html() || '') ),
                        titleConfirm: 'Eliminar transporte de producción',
                        onConfirm: function () {
                            model.view.remove();
                            _this.collection.remove(model);
                            _this.totalize();
                        }
                    }
                });
                removeConfirm.render();
            }
        },

        /**
        * Event edit item
        */
        editOne: function(e){
            e.preventDefault();

            var resource = $(e.currentTarget).attr("data-resource"),
                model = this.collection.get(resource);

            if (model instanceof Backbone.Model) {
                var view = new app.TransportesProductopOrdenItemView({
                    model: model,
                    parameters: {
                        action: 'edit',
                    }
                });
                model.view.$el.replaceWith(view.render().el);
            }
        },

        /**
        * Event success edit item
        */
        successEdit: function (e) {
            e.preventDefault();

            var resource = $(e.currentTarget).attr("data-resource"),
                model = this.collection.get(resource);

            if (model instanceof Backbone.Model) {
                var hour = this.$('#orden10_horas_' + model.get('id')).val();
                    minute = this.$('#orden10_minutos_' + model.get('id')).val();

                if (hour < 0 || _.isNaN(parseInt(hour))) {
                    alertify.error('El campo de horas no es valido.');
                    return;
                }

                if (minute < 0 || minute >= 60 || _.isNaN(parseInt(minute))) {
                    alertify.error('El campo de minutos no es valido.');
                    return;
                }

                var attributes = {};
                if (model.get('orden10_horas') != parseInt(hour))
                    attributes.orden10_horas = parseInt(hour);

                if (model.get('orden10_minutos') != parseInt(minute))
                    attributes.orden10_minutos = parseInt(minute)

                // Set tiempo
                attributes.orden10_tiempo = parseInt(hour) + ':' + parseInt(minute);

                model.set(attributes, {silent: true});
                this.collection.trigger('reset');
            }
        },

        /**
        *Render totales the collection
        */
        totalize: function () {
            var data = this.collection.totalize();

            if (this.$total.length) {
                this.$total.empty().html(window.Misc.currency(data.total));

                this.model.trigger('totalize');
            }
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
