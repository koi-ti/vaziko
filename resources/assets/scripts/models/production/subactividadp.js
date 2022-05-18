/**
* Class SubActividadpModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.SubActividadpModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull(Route.route('subactividadesp.index'));
        },
        idAttribute: 'id',
        defaults: {
            'subactividadp_actividadp': '',
            'subactividadp_nombre': '',
            'subactividadp_activo': 1
        }
    });

})(this, this.document);
