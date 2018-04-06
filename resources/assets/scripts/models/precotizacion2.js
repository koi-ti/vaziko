/**
* Class PreCotizacion2Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.PreCotizacion2Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('precotizaciones.productos.index') );
        },
        idAttribute: 'id',
        defaults: {
            'precotizacion2_cantidad': 1,
        }
    });

})(this, this.document);
