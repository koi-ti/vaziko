/**
* Class ShowFacturaView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ShowFacturapView = Backbone.View.extend({

        el: '#facturap-show',

        /**
        * Constructor Method
        */
        initialize : function() {

            // Model exist
            if( this.model.id != undefined ) {
                this.cuotasFPList = new app.CuotasFPList();

                // Reference views
                this.referenceViews();
            }
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            // Detalle factura list
            this.detalleFacturapView = new app.DetalleFacturapView({
                collection: this.cuotasFPList,
                parameters: {
                    edit: false,
                    dataFilter: {
                        facturap1: this.model.get('id')
                    }
                }
            });
        },

    });

})(jQuery, this, this.document);
