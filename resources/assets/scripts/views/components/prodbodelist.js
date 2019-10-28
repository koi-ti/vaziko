/**
* Class ProdbodeListView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ProdbodeListView = Backbone.View.extend({

        el: '#browse-prodbode-table',
        events: {
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

            //Init Attributes
            this.confCollection = { reset: true, data: {} };

            // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner );
            this.listenTo( this.collection, 'sync', this.responseServer );

            // if was passed itemrollo code
            if (!_.isUndefined(this.parameters.dataFilter.call) && !_.isNull(this.parameters.dataFilter.call)) {
                this.confCollection.data.producto = this.parameters.dataFilter.producto_id;
                this.collection.fetch(this.confCollection);
            }
        },

        /**
        * Render view contact by model
        * @param Object prodbodeModel Model instance
        */
        addOne: function (prodbodeModel) {
            var view = new app.ProdbodeItemView({
                model: prodbodeModel,
                parameters: {
                    edit: this.parameters.edit
                }
            });
            prodbodeModel.view = view;
            this.$el.append(view.render().el);
        },

        /**
        * Render all view Marketplace of the collection
        */
        addAll: function () {
            this.collection.forEach(this.addOne, this);
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function (target, xhr, opts) {
            window.Misc.setSpinner(this.el);
        },

        /**
        * response of the server
        */
        responseServer: function (target, resp, opts) {
            window.Misc.removeSpinner(this.el);
        }
   });

})(jQuery, this, this.document);
