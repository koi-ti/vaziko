/**
* Class Cotizacion9Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

app || (app = {});

(function (window, document, undefined){

    app.Cotizacion9Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull(Route.route('cotizaciones.productos.empaques.index'));
        },
        idAttribute: 'id',
        defaults: {
            'empaque_nombre': '',
            'cotizacion9_materialp': '',
            'cotizacion9_medidas': '',
            'cotizacion9_cantidad': 0,
            'cotizacion9_valor_unitario': '',
            'cotizacion9_valor_total': ''
        }
    });

}) (this, this.document);
