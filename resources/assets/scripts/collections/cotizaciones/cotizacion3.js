/**
* Class DetalleCotizacion3List of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.DetalleCotizacion3List = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('cotizaciones.detallearea.index') );
        },
        model: app.Cotizacion3Model,

        /**
        * Constructor Method
        */
        initialize : function(){
        },

        total: function() {
            return this.reduce(function(sum, model) {
                return sum + parseInt(model.get('cotizacion3_horas')) * parseFloat(model.get('cotizacion3_valor'));
            }, 0);
        },

        totalRow: function( ){
            _.each(this.models, function(item){
                var total = parseInt(item.get('cotizacion3_horas')) * parseFloat(item.get('cotizacion3_valor'));
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
