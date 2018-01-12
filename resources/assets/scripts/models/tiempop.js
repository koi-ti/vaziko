/**
* Class TiempopModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.TiempopModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('tiemposp.index') );
        },
        idAttribute: 'id',
        defaults: {
        }
    });

})(this, this.document);
