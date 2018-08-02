/**
* Class DetalleFacturaView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.DetalleFacturaView = Backbone.View.extend({

        el: '#browse-detalle-factura-list',
        events: {
            'click .item-detail-factura-remove': 'removeOne',
            'change .change-cantidad': 'changeCantidad'
        },

        parameters: {
            dataFilter: {}
        },

        /**
        * Constructor Method
        */
        initialize : function(opts){
            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            //Init Attributes
            this.confCollection = { reset: true, data: {} };

            // References
            this.$facturado = this.$('#subtotal-facturado');
            this.impuestos = {};

            // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'store', this.storeOne );
            this.listenTo( this.collection, 'request', this.loadSpinner);
            this.listenTo( this.collection, 'sync', this.responseServer);

            if( !_.isUndefined(this.parameters.dataFilter) && !_.isNull(this.parameters.dataFilter) ){
                this.confCollection.data = this.parameters.dataFilter;
                this.collection.fetch( this.confCollection );
            }
        },

        /**
        * Render view contact by model
        * @param Object detallePedidocModel Model instance
        */
        addOne: function (factura2Model) {
            var view = new app.DetalleFacturaItemView({
                model: factura2Model,
                parameters: {
                    edit: this.parameters.edit,
                }
            });
            factura2Model.view = view;
            this.$el.append( view.render().el );

            //totalize actually in collection
            this.totalize();
        },

        /**
        * Render all view Marketplace of the collection
        */
        addAll: function () {
            this.$el.find('tbody').html('');
            this.collection.forEach( this.addOne, this );
        },


        changeCantidad: function(e) {
            var selector = this.$(e.currentTarget);

            // rules && validate
            var min = selector.attr('min');
            var max = selector.attr('max');
            if( selector.val() < parseInt(min) || selector.val() > parseInt(max) || _.isEmpty( selector.val() ) ){
                selector.parent().addClass('has-error');
                return;
            }else{
                selector.parent().removeClass('has-error');
            }

            // Settear el valor al modelo
            var resource = $(e.currentTarget).attr("data-resource");
            var model = this.collection.get(resource);
            model.set({ "factura2_cantidad": selector.val() }, {silent: true});
            this.impuestos.subtotal = this.collection.totalize().subtotal;
            this.impuestos.tercero = model.get('tercero');
            this.calculateImpuestos();
        },

        calculateImpuestos: function() {
            $.ajax({
                url: window.Misc.urlFull(Route.route('facturas.impuestos')),
                type: 'GET',
                data:{ item: this.impuestos }
            })
            .done(function(resp) {
                if (!resp.success) {
                    alertify.error(resp.errors);
                }
                $('#subtotal-create').html(window.Misc.currency(resp.subtotal))
                $('#p_iva-create').html('IVA ' + resp.p_iva + ' %')
                $('#iva-create').val(window.Misc.currency(resp.iva))
                $('#rtefuente-create').val(window.Misc.currency(resp.rtefuente))
                $('#rteica-create').val(window.Misc.currency(resp.rteica))
                $('#rteiva-create').val(window.Misc.currency(resp.rteiva))
                $('#total-create').html(window.Misc.currency(resp.total))
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                alertify.error(thrownError);
            });
        },
        /**
        * store
        * @param form element
        */
        storeOne: function (data) {
            var _this = this

            // Validate duplicate store
            var result = this.collection.validar( data );
            if( !result.success ){
                alertify.error( result.error );
                return;
            }

            // Set Spinner
            window.Misc.setSpinner( this.parameters.wrapper );

            // Add model in collection
            var factura2Model = new app.Factura2Model();
            factura2Model.save(data, {
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
                this.impuestos.tercero = model.get('tercero');
                model.view.remove();
                this.collection.remove(model);
                this.impuestos.subtotal = this.collection.totalize().subtotal;
                this.calculateImpuestos();
            }
            if (!this.collection.length)  {
                $('#iva-create').attr('readonly', true);
                $('#rtefuente-create').attr('readonly', true)
                $('#rteica-create').attr('readonly', true)
                $('#rteiva-create').attr('readonly', true)
            }
        },

        /**
        * Render totalize valores
        */
        totalize: function () {
            var data = this.collection.totalize();

            if(this.$facturado.length) {
                this.$facturado.html( data.facturado );
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

                window.Misc.clearForm( this.parameters.form );
            }
        }
   });

})(jQuery, this, this.document);
