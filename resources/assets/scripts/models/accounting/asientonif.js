/**
* Class AsientoNifModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.AsientoNifModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull(Route.route('asientosnif.index'));
        },
        idAttribute: 'id',
        defaults: {
			'asienton1_ano': moment().format('YYYY'),
			'asienton1_mes': moment().format('M'),
			'asienton1_dia': moment().format('D'),
			'asienton1_folder': '',
			'asienton1_documento': '',
			'documento_tipo_consecutivo': '',
			'asienton1_numero': '',
			'asienton1_beneficiario': '',
			'tercero_nit': '',
			'tercero_nombre': '',
			'asienton1_sucursal': '',
			'asienton1_preguardado': '',
			'asienton1_detalle': '',
			'asienton1_fecha_elaboro': ''
		}
    });

})(this, this.document);
