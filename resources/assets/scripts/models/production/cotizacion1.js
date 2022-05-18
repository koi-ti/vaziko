/**
* Class CotizacionModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.CotizacionModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull(Route.route('cotizaciones.index'));
        },
        idAttribute: 'id',
        defaults: {
            'cotizacion1_codigo': '',
            'cotizacion1_referencia': '',
            'cotizacion1_cliente': '',
            'cotizacion1_fecha_inicio': moment().format('YYYY-MM-DD'),
            'cotizacion1_iva': '',
            'cotizacion1_contacto': '',
            'cotizacion1_suministran': '',
            'cotizacion1_formapago': '',
            'cotizacion1_observaciones': '',
            'cotizacion1_estados': 'PC',
            'cotizacion1_terminado': '',
            'cotizacion1_observaciones_archivo': '',
            'tercero_nit': '',
            'tercero_nombre': '',
            'tercero_direccion': '',
            'tercero_direccion_nomenclatura': '',
            'tercero_municipio': '',
            'tcontacto_nombre': '',
            'tcontacto_telefono': '',
            'vendedor_nit': '',
            'vendedor_nombre': ''
        }
    });

})(this, this.document);
