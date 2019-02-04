/**
* Class EmpaquesProductopPreCotizacionList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.EmpaquesProductopPreCotizacionList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('precotizaciones.productos.empaques.index') );
        },
        model: app.PreCotizacion9Model,

        /**
        * Constructor Method
        */
        initialize : function(){

        },

        totalRow: function( ){
            _.each( this.models, function( model ) {
                var total = parseFloat( model.get('precotizacion9_valor_unitario') ) * model.get('precotizacion9_cantidad');
                model.set('precotizacion9_valor_total', total);
            });
        },

        total: function() {
            return this.reduce(function(sum, model){
                return sum + parseFloat( model.get('precotizacion9_valor_unitario') ) * model.get('precotizacion9_cantidad');
            }, 0);
        },

        totalize: function () {
            var total = this.total();
            this.totalRow();
            return { total: total }
        },
   });

})(this, this.document);
