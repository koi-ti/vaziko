/**
* Class Ordenp7Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.Ordenp7Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('ordenes.productos.impresiones.index') );
        },
        idAttribute: 'id',
        defaults: {
            'orden7_texto': '',
            'orden7_alto': '',
            'orden7_ancho': '',
        }
    });

})(this, this.document);
