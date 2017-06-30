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
            return window.Misc.urlFull( Route.route('tiposmaterialp.index') );
        },
        idAttribute: 'id',
        defaults: {
            'tipomaterial_nombre': '',
            'tipomaterial_activo': 1
        }
    });

})(this, this.document);
