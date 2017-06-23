/**
* Class DetalleFactura2List of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.DetalleFactura2List = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('facturas.facturado.index') );
        },
        model: app.Factura2Model,

        /**
        * Constructor Method
        */
        initialize : function(){
        },

        facturado: function() {
            return this.reduce(function(sum, model) {
                return sum + parseInt(model.get('factura2_cantidad'))
            }, 0);
        },

        // subtotal: function() {
        //     return this.reduce(function(sum, model) {
        //         return sum + parseFloat(model.get('orden2_precio_venta')) * parseInt(model.get('factura2_cantidad'))
        //     }, 0);
        // },

        renderSubtotal: function(){
            _.each(this.models, function(item){
                var total = parseInt(item.get('factura2_cantidad')) * parseFloat(item.get('orden2_precio_venta'));
                $('#subtotal_'+item.get('id') ).html( window.Misc.currency(total) );
            });
        },

        totalize: function() {
            var facturado = this.facturado();
            // var subtotal = this.subtotal();
            this.renderSubtotal();
            return { 'facturado': facturado }
        },
   });

})(this, this.document);
