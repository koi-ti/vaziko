/**
* Class OrdenpModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

app || (app = {});

(function (window, document, undefined){

    app.OrdenpModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('ordenes.index') );
        },
        idAttribute: 'id',
        defaults: {
            'orden_codigo': '',
            'orden_referencia': '',
            'orden_cliente': '',
            'tercero_nit': '',
            'tercero_nombre': '',
            'orden_fecha_inicio': moment().format('YYYY-MM-DD'),
            'orden_fecha_entrega': moment().format('YYYY-MM-DD'),
            'orden_hora_entrega': '',
            'orden_formapago': 'CO',
            'orden_iva': '',
            'orden_contacto': '',
            'tcontacto_nombre': '',
            'tcontacto_telefono': '',
            'orden_suministran': '',
            'orden_observaciones': '',
            'orden_terminado': ''
        }
    });

}) (this, this.document);