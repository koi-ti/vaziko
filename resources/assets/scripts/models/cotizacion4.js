/**
* Class Cotizacion4Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

app || (app = {});

(function (window, document, undefined){

    app.Cotizacion4Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('cotizaciones.productos.materiales.index') );
        },
        idAttribute: 'id',
        defaults: {
            'materialp_nombre': '',
            'cotizacion4_materialp': '',
            'cotizacion4_medidas': '',
            'cotizacion4_valor_unitario': '',
            'cotizacion4_valor_total': ''
        }
    });

}) (this, this.document);
