/**
* Class ProductopModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ProductopModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('productosp.index') );
        },
        idAttribute: 'id',
        defaults: {
            'productop_nombre': '',
            'productop_observaciones': '',
            'productop_tiro': false,
            'productop_retiro': false,
            'productop_abierto': false,
            'productop_cerrado': false,
            'productop_3d': false,
            'productop_ancho_med': '',
            'productop_alto_med': '',
            'productop_c_med_ancho': '',
            'productop_c_med_alto': '',
            'productop_3d_profundidad_med': '',
            'productop_3d_ancho_med': '',
            'productop_3d_alto_med': ''
        }
    });

})(this, this.document);
