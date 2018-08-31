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
            'precotizacion2_referencia': '',
            'precotizacion2_ancho': 0,
            'precotizacion2_alto': 0,
            'precotizacion2_c_ancho': 0,
            'precotizacion2_c_alto': 0,
            'precotizacion2_3d_ancho': 0,
            'precotizacion2_3d_alto': 0,
            'precotizacion2_3d_profundidad': 0,
            'precotizacion2_tiro': 1,
            'precotizacion2_yellow': false,
            'precotizacion2_magenta': false,
            'precotizacion2_cyan': false,
            'precotizacion2_key': false,
            'precotizacion2_color1': false,
            'precotizacion2_color2': false,
            'precotizacion2_nota_tiro': '',
            'precotizacion2_retiro': 1,
            'precotizacion2_yellow2': false,
            'precotizacion2_magenta2': false,
            'precotizacion2_cyan2': false,
            'precotizacion2_key2': false,
            'precotizacion2_color12': false,
            'precotizacion2_color22': false,
            'precotizacion2_nota_retiro': '',
            'precotizacion2_observaciones': ''
        }
    });

})(this, this.document);
