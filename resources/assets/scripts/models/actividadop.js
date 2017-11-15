/**
* Class ActividadOpModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ActividadOpModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('actividadesop.index') );
        },
        idAttribute: 'id',
        defaults: {
            'actividadop_nombre': '',
            'actividadop_activo': 1
        }
    });

})(this, this.document);
