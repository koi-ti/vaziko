/**
* Class PreCotizacion3Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.PreCotizacion3Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull(Route.route('precotizaciones.productos.materiales.index'));
        },
        idAttribute: 'id',
        defaults: {
            'materialp_nombre': '',
            'precotizacion3_materialp': '',
            'precotizacion3_medidas': '',
            'precotizacion3_cantidad': '',
            'precotizacion3_valor_unitario': '',
            'precotizacion3_valor_total': ''
        }
    });

})(this, this.document);
