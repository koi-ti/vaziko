/**
* Class AcabadosProductopPreCotizacionList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.AcabadosProductopPreCotizacionList = Backbone.Collection.extend({

        url: function () {
            return window.Misc.urlFull(Route.route('precotizaciones.productos.acabados.index'));
        },
        model: app.PreCotizacion5Model
   });

})(this, this.document);
