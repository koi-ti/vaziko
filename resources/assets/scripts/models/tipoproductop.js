/**
* Class TipoProductopModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.TipoProductopModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('tipoproductosp.index') );
        },
        idAttribute: 'id',
        defaults: {
            'tipoproductop_nombre': '',
            'tipoproductop_activo': 1
        }
    });

})(this, this.document);
