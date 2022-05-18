/**
* Class BitacoraCotizacionList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.BitacoraCotizacionList = Backbone.Collection.extend({

        url: function () {
            return window.Misc.urlFull(Route.route('cotizaciones.bitacora.index'));
        },
        model: app.BitacoraModel
   });

})(this, this.document);
