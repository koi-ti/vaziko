/**
* Class Cotizacion10Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

app || (app = {});

(function (window, document, undefined){

    app.Cotizacion10Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull(Route.route('cotizaciones.productos.transportes.index'));
        },
        idAttribute: 'id',
        defaults: {
            'transporte_nombre': '',
            'cotizacion10_materialp': '',
            'cotizacion10_medidas': '',
            'cotizacion10_cantidad': 0,
            'cotizacion10_valor_unitario': '',
            'cotizacion10_valor_total': ''
        }
    });

}) (this, this.document);
