/**
* Class AreasProductopCotizacionList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.AreasProductopCotizacionList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('cotizaciones.productos.areas.index') );
        },
        model: app.Cotizacion6Model,

        /**
        * Constructor Method
        */
        initialize : function(){

        },

        total: function() {
            return this.reduce(function(sum, model) {
                if( _.isNull(model.get('cotizacion6_horas')) || _.isNull(model.get('cotizacion6_valor'))){
                    horas = 0;
                    valor = 0;
                }else{
                    horas = model.get('cotizacion6_horas');
                    valor = model.get('cotizacion6_valor');
                }
                return sum + parseInt(horas) * parseFloat(valor);
            }, 0);
        },

        totalize: function() {
            var total = this.total();
            return { 'total': total }
        },
   });

})(this, this.document);
