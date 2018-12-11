/**
* Class Cotizacion2Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.Cotizacion2Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('cotizaciones.productos.index') );
        },
        idAttribute: 'id',
        defaults: {
            'cotizacion2_referencia': '',
            'cotizacion2_cantidad': 1,
            'cotizacion2_precio_formula': '',
            'cotizacion2_transporte_formula': '',
            'cotizacion2_viaticos_formula': '',
            'cotizacion2_precio_venta': 0,
            'cotizacion2_transporte': 0,
            'cotizacion2_viaticos': 0,
            'cotizacion2_volumen': 0,
            'cotizacion2_round': 0,
            'cotizacion2_round_materialp': 0,
            'cotizacion2_margen_materialp': 0,
            'cotizacion2_vtotal': 0,
            'cotizacion2_observaciones': '',
            'cotizacion2_ancho': 0,
            'cotizacion2_alto': 0,
            'cotizacion2_c_ancho': 0,
            'cotizacion2_c_alto': 0,
            'cotizacion2_3d_ancho': 0,
            'cotizacion2_3d_alto': 0,
            'cotizacion2_3d_profundidad': 0,
            'cotizacion2_tiro': 1,
            'cotizacion2_yellow': false,
            'cotizacion2_magenta': false,
            'cotizacion2_cyan': false,
            'cotizacion2_key': false,
            'cotizacion2_color1': false,
            'cotizacion2_color2': false,
            'cotizacion2_nota_tiro': '',
            'cotizacion2_retiro': 1,
            'cotizacion2_yellow2': false,
            'cotizacion2_magenta2': false,
            'cotizacion2_cyan2': false,
            'cotizacion2_key2': false,
            'cotizacion2_color12': false,
            'cotizacion2_color22': false,
            'cotizacion2_nota_retiro': '',
        }
    });

})(this, this.document);
