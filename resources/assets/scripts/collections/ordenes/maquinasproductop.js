/**
* Class MaquinasProductopOrdenList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.MaquinasProductopOrdenList = Backbone.Collection.extend({

        url: function () {
            return window.Misc.urlFull(Route.route('ordenes.productos.maquinas.index'));
        },
        model: app.Ordenp3Model
   });

})(this, this.document);
