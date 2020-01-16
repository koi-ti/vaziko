/**
* Class ProductoHistorialListView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ProductoHistorialListView = Backbone.View.extend({

        el: '#browse-historial-producto-list',
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
            this.listenTo( this.collection, 'request', this.loadSpinner );
            this.listenTo( this.collection, 'sync', this.responseServer );

            this.collection.fetch({data: this.parameters.dataFilter, reset: true});
        },

        /**
        * Render view contact by model
        * @param Object productoHistorialModel Model instance
        */
        addOne: function (productoHistorialModel) {
            var view = new app.ProductoHistorialView({
                model: productoHistorialModel,
            });
            productoHistorialModel.view = view;
            this.$el.prepend(view.render().el);
        },

        /**
        * Render all view Marketplace of the collection
        */
        addAll: function () {
            this.$el.find('tbody').html('');
            if (!this.collection.length) {
                this.$el.append($('<tr>').append($('<th>').addClass('text-center').attr('colspan', 3).append('NO EXISTE HISTORIAL DEL PRODUCTO')));
            }
            this.collection.forEach(this.addOne, this);
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
