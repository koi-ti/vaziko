/**
* Class PreCotizacion5Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

app || (app = {});

(function (window, document, undefined){

    app.PreCotizacion5Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull(Route.route('precotizaciones.productos.acabados.index'));
        },
        idAttribute: 'id',
        defaults: {}
    });

}) (this, this.document);
