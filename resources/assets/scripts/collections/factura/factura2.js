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
            $('#iva-create').attr('readonly', false);
            $('#rtefuente-create').attr('readonly', false);
            $('#rteica-create').attr('readonly', false);
            $('#rteiva-create').attr('readonly', false);

            response.success = true;
            return response;
        },

        subtotal: function(){
            return this.reduce(function(sum, model) {
                return sum + (parseInt(model.get('factura2_cantidad')) * parseFloat(model.get('factura2_producto_valor_unitario')))
            }, 0);
        },

        renderSubtotal: function(){
            _.each(this.models, function(item){
                var total = parseInt(item.get('factura2_cantidad')) * parseFloat(item.get('factura2_producto_valor_unitario'));
                $('#subtotal_'+item.get('id') ).html( window.Misc.currency(total) );
            });
        },

        totalize: function() {
            var facturado = this.facturado();
            var subtotal = this.subtotal();

            this.renderSubtotal();
            return { 'facturado': facturado, 'subtotal': subtotal }
        },
   });

})(this, this.document);
