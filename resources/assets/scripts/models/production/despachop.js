/**
* Class DespachopModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.DespachopModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull(Route.route('ordenes.despachos.index'));
        },
        idAttribute: 'id',
        defaults: {
            'despachop1_anulado': 0
		}
    });

})(this, this.document);
