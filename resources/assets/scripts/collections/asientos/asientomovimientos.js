/**
* Class AsientoMovimientosList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.AsientoMovimientosList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull(Route.route('asientos.detalle.movimientos'));
        },
        model: app.AsientoMovModel,

        /**
        * Constructor Method
        */
        initialize: function () {
            //
        }
   });

})(this, this.document);
