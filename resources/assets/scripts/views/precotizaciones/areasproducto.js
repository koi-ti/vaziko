/**
* Class AreasProductopPreCotizacionListView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.AreasProductopPreCotizacionListView = Backbone.View.extend({

        el: '#browse-precotizacion-producto-areas-list',
        events: {
            'click .item-producto-areasp-precotizacion-remove': 'removeOne',
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

            if (this.parameters.dataFilter.precotizacion2)
                this.collection.fetch({ data: this.parameters.dataFilter, reset: true });
        },

        /**
        * Render view contact by model
        * @param Object precotizacion6Model Model instance
        */
        addOne: function ( precotizacion6Model ) {
            var view = new app.AreasProductopPreCotizacionItemView({
                collection: this.collection,
                model: precotizacion6Model,
                parameters: {
                    edit: this.parameters.edit
                }
            });
            precotizacion6Model.view = view;
            this.$el.append( view.render().el );
        },

        /**
        * Render all view Marketplace of the collection
        */
        addAll: function () {
            this.$el.find('tbody').html('');
            this.collection.forEach( this.addOne, this );

            // Totalize
            this.totalize();
        },

        /**
        * store
        * @param form element
        */
        storeOne: function (data, form) {
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
            var precotizacion6Model = new app.PreCotizacion6Model();
            precotizacion6Model.save(data, {
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
                        window.Misc.clearForm(form);
                        _this.collection.add(model);
                        _this.totalize();
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
                model = this.collection.get(resource),
                _this = this;

            if ( model instanceof Backbone.Model ) {
                var cancelConfirm = new window.app.ConfirmWindow({
                    parameters: {
                        dataFilter: { precotizacion6_nombre: model.get('precotizacion6_nombre'), precotizacion6_areap: model.get('areap_nombre')},
                        template: _.template( ($('#precotizacion-delete-areap-confirm-tpl').html() || '') ),
                        titleConfirm: 'Eliminar área de producción',
                        onConfirm: function () {
                            model.view.remove();
                            _this.collection.remove(model);
                            _this.totalize();
                        }
                    }
                });

                cancelConfirm.render();
            }
        },

        /**
        *Render totales the collection
        */
        totalize: function(){
            // Totalize collection
            var data = this.collection.totalize();

            if( this.$total.length ){
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
        },
   });

})(jQuery, this, this.document);
