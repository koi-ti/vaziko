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
            'cotizacion10_nombre': '',
            'cotizacion10_tiempo': '',
            'cotizacion10_horas': '',
            'cotizacion10_minutos': '',
            'cotizacion10_valor_unitario': '',
            'cotizacion10_valor_total': '',
            'transporte_nombre': ''
        }
    });

}) (this, this.document);
