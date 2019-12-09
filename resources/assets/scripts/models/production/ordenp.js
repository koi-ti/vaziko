/**
* Class OrdenpModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

app || (app = {});

(function (window, document, undefined){

    app.OrdenpModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull(Route.route('ordenes.index'));
        },
        idAttribute: 'id',
        defaults: {
            'orden_codigo': '',
            'orden_referencia': '',
            'orden_cliente': '',
            'orden_fecha_inicio': moment().format('YYYY-MM-DD'),
            'orden_fecha_entrega': moment().format('YYYY-MM-DD'),
            'orden_hora_entrega': '',
            'orden_formapago': '',
            'orden_iva': '',
            'orden_contacto': '',
            'orden_suministran': '',
            'orden_observaciones': '',
            'orden_terminado': '',
            'orden_observaciones_archivo': '',
            'orden_fecha_recogida1': '',
            'orden_fecha_recogida2': '',
            'orden_hora_recogida1': '',
            'orden_hora_recogida2': '',
            'orden_estado_recogida1': '',
            'orden_estado_recogida2': '',
            'tercero_nit': '',
            'tercero_nombre': '',
            'tercero_direccion': '',
            'tercero_dir_nomenclatura': '',
            'tercero_municipio': '',
            'tcontacto_nombre': '',
            'tcontacto_telefono': '',
            'vendedor_nit': '',
            'vendedor_nombre': ''
        }
    });

}) (this, this.document);
