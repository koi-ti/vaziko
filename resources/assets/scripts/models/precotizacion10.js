/**
* Class PreCotizacion10Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.PreCotizacion10Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('precotizaciones.productos.transportes.index') );
        },
        idAttribute: 'id',
        defaults: {
            'transporte_nombre': '',
            'precotizacion10_materialp': '',
            'precotizacion10_medidas': '',
            'precotizacion10_cantidad': '',
            'precotizacion10_valor_unitario': '',
            'precotizacion10_valor_total': ''
        }
    });

})(this, this.document);
