/**
* Class AcabadosProductopCotizacionList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.AcabadosProductopCotizacionList = Backbone.Collection.extend({

        url: function () {
            return window.Misc.urlFull(Route.route('cotizaciones.productos.acabados.index'));
        },
        model: app.Cotizacion5Model
   });

})(this, this.document);
