/**
* Class PreCotizacion10Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

app || (app = {});

(function (window, document, undefined){

    app.PreCotizacion10Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull(Route.route('precotizaciones.productos.transportes.index'));
        },
        idAttribute: 'id',
        defaults: {}
    });

}) (this, this.document);
