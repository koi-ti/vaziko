/**
* Class MaterialesProductopCotizacionList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.MaterialesProductopCotizacionList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('cotizaciones.productos.materiales.index') );
        },
        model: app.Cotizacion4Model,

        /**
        * Constructor Method
        */
        initialize : function(){

        },

        totalRow: function( ){
            _.each( this.models, function( model ) {
                var total = parseFloat( model.get('cotizacion4_valor_unitario') ) * model.get('cotizacion4_cantidad');
                model.set('cotizacion4_valor_total', total);
            });
        },

        total: function() {
            return this.reduce(function(sum, model){
                return sum + parseFloat( model.get('cotizacion4_valor_unitario') ) * model.get('cotizacion4_cantidad');
            }, 0);
        },

        totalize: function () {
            var total = this.total();
            this.totalRow();
            return { total: total }
        },
   });

})(this, this.document);
