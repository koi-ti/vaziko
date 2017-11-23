/**
* Class ActividadpModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ActividadpModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('actividadesp.index') );
        },
        idAttribute: 'id',
        defaults: {
            'actividadp_nombre': '',
            'actividadp_activo': 1
        }
    });

})(this, this.document);
