/**
* Class DetalleCotizacion2ListView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.DetalleCotizacion2ListView = Backbone.View.extend({

        el: '#browse-cotizacion2-list',
        events: {
            'click .item-cotizacion2-remove': 'removeOne'
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

            this.collection.fetch({ data: {cotizacion: this.parameters.dataFilter.cotizacion}, reset: true });
        },

        /*
        * Render View Element
        */
        render: function() {

        },

        /**
        * Render view contact by model
        * @param Object ordenp2Model Model instance
        */
        addOne: function (cotizacion2Model) {                        
            var view = new app.DetalleCotizacionItemView({
                model: cotizacion2Model,
                parameters:{
                    edit: this.parameters.edit,
                }
            });
            cotizacion2Model.view = view;
            this.$el.append( view.render().el );

            // Totalize
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
        * storescuenta
        * @param form element
        */
        storeOne: function ( data ) {
            var _this = this;

            // Set Spinner
            window.Misc.setSpinner( _this.parameters.wrapper );

            // Add model in collection
            var cotizacion2Model = new app.Cotizacion2Model();
            cotizacion2Model.save(data, {
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
                model = this.collection.get(resource),
                _this = this;

            if ( model instanceof Backbone.Model ) {
                model.destroy({
                    success : function(model, resp) {
                        window.Misc.removeSpinner( _this.parameters.wrapper );

                        if( !resp.success ) {
                            alertify.error(resp.errors);
                            return;
                        }

                        model.view.remove();

                        // Update
                        _this.totalize();
                        _this.collection.fetch({ data: {cotizacion: _this.parameters.dataFilter.cotizacion}, reset: true });

                    }
                });
            }
        },

        /**
        * Render totalize valores
        */
        totalize: function () {
            var data = this.collection.totalize();

            if( this.$total.length ) {
                this.$total.html( window.Misc.currency( data.total ) );
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

                this.collection.fetch({ data: {cotizacion: this.parameters.dataFilter.cotizacion}, reset: true });
            }
        }
   });

})(jQuery, this, this.document);
