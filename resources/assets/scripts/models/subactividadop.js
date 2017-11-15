/**
* Class SubActividadOpModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.SubActividadOpModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('subactividadesop.index') );
        },
        idAttribute: 'id',
        defaults: {
            'subactividadop_actividad': '',
            'subactividadop_nombre': '',
            'subactividadop_activo': 1
        }
    });

})(this, this.document);
