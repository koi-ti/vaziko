/**
* Class PlanCuentaModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.PlanCuentaNifModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('plancuentasnif.index') );
        },
        idAttribute: 'id',
        defaults: {
        	'plancuentasn_cuenta': '',	
        	'plancuentasn_nivel': '',	
        	'plancuentasn_nombre': '',	
        	'plancuentasn_naturaleza': 'D',	
        	'plancuentasn_centro': '',	
        	'plancuentasn_tercero': 0,	
        	'plancuentasn_tipo': 'N',	
        	'plancuentasn_tasa': 0
        }
    });

})(this, this.document);
