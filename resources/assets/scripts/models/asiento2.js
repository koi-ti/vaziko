/**
* Class Asiento2Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.Asiento2Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('asientos.detalle.index') );
        },
        idAttribute: 'id',
        defaults: {
        	'asiento2_asiento': '',
            'asiento2_cuenta': '',
            'asiento2_beneficiario': '',
            'asiento2_debito': 0,
            'asiento2_credito': 0,
            'asiento2_centro': '',
            'asiento2_base': 0,
            'asiento2_detalle': '',
            'asiento2_orden': '',
        	'plancuentas_cuenta': '',
        	'plancuentas_nombre': '',
            'tercero_nit': '',
        	'tercero_nombre': '',
            'centrocosto_nombre': '',
            'ordenp_codigo': '',
            'ordenp_beneficiario': '',
        }
    });

})(this, this.document);
