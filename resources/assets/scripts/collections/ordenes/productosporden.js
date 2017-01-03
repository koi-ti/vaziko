/**
* Class ProductopOrdenList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ProductopOrdenList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('ordenes.productos.index') );
        },
        model: app.Ordenp2Model,

        /**
        * Constructor Method
        */
        initialize : function(){

        },

        unidades: function() {
            return this.reduce(function(sum, model) {
                return sum + model.get('orden2_cantidad')
            }, 0);
        },

        subtotal: function() {
            return this.reduce(function(sum, model) {
                return sum + parseFloat(model.get('orden2_precio_total'))
            }, 0);
        },

        totalize: function() {
            var unidades = this.unidades();
            var subtotal = this.subtotal();
            var iva = subtotal * 0.16;
            var total = subtotal + iva;
            return { 'unidades': unidades, 'subtotal': subtotal, 'iva': iva, 'total': total}
        },
   });

})(this, this.document);
