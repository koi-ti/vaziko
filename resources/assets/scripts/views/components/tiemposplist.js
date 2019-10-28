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
            'click .edit-tiempop': 'editTiempop',
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
            this.confCollection = { reset: true, data: {} };
            this.$modal = $('#modal-tiempop-edit-component');

            // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner );
            this.listenTo( this.collection, 'sync', this.responseServer );

            // if was passed itemrollo code
            if (!_.isUndefined(this.parameters.dataFilter.type) && !_.isNull(this.parameters.dataFilter.type)) {
                this.confCollection.data = this.parameters.dataFilter;
                this.collection.fetch(this.confCollection);
            }
        },

        /**
        * Render view contact by model
        * @param Object tiempopModel Model instance
        */
        addOne: function (tiempopModel) {
            var view = new app.TiempopItemView({
                model: tiempopModel,
                parameters: {
                    dataFilter: this.parameters.dataFilter,
                }
            });

            tiempopModel.view = view;
            this.$el.append(view.render().el);
        },

        /**
        * Render all view Marketplace of the collection
        */
        addAll: function () {
            if (this.collection.length) {
                this.$el.find('tbody').html('');
            }
            this.collection.forEach(this.addOne, this);
        },

        /**
        *  Edit tiempo de produccion
        **/
        editTiempop: function(e) {
            e.preventDefault();

            var resource = this.$(e.currentTarget).data('tiempop-resource'),
                model = this.collection.get(resource);

            // Open tiempopActionView
            if (this.tiempopActionView instanceof Backbone.View) {
               this.tiempopActionView.stopListening();
               this.tiempopActionView.undelegateEvents();
            }

            this.tiempopActionView = new app.TiempopActionView({
                model: model,
                parameters: {
                    dataFilter: this.parameters.dataFilter,
                }
            });

           this.tiempopActionView.render();
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function (target, xhr, opts) {
            window.Misc.setSpinner(this.$el);
        },

        /**
        * response of the server
        */
        responseServer: function (target, resp, opts) {
            window.Misc.removeSpinner(this.$el);
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

                this.collection.fetch(this.confCollection);
                this.$modal.modal('hide');
                alertify.success(resp.msg);
            }
        }
   });

})(jQuery, this, this.document);
