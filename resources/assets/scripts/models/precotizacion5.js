/**
* Class PreCotizacion5Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.PreCotizacion5Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('precotizaciones.productos.impresiones.index') );
        },
        idAttribute: 'id',
        defaults: {
            'precotizacion5_texto': '',
            'precotizacion5_alto': '',
            'precotizacion5_ancho': '',
        }
    });

})(this, this.document);
