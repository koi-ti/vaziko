/**
* Class AsientoFacturaCommentsList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.AsientoFacturaCommentsList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('asientos.facturas.detalle.index') );
        },
        model: app.Factura3Model,

        /**
        * Constructor Method
        */
        initialize : function() {
        }
   });
})(this, this.document);
