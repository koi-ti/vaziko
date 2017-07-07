/**
* Class DetalleCotizacion2List of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.DetalleCotizacion2List = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('cotizaciones.detalle.index') );
        },
        model: app.Cotizacion2Model,

        /**
        * Constructor Method
        */
        initialize : function(){
        },

        comparator: function( model ){
            return model.get('cotizacion2_productoc');
        },

        total: function() {
            return this.reduce(function(sum, model) {
                return sum + parseInt(model.get('cotizacion2_cantidad')) * parseFloat(model.get('cotizacion2_valor'));
            }, 0);
        },

        totalRow: function( ){
            _.each(this.models, function(item){
                var total = parseInt(item.get('cotizacion2_cantidad')) * parseFloat(item.get('cotizacion2_valor'));
                item.set('total', total);
            });
        },

        totalize: function() {
            var total = this.total();
            this.totalRow();
            return { 'total': total }
        },
   });

})(this, this.document);
