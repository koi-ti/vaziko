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

            // Init Attributes
            this.confCollection = { reset: true, data: {} };
            this.$modal = $('#modal-tiempop-edit-component');

            // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner);
            this.listenTo( this.collection, 'sync', this.responseServer);

            // if was passed itemrollo code
            if( !_.isUndefined(this.parameters.dataFilter.type) && !_.isNull(this.parameters.dataFilter.type) ){
                this.confCollection.data = this.parameters.dataFilter;
                this.collection.fetch( this.confCollection );
            }
        },

        /*
        * Render View Element
        */
        render: function() {
        },

        /**
        * Render view contact by model
        * @param Object tiempopModel Model instance
        */
        addOne: function ( detalletiempopModel ) {
            var view = new app.TiempopItemView({
                model: detalletiempopModel,
                parameters: {
                    dataFilter: this.parameters.dataFilter,
                    edit: this.parameters.edit,
                }
            });

            detalletiempopModel.view = view;
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
