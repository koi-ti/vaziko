/**
* Class AreasProductopCotizacionListView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.AreasProductopCotizacionListView = Backbone.View.extend({

        el: '#browse-cotizacion-producto-areas-list',
        events: {
            'click .item-producto-areas-remove': 'removeOne',
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

            // References
            this.$total = this.$('#total');

            // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'store', this.storeOne );
            this.listenTo( this.collection, 'request', this.loadSpinner);
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
        * @param Object cotizacion6Model Model instance
        */
        addOne: function (cotizacion6Model) {
            var view = new app.AreasProductopCotizacionItemView({
                model: cotizacion6Model,
                parameters: {
                    edit: this.parameters.edit
                }
            });
            cotizacion6Model.view = view;
            this.$el.append( view.render().el );

            // Totaliza
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

            // Validar carrito temporal
            var valid = this.collection.validar( data );
            if(!valid.success) {
                alertify.error(valid.message);
                return;
            }

            // Set Spinner
            window.Misc.setSpinner( this.parameters.wrapper );

            // Add model in collection
            var cotizacion6Model = new app.Cotizacion6Model();
            cotizacion6Model.save(data, {
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
                    this.areaDelete(model);
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
        areaDelete: function(model, cotizacion2) {
            var _this = this;

            var cancelConfirm = new window.app.ConfirmWindow({
                parameters: {
                    dataFilter: { cotizacion6_nombre: model.get('cotizacion6_nombre'), cotizacion6_areap: model.get('areap_nombre')},
                    template: _.template( ($('#cotizacion-delete-confirm-tpl').html() || '') ),
                    titleConfirm: 'Eliminar área',
                    onConfirm: function () {
                        if ( model instanceof Backbone.Model ) {
                            model.destroy({
                                success : function(model, resp) {
                                    if(!_.isUndefined(resp.success)) {
                                        window.Misc.removeSpinner( _this.parameters.wrapper );

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
            // Llamar funcion de calculateOrdenp2 del modelo Ordnep2
            this.parameters.model.trigger('calculateCotizacion2')

            // Render table total areas
            var data = this.collection.totalize();
            if(this.$total.length){
                this.$total.empty().html( window.Misc.currency( data.total ) );
            }
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {
            window.Misc.setSpinner( this.parameters.wrapper );
        },

        /**
        * response of the server
        */
        responseServer: function ( target, resp, opts ) {
            window.Misc.removeSpinner( this.parameters.wrapper );

            if(!_.isUndefined(resp.success)) {
                // response success or error
                var text = resp.success ? '' : resp.errors;
                if( _.isObject( resp.errors ) ) {
                    text = window.Misc.parseErrors(resp.errors);
                }

                if( !resp.success ) {
                    alertify.error(text);
                    return;
                }

                window.Misc.clearForm( $('#form-cotizacion6-producto') );
            }
        },
   });

})(jQuery, this, this.document);
