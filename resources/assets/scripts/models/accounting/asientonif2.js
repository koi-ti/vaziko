/**
* Class AsientoNif2Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.AsientoNif2Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull(Route.route('asientosnif.detalle.index'));
        },
        idAttribute: 'id',
        defaults: {
            'asienton2_asiento': '',
            'asienton2_cuenta': '',
            'asienton2_beneficiario': '',
            'asienton2_debito': 0,
            'asienton2_credito': 0,
            'asienton2_centro': '',
            'asienton2_base': 0,
            'asienton2_detalle': '',
            'asienton2_orden': '',
            'plancuentasn_cuenta': '',
            'plancuentasn_nombre': '',
            'tercero_nit': '',
            'tercero_nombre': '',
            'centrocosto_nombre': '',
            'ordenp_codigo': '',
            'ordenp_beneficiario': '',
        }
    });

})(this, this.document);
