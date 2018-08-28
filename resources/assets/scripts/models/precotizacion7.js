/**
* Class PreCotizacion7Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

app || (app = {});

(function (window, document, undefined){

    app.PreCotizacion7Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('precotizaciones.productos.acabados.index') );
        },
        idAttribute: 'id',
        defaults: {

        }
    });

}) (this, this.document);
