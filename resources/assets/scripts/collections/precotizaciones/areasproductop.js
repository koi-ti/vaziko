/**
* Class AreasProductopPreCotizacionList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.AreasProductopPreCotizacionList = Backbone.Collection.extend({

        url: function () {
            return window.Misc.urlFull(Route.route('precotizaciones.productos.areas.index'));
        },
        model: app.PreCotizacion6Model
   });

})(this, this.document);
