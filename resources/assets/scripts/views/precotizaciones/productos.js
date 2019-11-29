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
            if (this.collection.length) {
                this.$el.find('tbody').empty('');
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
