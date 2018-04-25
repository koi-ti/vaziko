/**
* Class MaterialesProductopPreCotizacionListView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MaterialesProductopPreCotizacionListView = Backbone.View.extend({

        el: '#browse-precotizacion-producto-materiales-list',
        events: {
            'click .item-producto-materialp-precotizacion-remove': 'removeOne'
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
        addOne: function (precotizacion3Model) {
            var view = new app.MaterialesProductopPreCotizacionItemView({
                model: precotizacion3Model,
                parameters: {
                    edit: this.parameters.edit
                }
            });
            precotizacion3Model.view = view;
            this.$el.append( view.render().el );

            this.totalize();
        },

        /**
        * Render all view Marketplace of the collection
        */
        addAll: function () {
            this.$el.find('tbody').html('');
            this.collection.forEach( this.addOne, this );
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
            var precotizacion3Model = new app.PreCotizacion3Model();
            precotizacion3Model.save(data, {
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
                        window.Misc.clearForm( $('#form-precotizacion3-producto') );
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

            if( _.isUndefined(this.parameters.dataFilter.precotizacion2) ){
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
                    template: _.template( ($('#precotizacion-delete-materialp-confirm-tpl').html() || '') ),
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

        /**
        *Render totales the collection
        */
        totalize: function(){
            var data = this.collection.totalize();
            if(this.$total.length) {
                this.$total.empty().html( window.Misc.currency( data.total ) );
            }
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
        },
   });

})(jQuery, this, this.document);
