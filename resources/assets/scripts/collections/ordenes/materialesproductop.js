/**
* Class MaterialesProductopList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.MaterialesProductopOrdenList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('ordenes.productos.materiales.index') );
        },
        model: app.Ordenp4Model,

        /**
        * Constructor Method
        */
        initialize : function(){

        },

        totalMaterialp: function( ){
            _.each( this.models, function( model ) {
                var total = parseFloat( model.get('orden4_valor_unitario') ) * model.get('orden4_cantidad');
                model.set('orden4_valor_total', total);
            });
        },

        total: function() {
            return this.reduce(function(sum, model){
                return sum + parseFloat( model.get('orden4_valor_unitario') ) * model.get('orden4_cantidad');
            }, 0);
        },

        totalize: function () {
            var total = this.total();
                this.totalMaterialp();
            return { total: total }
        },
   });

})(this, this.document);
