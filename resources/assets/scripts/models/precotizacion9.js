/**
* Class PreCotizacion9Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.PreCotizacion9Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('precotizaciones.productos.empaques.index') );
        },
        idAttribute: 'id',
        defaults: {
            'materialp_nombre': '',
            'precotizacion9_materialp': '',
            'precotizacion9_medidas': '',
            'precotizacion9_valor_unitario': '',
            'precotizacion9_valor_total': ''
        }
    });

})(this, this.document);
