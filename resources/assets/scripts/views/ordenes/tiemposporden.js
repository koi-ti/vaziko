/**
* Class TiempopOrdenListView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.TiempopOrdenListView = Backbone.View.extend({

        el: '#browse-orden-tiemposp-list',
        events: {
            'click .edit-tiempop-ordenp': 'editTiempop'
        },
        parameters: {
        	wrapper: null,
            dataFilter: {}
        },

        /**
        * Constructor Method
        */
        initialize : function(opts){

            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner);
            this.listenTo( this.collection, 'sync', this.responseServer);

            this.collection.fetch({ data: {orden2_orden: this.parameters.dataFilter.orden2_orden}, reset: true });
        },

        /*
        * Render View Element
        */
        render: function() {

        },

        editTiempop: function(e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = this.$(e.currentTarget).data('tiempo-resource');

                // Open tiempopActionView
                if ( this.tiempopActionView instanceof Backbone.View ){
                    this.tiempopActionView.stopListening();
                    this.tiempopActionView.undelegateEvents();
                }

                this.tiempopActionView = new app.TiempopActionView({
                    collection: this.collection,
                    parameters: {
                        ordenp2: this.parameters.dataFilter.orden2_orden,
                        data: data,
                        action: 'ordenp',
                    }
                });

                this.tiempopActionView.render();
            }
        },

        /**
        * Render view contact by model
        * @param Object tiempopModel Model instance
        */
        addOne: function (tiempopModel) {
            var view = new app.TiempopOrdenItemView({
                model: tiempopModel,
                parameters: {
                    edit: this.parameters.edit
                }
            });
            tiempopModel.view = view;
            this.$el.prepend( view.render().el );
        },

        /**
        * Render all view Marketplace of the collection
        */
        addAll: function () {
            this.$el.find('tbody').html('');
            this.collection.forEach( this.addOne, this );
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {
            window.Misc.setSpinner( this.$el );
        },

        /**
        * response of the server
        */
        responseServer: function ( target, resp, opts ) {
            window.Misc.removeSpinner( this.$el );
        }
   });

})(jQuery, this, this.document);
