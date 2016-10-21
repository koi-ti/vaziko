/**
* Class TrasladoProductosListView of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.TrasladoProductosListView = Backbone.View.extend({

        el: '#browse-detalle-traslado-list',
        events: {
            'click .item-traslado2-remove': 'removeOne'
        },
        parameters: {
            wrapper: null,
            edit: false,
            dataFilter: {}
        },

        /**
        * Constructor Method
        */
        initialize : function(opts){
            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            // References
            this.$costoTotal = this.$('#total-costo');

            // Init Attributes
            this.confCollection = { reset: true, data: {} };

            // // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner );
            this.listenTo( this.collection, 'store', this.storeOne );
            this.listenTo( this.collection, 'sync', this.responseServer );

            /* if was passed traslado code */
            if( !_.isUndefined(this.parameters.dataFilter.traslado) && !_.isNull(this.parameters.dataFilter.traslado) ){
                 this.confCollection.data.traslado = this.parameters.dataFilter.traslado;

                this.collection.fetch( this.confCollection );
            }
        },

        /**
        * Render view task by model
        * @param Object mentoringTaskModel Model instance
        */
        addOne: function (Traslado2Model) {
            var view = new app.TrasladoProductosItemView({
                model: Traslado2Model,
                parameters: {
                    edit: this.parameters.edit
                }
            });
            Traslado2Model.view = view;
            this.$el.append( view.render().el );
        },

        /**
        * Render all view tast of the collection
        */
        addAll: function () {
            this.collection.forEach( this.addOne, this );
        },

        /**
        * storescuenta
        * @param form element
        */
        storeOne: function (form) {
            var _this = this,
                data = window.Misc.formToJson( form );

            // Set Spinner
            window.Misc.setSpinner( this.parameters.wrapper );

            // Add model in collection
            var traslado2Model = new app.Traslado2Model();
            traslado2Model.save(data, {
                success : function(model, resp) {
                    if(!_.isUndefined(resp.success)) {
						window.Misc.removeSpinner( _this.parameters.wrapper );

                        // response success or error
                        var text = resp.success ? '' : resp.errors;
                        if( _.isObject( resp.errors ) ) {
                            text = window.Misc.parseErrors(resp.errors);
                        }

                        if( !resp.success ) {
                            alertify.error(text);
                            return;
                        }

                        // Add model in collection
                        _this.collection.add(model);
                    }
                },
                error : function(model, error) {
                    window.Misc.removeSpinner( _this.parameters.wrapper );
                    alertify.error(error.statusText)
                }
            });
        },

        /**
        * Event remove item
        */
        removeOne: function (e) {
            e.preventDefault();

            var resource = $(e.currentTarget).attr("data-resource");
            var model = this.collection.get(resource);
            if ( model instanceof Backbone.Model ) {
                model.view.remove();
                this.collection.remove(model);
            }
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function (model, xhr, opts) {
            window.Misc.setSpinner( this.parameters.wrapper );
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            window.Misc.removeSpinner( this.parameters.wrapper );
        }
   });

})(jQuery, this, this.document);
