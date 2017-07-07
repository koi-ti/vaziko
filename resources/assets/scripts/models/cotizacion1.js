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
            return window.Misc.urlFull( Route.route('cotizaciones.index') );
        },
        idAttribute: 'id',
        defaults: {
            'cotizacion1_numero': '',
            'cotizacion1_ano': moment().format('YYYY'),
            'cotizacion1_fecha': moment().format('YYYY-MM-DD'),
            'cotizacion1_entrega': moment().format('YYYY-MM-DD'),
            'cotizacion1_descripcion': '',
            'cotizacion1_cliente': '',
            'cotizacion1_contacto': '',
            'cotizacion1_aprobada': 1,
            'cotizacion1_anulada': 1,
            'tercero_nit': '',
            'tercero_nombre': '',
            'tcontacto_nombre': '',
            'tcontacto_telefono': '',
        }
    });

})(this, this.document);
