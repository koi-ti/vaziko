/**
* Class ProductopCotizacionList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ProductopCotizacionList = Backbone.Collection.extend({

        url: function () {
            return window.Misc.urlFull(Route.route('cotizaciones.productos.index'));
        },
        model: app.Cotizacion2Model,

        unidades: function () {
            return this.reduce(function(sum, model) {
                return sum + parseInt(model.get('cotizacion2_cantidad'))
            }, 0);
        },

        facturado: function () {
            return this.reduce(function(sum, model) {
                return sum + parseInt(model.get('cotizacion2_facturado'))
            }, 0);
        },

        subtotal: function () {
            return this.reduce(function(sum, model) {
                return sum + parseFloat(model.get('cotizacion2_precio_total'))
            }, 0);
        },

        totalize: function () {
            var unidades = this.unidades();
            var facturado = this.facturado();
            var subtotal = this.subtotal();

            return {
                'unidades': unidades,
                'facturado': facturado,
                'subtotal': subtotal
            }
        }
   });

})(this, this.document);
