/**
* Class ShowFacturaView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ShowFacturaView = Backbone.View.extend({

        el: '#factura-show',
        events: {
            'click .imprimir-factura': 'imprimirFactura',
            'click .anular-factura': 'anularFactura'
        },

        /**
        * Constructor Method
        */
        initialize: function () {
            // Initalize collections
            this.detalleFactura2List = new app.DetalleFactura2List();
            this.detalleFactura4List = new app.DetalleFactura4List();

            // Refernece spinner
            this.spinner = this.$('.spinner-main');

            // Reference views
            this.referenceViews();
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            // Detalle factura list
            this.factura2ListView = new app.DetalleFacturaView({
                collection: this.detalleFactura2List,
                parameters: {
                    wrapper: this.spinner,
                    edit: false,
                    dataFilter: {
                        factura: this.model.get('id')
                    }
                }
            });

            // Detalle list
            this.factura4ListView = new app.Factura4ListView({
                collection: this.detalleFactura4List,
                parameters: {
                    wrapper: this.spinner,
                    edit: false,
                    template: _.template(($('#add-detalle-factura-tpl').html() || '')),
                    call: 'factura',
                    dataFilter: {
                        factura: this.model.get('id')
                    }
                }
            });
        },

        /**
        * imprimir to PDF
        */
        imprimirFactura: function (e) {
            e.preventDefault();

            // Redirect to pdf
            window.open(window.Misc.urlFull(Route.route('facturas.exportar', { facturas: this.model.get('id') })));
        },

        /**
        * Event anular factura
        */
        anularFactura: function (e) {
            e.preventDefault();
            var _this = this;

            var banConfirm = new window.app.ConfirmWindow({
                parameters: {
                    template: _.template(($('#factura-anular-confirm-tpl').html() || '')),
                    titleConfirm: 'Anular factura',
                    onConfirm: function () {
                        // Anular factura
                        $.ajax({
                            url: window.Misc.urlFull(Route.route('facturas.anular', {facturas: _this.model.get('id')})),
                            type: 'GET',
                            beforeSend: function() {
                                window.Misc.setSpinner(_this.spinner);
                            }
                        })
                        .done(function(resp) {
                            window.Misc.removeSpinner(_this.spinner);
                            if (!_.isUndefined(resp.success)) {
                                // response success or error
                                var text = resp.success ? '' : resp.errors;
                                if (_.isObject(resp.errors)) {
                                    text = window.Misc.parseErrors(resp.errors);
                                }

                                if (!resp.success) {
                                    alertify.error(text);
                                    return;
                                }

                                window.Misc.successRedirect(resp.msg, window.Misc.urlFull(Route.route('facturas.show', { facturas: _this.model.get('id') })));
                            }
                        })
                        .fail(function(jqXHR, ajaxOptions, thrownError) {
                            window.Misc.removeSpinner(_this.spinner);
                            alertify.error(thrownError);
                        });
                    }
                }
            });

            banConfirm.render();
        }
    });

})(jQuery, this, this.document);
