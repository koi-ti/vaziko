/**
* Class AcabadosProductopOrdenList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.AcabadosProductopOrdenList = Backbone.Collection.extend({

        url: function () {
            return window.Misc.urlFull(Route.route('ordenes.productos.acabados.index'));
        },
        model: app.Ordenp5Model
   });

})(this, this.document);
