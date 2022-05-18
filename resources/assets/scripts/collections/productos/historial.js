/**
* Class ProductoHistorialList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ProductoHistorialList = Backbone.Collection.extend({

        url: function () {
            return window.Misc.urlFull(Route.route('productos.historial.index'));
        },
        model: app.ProductoHistorialModel
   });

})(this, this.document);
