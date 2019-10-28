/**
* Class ProductoHistoryList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ProductoHistoryList = Backbone.Collection.extend({

        url: function () {
            return window.Misc.urlFull(Route.route('productos.history.index'));
        },
        model: app.ProductoHistoryModel
   });

})(this, this.document);
