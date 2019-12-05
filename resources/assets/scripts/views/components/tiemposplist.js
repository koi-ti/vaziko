/**
* Class TiempopListView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.TiempopListView = Backbone.View.extend({

        el: '#browse-tiemposp-global-list',
        events: {
            'click .item-edit': 'editOne',
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

            // Init Attributes
            this.$modal = $('#modal-tiempop-edit-component');

            // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'store', this.storeOne );
            this.listenTo( this.collection, 'request', this.loadSpinner );
            this.listenTo( this.collection, 'sync', this.responseServer );

            // Validar si se viene dataFilter
            this.collection.fetch({data: this.parameters.dataFilter, reset: true});
        },

        /**
        * Render view contact by model
        * @param Object tiempopModel Model instance
        */
        addOne: function (tiempopModel) {
            var view = new app.TiempopItemView({
                model: tiempopModel,
                parameters: {
                    call: this.parameters.dataFilter.call
                }
            });
            tiempopModel.view = view;
            this.$el.append(view.render().el.children)
        },

        /**
        * Render all view Marketplace of the collection
        */
        addAll: function () {
            if (this.collection.length)
                this.$el.find('tbody').html('');
            this.collection.forEach(this.addOne, this);
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
            var tiempopModel = new app.TiempopModel();
                tiempopModel.save(data, {
                    wait: true,
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
                            _this.collection.add(model);
                            _this.collection.trigger('change');
                            window.Misc.clearForm(form);
                        }
                    },
                    error: function(model, error) {
                        window.Misc.removeSpinner(_this.parameters.wrapper);
                        alertify.error(error.statusText)
                    }
                });
        },

        /**
        *  Edit tiempo de produccion
        **/
        editOne: function(e) {
            e.preventDefault();

            var resource = this.$(e.currentTarget).data('resource'),
                model = this.collection.get(resource);

            // Open tiempopActionView
            if (this.tiempopActionView instanceof Backbone.View) {
               this.tiempopActionView.stopListening();
               this.tiempopActionView.undelegateEvents();
            }

            this.tiempopActionView = new app.TiempopActionView({
                model: model,
                parameters: {
                    call: this.parameters.dataFilter.call
                }
            });
           this.tiempopActionView.render();
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
                // Validar que exista un modal
                if (this.$modal.length) {
                    this.collection.fetch({data: this.parameters.dataFilter, reset: true});
                    this.$modal.modal('hide');
                    alertify.success(resp.msg);
                }
            }
        }
   });

})(jQuery, this, this.document);
