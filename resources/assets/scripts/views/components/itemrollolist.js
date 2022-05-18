/**
* Class ProdbodeListView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ItemRolloListView = Backbone.View.extend({

        el: '#browse-itemtollo-list',
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
            if (!_.isUndefined(this.parameters.dataFilter.sucursal) && !_.isNull(this.parameters.dataFilter.sucursal)) {
                this.confCollection.data.sucursal = this.parameters.dataFilter.sucursal;
                this.confCollection.data.producto = this.parameters.dataFilter.producto_id;
                this.collection.fetch(this.confCollection);
            }
        },

        /**
        * Render view contact by model
        * @param Object itemRolloModel Model instance
        */
        addOne: function (itemRolloModel) {
            var view = new app.ItemRolloINListView({
                model: itemRolloModel,
                parameters: {
                    choose: this.parameters.choose,
                    show:this.parameters.show
                }
            });

            itemRolloModel.view = view;
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
