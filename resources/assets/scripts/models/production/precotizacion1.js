/**
* Class PreCotizacionModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.PreCotizacionModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull(Route.route('precotizaciones.index'));
        },
        idAttribute: 'id',
        defaults: {
            'precotizacion1_codigo': '',
            'precotizacion1_referencia': '',
            'precotizacion1_cliente': '',
            'precotizacion1_fecha': moment().format('YYYY-MM-DD'),
            'precotizacion1_contacto': moment().format('YYYY-MM-DD'),
            'tercero_nit': '',
            'tercero_nombre': '',
            'tcontacto_nombre': '',
            'tcontacto_telefono': '',
            'precotizacion1_observaciones': '',
            'precotizacion1_suministran': '',
            'precotizacion1_usuario_culminada': '',
            'precotizacion1_fh_culminada': '',
            'username_culminada': ''
        }
    });

})(this, this.document);
