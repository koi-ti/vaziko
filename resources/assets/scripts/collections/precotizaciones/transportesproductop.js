/**
* Class TransportesProductopPreCotizacionList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.TransportesProductopPreCotizacionList = Backbone.Collection.extend({

        url: function () {
            return window.Misc.urlFull(Route.route('precotizaciones.productos.transportes.index'));
        },
        model: app.PreCotizacion10Model
   });

})(this, this.document);
