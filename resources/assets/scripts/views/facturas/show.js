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

            // Model exist
            if( this.model.id != undefined ) {
                this.detalleFactura2List = new app.DetalleFactura2List();

                // Reference views
                this.referenceViews();
            }
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            // Detalle factura list
            this.facturaDetalle2View = new app.FacturaDetalle2View({
                collection: this.detalleFactura2List,
                parameters: {
                    edit: false,
                    dataFilter: {
                        factura2: this.model.get('id')
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
