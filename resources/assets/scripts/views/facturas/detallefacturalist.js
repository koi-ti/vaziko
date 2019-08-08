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
            'click .item-remove': 'removeOne',
            'change .change-cantidad': 'changeCantidad'
        },
        parameters: {
            dataFilter: {}
        },

        /**
        * Constructor Method
        */
        initialize: function (opts) {
            // extends parameters
            if (opts !== undefined && _.isObject(opts.parameters))
                this.parameters = $.extend({},this.parameters, opts.parameters);

            // References
            this.$facturado = this.$('#subtotal-facturado');
            this.$subtotal = this.$('#subtotal-create');
            this.$piva = this.$('#p_iva-create');
            this.$iva = this.$('#iva-create');
            this.$rtefuente = this.$('#rtefuente-create');
            this.$rteica = this.$('#rteica-create');
            this.$rteiva = this.$('#rteiva-create');
            this.$total = this.$('#total-create');
            this.impuestos = {};

            // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'store', this.storeOne );
            this.listenTo( this.collection, 'request', this.loadSpinner);
            this.listenTo( this.collection, 'sync', this.responseServer);

            if (this.parameters.dataFilter.factura) {
                this.collection.fetch({data: this.parameters.dataFilter, reset: true});
            }
        },

        /**
        * Render view contact by model
        * @param Object detallePedidocModel Model instance
        */
        addOne: function (factura2Model) {
            var view = new app.DetalleFacturaItemView({
                model: factura2Model
            });
            factura2Model.view = view;
            this.$el.append(view.render().el);
        },

        /**
        * Render all view Marketplace of the collection
        */
        addAll: function () {
            this.$el.find('tbody').html('');
            this.collection.forEach( this.addOne, this );
        },

        /**
        * Change cantidad input
        */
        changeCantidad: function (e) {
            var selector = this.$(e.currentTarget);

            // rules && validate
            var min = selector.attr('min');
            var max = selector.attr('max');
            if (selector.val() < parseInt(min) || _.isEmpty(selector.val())) {
                selector.val(min);
            }

            if (selector.val() > parseInt(max)) {
                selector.val(max);
            }

            // Settear el valor al modelo
            var resource = $(e.currentTarget).attr("data-resource"),
                model = this.collection.get(resource);

            model.set({factura2_cantidad: selector.val()}, {silent: true});

            this.impuestos.subtotal = this.collection.totalize().subtotal;
            this.impuestos.tercero = $('#factura1_tercero').val();

            this.calculateImpuestos();
        },

        /**
        * Change cantidad input
        */
        calculateImpuestos: function () {
            var _this = this;

            $.get(window.Misc.urlFull(Route.route('facturas.impuestos', this.impuestos)), function (resp) {
                if (resp.success) {
                    _this.$subtotal.html(window.Misc.currency(resp.subtotal))
                    _this.$piva.html('IVA ' + resp.p_iva + ' %')
                    _this.$iva.val(window.Misc.currency(resp.iva))
                    _this.$rtefuente.val(window.Misc.currency(resp.rtefuente))
                    _this.$rteica.val(window.Misc.currency(resp.rteica))
                    _this.$rteiva.val(window.Misc.currency(resp.rteiva))
                    _this.$total.html(window.Misc.currency(resp.total))
                }
            });
        },
        /**
        * store
        * @param form element
        */
        storeOne: function (data, form) {
            var _this = this

            // Validate duplicate store
            var result = this.collection.validar( data );
            if( !result.success ){
                alertify.error( result.error );
                return;
            }

            // Set Spinner
            window.Misc.setSpinner(this.parameters.wrapper);

            // Add model in collection
            var factura2Model = new app.Factura2Model();
                factura2Model.save(data, {
                    success: function (model, resp) {
                        if (!_.isUndefined(resp.success)) {
                            // response success or error
                            window.Misc.removeSpinner( _this.parameters.wrapper );
                            var text = resp.success ? '' : resp.errors;
                            if (_.isObject(resp.errors)) {
                                text = window.Misc.parseErrors(resp.errors);
                            }

                            if (!resp.success) {
                                alertify.error(text);
                                return;
                            }

                            // Add model in collection
                            _this.collection.add(model);
                            window.Misc.clearForm(form);
                        }
                    },
                    error: function (model, error) {
                        window.Misc.removeSpinner(_this.parameters.wrapper);
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

                console.log(model);

            if (model instanceof Backbone.Model) {
                var cancelConfirm = new window.app.ConfirmWindow({
                    parameters: {
                        dataFilter: {
                            codigo: model.get('factura2_orden2'),
                            nombre: model.get('factura2_producto_nombre')
                        },
                        template: _.template( ($('#delete-item-factura-confirm-tpl').html() || '') ),
                        titleConfirm: 'Eliminar producto',
                        onConfirm: function () {
                            model.view.remove();
                            _this.collection.remove(model);
                            _this.impuestos.subtotal = _this.collection.totalize().subtotal;
                            _this.calculateImpuestos();

                            if (!this.collection.length)  {
                                $('#iva-create').attr('readonly', true);
                                $('#rtefuente-create').attr('readonly', true)
                                $('#rteica-create').attr('readonly', true)
                                $('#rteiva-create').attr('readonly', true)
                            }
                        }
                    }
                });

                cancelConfirm.render();
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
        }
   });

})(jQuery, this, this.document);
