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
            'click .export-factura': 'exportFactura',
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            this.detalleFactura2List = new app.DetalleFactura2List();
            this.detalleFactura4List = new app.DetalleFactura4List();

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
                    edit: false,
                    call: 'show',
                    dataFilter: {
                        factura2: this.model.get('id')
                    }
                }
            });

            // Detalle list
            this.factura4ListView = new app.Factura4ListView({
                collection: this.detalleFactura4List,
                parameters: {
                    edit: false,
                    template: _.template( ($('#add-detalle-factura-tpl').html() || '') ),
                    call: 'factura',
                    dataFilter: {
                        factura1_id: this.model.get('id')
                    }
                }
            });
        },

        /**
        * export to PDF
        */
        exportFactura: function (e) {
            e.preventDefault();

            // Redirect to pdf
            window.open( window.Misc.urlFull( Route.route('facturas.exportar', { facturas: this.model.get('id') })) );
        }
    });

})(jQuery, this, this.document);
