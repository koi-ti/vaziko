/**
* Class ProductoModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ProductoModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull(Route.route('productos.index'));
        },
        idAttribute: 'id',
        defaults: {
            'producto_nombre': '',
            'producto_codigo': '',
            'producto_codigoori': '',
            'producto_referencia': '',
            'producto_materialp': '',
            'producto_grupo': '',
            'producto_subgrupo': '',
            'producto_unidadmedida': '',
            'producto_precio': 0,
            'producto_costo': 0,
            'producto_vidautil': 0,
            'producto_unidades': true,
            'producto_serie': false,
            'producto_metrado': false,
            'producto_empaque': false,
            'producto_ancho': 0,
            'producto_largo': 0
        }
    });

})(this, this.document);
