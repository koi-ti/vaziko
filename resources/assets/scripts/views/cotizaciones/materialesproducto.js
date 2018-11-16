/**
* Class MaterialesProductopCotizacionListView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MaterialesProductopCotizacionListView = Backbone.View.extend({

        el: '#browse-cotizacion-producto-materiales-list',
        events: {
            'click .item-producto-materialp-cotizacion-remove': 'removeOne',
            'click .item-producto-materialp-cotizacion-edit': 'editOne'
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

            // Render total
            this.$total = this.$('#total');

            // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner);
            this.listenTo( this.collection, 'store', this.storeOne);
            this.listenTo( this.collection, 'sync', this.responseServer);

            // Trigger on
            this.on('totalize', this.totalize, this);

            this.collection.fetch({ data: this.parameters.dataFilter, reset: true });
        },

        /*
        * Render View Element
        */
        render: function() {

        },

        /**
        * Render view contact by model
        * @param Object cotizacion4Model Model instance
        */
        addOne: function (cotizacion4Model) {
            var view = new app.MaterialesProductopCotizacionItemView({
                model: cotizacion4Model,
                parameters: {
                    edit: this.parameters.edit
                }
            });
            cotizacion4Model.view = view;
            this.$el.append( view.render().el );
        },

        /**
        * Render all view Marketplace of the collection
        */
        addAll: function () {
            this.$el.find('tbody').html('');
            this.collection.forEach( this.addOne, this );

            this.totalize();
        },

        /**
        * store
        * @param form element
        */
        storeOne: function ( data ) {
            var _this = this;

            // Set Spinner
            window.Misc.setSpinner( this.parameters.wrapper );

            // Add model in collection
            var cotizacion4Model = new app.Cotizacion4Model();
                cotizacion4Model.save(data, {
                    success : function(model, resp) {
                        if(!_.isUndefined(resp.success)) {
                            window.Misc.removeSpinner( _this.parameters.wrapper );
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
                            _this.totalize();
                            window.Misc.clearForm( $('#form-cotizacion4-producto') );
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

            var resource = $(e.currentTarget).attr("data-resource"),
                model = this.collection.get(resource);

            if( _.isUndefined(this.parameters.dataFilter.cotizacion2) ){
                if ( model instanceof Backbone.Model ) {
                    model.view.remove();
                    this.collection.remove(model);
                    this.totalize();
                }
            }else{
                var reg = /[A-Za-z]/;
                if( !reg.test(resource) ){
                    this.confirmDelete( model );
                }else{
                    if ( model instanceof Backbone.Model ) {
                        model.view.remove();
                        this.collection.remove(model);
                        this.totalize();
                    }
                }
            }
        },

        /**
        * modal confirm delete area
        */
        confirmDelete: function( model ) {
            var _this = this;

            var cancelConfirm = new window.app.ConfirmWindow({
                parameters: {
                    dataFilter: { materialp_nombre: model.get('materialp_nombre')},
                    template: _.template( ($('#cotizacion-delete-materialp-confirm-tpl').html() || '') ),
                    titleConfirm: 'Eliminar material de producción',
                    onConfirm: function () {
                        if ( model instanceof Backbone.Model ) {
                            model.destroy({
                                success : function(model, resp) {
                                    if(!_.isUndefined(resp.success)) {
                                        window.Misc.removeSpinner( _this.el );

                                        if( !resp.success ) {
                                            alertify.error(resp.errors);
                                            return;
                                        }

                                        model.view.remove();
                                        _this.totalize();
                                    }
                                }
                            });
                        }
                    }
                }
            });

            cancelConfirm.render();
        },

        editOne: function(e){
            e.preventDefault();

            // Open materialesProductoActionView
            if ( this.materialesProductoActionView instanceof Backbone.View ){
                this.materialesProductoActionView.stopListening();
                this.materialesProductoActionView.undelegateEvents();
            }

            var resource = this.$(e.currentTarget).attr("data-resource"),
                model = this.collection.get(resource);

            if( model instanceof Backbone.Model ){
                this.materialesProductoActionView = new app.MaterialesProductoActionView({
                    model: model,
                    collection: this.collection,
                    parameters: {
                        call: 'cotizacion'
                    }
                });

                this.materialesProductoActionView.render();
            }
        },

        /**
        *Render totales the collection
        */
        totalize: function(){
            var data = this.collection.totalize();

            // Llamar funcion de calculate del modelo createProducto(cotizacion)
            this.model.trigger('calculateAll');

            if(this.$total.length) {
                this.$total.empty().html( window.Misc.currency( data.total ) );
            }
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {
            window.Misc.setSpinner( this.el );
        },

        /**
        * response of the server
        */
        responseServer: function ( target, resp, opts ) {
            window.Misc.removeSpinner( this.el );
        }
   });

})(jQuery, this, this.document);
