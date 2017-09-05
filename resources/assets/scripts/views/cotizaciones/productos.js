/**
* Class ProductopCotizacionListView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ProductopCotizacionListView = Backbone.View.extend({

        el: '#browse-cotizacion-productop-list',
        events: {
            'click .item-cotizacion-producto-remove': 'removeOne',
            'click .item-cotizacion-producto-clone': 'cloneOne'
        },
        parameters: {
        	wrapper: null,
            edit: false,
            iva: 0,
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
            this.$unidades = this.$('#subtotal-cantidad');
            this.$viaticos = this.$('#subtotal-viaticos');
            this.$transporte = this.$('#subtotal-transporte');
            this.$facturado = this.$('#subtotal-facturado');
            this.$subtotal = this.$('#subtotal-total');
            this.$iva = this.$('#iva-total');
            this.$total = this.$('#total-total');

            // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner);
            this.listenTo( this.collection, 'sync', this.responseServer);

            this.collection.fetch({ data: {cotizacion2_cotizacion: this.parameters.dataFilter.cotizacion2_cotizacion}, reset: true });
        },

        /*
        * Render View Element
        */
        render: function() {

        },

        /**
        * Render view contact by model
        * @param Object cotizacion2Model Model instance
        */
        addOne: function (cotizacion2Model) {
            var view = new app.ProductopCotizacionItemView({
                model: cotizacion2Model,
                parameters: {
                    edit: this.parameters.edit
                }
            });
            cotizacion2Model.view = view;
            this.$el.append( view.render().el );

            // Update total
            this.totalize();
        },

        /**
        * Render all view Marketplace of the collection
        */
        addAll: function () {
            this.collection.forEach( this.addOne, this );
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
                        if(!_.isUndefined(resp.success)) {
                            window.Misc.removeSpinner( _this.parameters.wrapper );

                            if( !resp.success ) {
                                alertify.error(resp.errors);
                                return;
                            }

                            model.view.remove();
                            _this.collection.remove(model);

                            // Update total
                            _this.totalize();
                        }
                    }
                });
            }
        },

        /**
        * Event clone item
        */
        cloneOne: function (e) {
            e.preventDefault();

            var _this = this,
                resource = $(e.currentTarget).attr("data-resource"),
                model = this.collection.get(resource),
                data = { cotizacion2_codigo: model.get('id'), productop_nombre: model.get('productop_nombre') };

            var cloneConfirm = new window.app.ConfirmWindow({
                parameters: {
                    dataFilter: data,
                    template: _.template( ($('#cotizacion-productop-clone-confirm-tpl').html() || '') ),
                    titleConfirm: 'Clonar producto cotización',
                    onConfirm: function () {
                        $.ajax({
                            url: window.Misc.urlFull( Route.route('cotizaciones.productos.clonar', { productos: data.cotizacion2_codigo }) ),
                            type: 'GET',
                            beforeSend: function() {
                                window.Misc.setSpinner( _this.parameters.wrapper );
                            }
                        })
                        .done(function(resp) {
                            window.Misc.removeSpinner( _this.parameters.wrapper );
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

                                window.Misc.successRedirect( resp.msg, window.Misc.urlFull(Route.route('cotizaciones.productos.show', { productos: resp.id })) );
                            }
                        })
                        .fail(function(jqXHR, ajaxOptions, thrownError) {
                            window.Misc.removeSpinner( _this.parameters.wrapper );
                            alertify.error(thrownError);
                        });
                    }
                }
            });

            cloneConfirm.render();
        },

        /**
        * Render totalize valores
        */
        totalize: function () {
            var data = this.collection.totalize();

            if(this.$unidades.length) {
                this.$unidades.html( data.unidades );
            }

            if(this.$facturado.length) {
                this.$facturado.html( data.facturado );
            }

            if(this.$subtotal.length) {
                this.$subtotal.html( window.Misc.currency(data.subtotal) );
            }

            if(this.$viaticos.length) {
                this.$viaticos.html( window.Misc.currency(data.viaticos) );
            }

            if(this.$transporte.length) {
                this.$transporte.html( window.Misc.currency(data.transporte) );
            }

            var iva = data.subtotal * ( this.parameters.iva / 100);
            if(this.$iva.length) {
                this.$iva.html( window.Misc.currency(iva) );
            }

            var total = data.subtotal + iva;
            if(this.$total.length) {
                this.$total.html( window.Misc.currency(total) );
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
        }
   });

})(jQuery, this, this.document);
