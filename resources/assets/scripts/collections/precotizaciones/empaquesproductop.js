/**
* Class EmpaquesProductopPreCotizacionList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.EmpaquesProductopPreCotizacionList = Backbone.Collection.extend({

        url: function () {
            return window.Misc.urlFull(Route.route('precotizaciones.productos.empaques.index'));
        },
        model: app.PreCotizacion9Model
   });

})(this, this.document);
