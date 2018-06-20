/**
* Class Cotizacion7Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.Cotizacion7Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('cotizaciones.productos.impresiones.index') );
        },
        idAttribute: 'id',
        defaults: {
            'cotizacion7_texto': '',
            'cotizacion7_alto': '',
            'cotizacion7_ancho': '',
        }
    });

})(this, this.document);
