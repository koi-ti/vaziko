/**
* Class Ordenp2Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

app || (app = {});

(function (window, document, undefined){

    app.Ordenp2Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('ordenes.productos.index') );
        },
        idAttribute: 'id',
        defaults: {
            'orden2_referencia': '',
            'orden2_cantidad': 0,
            'orden2_precio_formula': '',
            'orden2_transporte_formula': '',
            'orden2_viaticos_formula': '',
            'orden2_precio_round': '',
            'orden2_transporte_round': '',
            'orden2_viaticos_round': '',
            'orden2_transporte': 0,
            'orden2_viaticos': '',
            'orden2_precio_venta': '',
            'orden2_observaciones': '',
            'orden2_ancho': 0,
            'orden2_alto': 0,
            'orden2_c_ancho': 0,
            'orden2_c_alto': 0,
            'orden2_3d_ancho': 0,
            'orden2_3d_alto': 0,
            'orden2_3d_profundidad': 0,
            'orden2_tiro': false,
            'orden2_yellow': false,
            'orden2_magenta': false,
            'orden2_cyan': false,
            'orden2_key': false,
            'orden2_color1': false,
            'orden2_color2': false,
            'orden2_nota_tiro': '',
            'orden2_retiro': false,
            'orden2_yellow2': false,
            'orden2_magenta2': false,
            'orden2_cyan2': false,
            'orden2_key2': false,
            'orden2_color12': false,
            'orden2_color22': false,
            'orden2_nota_retiro': '',
        }
    });

}) (this, this.document);
