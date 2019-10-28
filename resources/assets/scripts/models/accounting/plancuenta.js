/**
* Class PlanCuentaModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.PlanCuentaModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull(Route.route('plancuentas.index'));
        },
        idAttribute: 'id',
        defaults: {
        	'plancuentas_cuenta': '',
        	'plancuentas_nivel': '',
        	'plancuentas_nombre': '',
        	'plancuentas_naturaleza': 'D',
        	'plancuentas_centro': '',
        	'plancuentas_tercero': false,
        	'plancuentas_tipo': 'N',
        	'plancuentas_tasa': 0,
            'plancuentas_equivalente':''
        }
    });

})(this, this.document);
