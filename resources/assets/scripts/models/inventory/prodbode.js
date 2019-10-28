/**
* Class ItemRolloModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ProdBodeModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull(Route.route('productos.prodbode.index'));
        },
        idAttribute: 'id',
        defaults: {}
    });

})(this, this.document);
