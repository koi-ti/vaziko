/**
* Class TipoMaterialpModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.TipoMaterialpModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('tipomaterialesp.index') );
        },
        idAttribute: 'id',
        defaults: {
            'tipomaterialp_nombre': '',
            'tipomaterialp_activo': 1
        }
    });

})(this, this.document);
