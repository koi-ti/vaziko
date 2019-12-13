/**
* Class PreCotizacion9Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

app || (app = {});

(function (window, document, undefined){

    app.PreCotizacion9Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull(Route.route('precotizaciones.productos.empaques.index'));
        },
        idAttribute: 'id',
        defaults: {}
    });

}) (this, this.document);
