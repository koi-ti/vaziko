/**
* Class AsientoModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.AsientoModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull(Route.route('asientos.index'));
        },
        idAttribute: 'id',
        defaults: {
			'asiento1_ano': moment().format('YYYY'),
			'asiento1_mes': moment().format('M'),
			'asiento1_dia': moment().format('D'),
			'asiento1_folder': '',
			'asiento1_documento': '',
			'documento_tipo_consecutivo': '',
			'asiento1_numero': '',
			'asiento1_beneficiario': '',
			'tercero_nit': '',
			'tercero_nombre': '',
			'asiento1_sucursal': '',
			'asiento1_preguardado': '',
			'asiento1_detalle': '',
			'asiento1_fecha_elaboro': ''
		}
    });

})(this, this.document);
