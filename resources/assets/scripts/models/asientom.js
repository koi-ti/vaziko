/**
* Class AsientoMovModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.AsientoMovModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('asientos.detalle.movimientos') );
        },
        idAttribute: 'id',
        defaults: {

        }
    });

})(this, this.document);
