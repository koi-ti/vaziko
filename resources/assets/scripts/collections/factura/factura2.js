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

        validar: function( data ){
            var response = {success: false, error: ''}

            // Validate exist
            var modelExits = _.find(this.models, function( item ) {
                return item.get('id') == data.factura1_orden;
            });

            if(modelExits instanceof Backbone.Model ) {
                response.error = 'La orden No. '+ data.factura1_orden +' ya se encuentra registrada.';
                return response;
            }

            response.success = true;
            return response;
        },

        renderSubtotal: function(){
            _.each(this.models, function(item){
                var total = parseInt(item.get('factura2_cantidad')) * parseFloat(item.get('orden2_total_valor_unitario'));
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
