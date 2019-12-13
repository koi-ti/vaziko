/**
* Class MaterialesProductopPreCotizacionList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.MaterialesProductopPreCotizacionList = Backbone.Collection.extend({

        url: function () {
            return window.Misc.urlFull(Route.route('precotizaciones.productos.materiales.index'));
        },
        model: app.PreCotizacion4Model
   });

})(this, this.document);
