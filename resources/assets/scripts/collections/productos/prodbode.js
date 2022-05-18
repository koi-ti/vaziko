/**
* Class ItemRolloINList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ProdBodeList = Backbone.Collection.extend({

        url: function () {
            return window.Misc.urlFull(Route.route('productos.prodbode.index'));
        },
        model: app.ProdBodeModel
   });

})(this, this.document);
