/**
* Class EmpaquesProductopList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.EmpaquesProductopOrdenList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('ordenes.productos.empaques.index') );
        },
        model: app.Ordenp9Model,

        /**
        * Constructor Method
        */
        initialize : function(){

        },

        totalEmpaque: function( ){
            _.each( this.models, function( model ) {
                var total = parseFloat( model.get('orden9_valor_unitario') ) * window.Misc.validarMedida(model.get('orden9_medidas'));
                model.set('orden9_valor_total', total);
            });
        },

        total: function() {
            return this.reduce(function(sum, model){
                return sum + parseFloat( model.get('orden9_valor_unitario') ) * window.Misc.validarMedida(model.get('orden9_medidas'));
            }, 0);
        },

        totalize: function () {
            var total = this.total();
                this.totalEmpaque();
            return { total: total }
        },
   });

})(this, this.document);
