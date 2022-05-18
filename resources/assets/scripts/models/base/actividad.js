/**
* Class ActividadModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ActividadModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull(Route.route('actividades.index'));
        },
        idAttribute: 'id',
        defaults: {
        	'actividad_codigo': '',
        	'actividad_nombre': '',
        	'actividad_tarifa': '0',
        	'actividad_categoria': ''
        }
    });

})(this, this.document);
