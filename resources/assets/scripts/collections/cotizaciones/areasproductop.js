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

        validar: function( data ) {
            var error = { success: false, message: '' };

            // Validate exist
            if( !_.isNull(data.cotizacion6_areap) && !_.isUndefined(data.cotizacion6_areap) && data.cotizacion6_areap != ''){
                var modelExits = _.find(this.models, function(item) {
                    return item.get('cotizacion6_areap') == data.cotizacion6_areap;
                });
            }else{
                var modelExits = _.find(this.models, function(item) {
                    return item.get('cotizacion6_nombre') == data.cotizacion6_nombre;
                });
            }

            if(modelExits instanceof Backbone.Model ) {
                error.message = 'El area que intenta ingresar ya existe.'
                return error;
            }

            error.success = true;
            return error;
        },

        total: function() {
            return this.reduce(function(sum, model) {
                return sum + parseInt(model.get('cotizacion6_horas')) * parseFloat(model.get('cotizacion6_valor'));
            }, 0);
        },

        totalRow: function( ){
            _.each(this.models, function(item){
                var total = parseInt(item.get('cotizacion6_horas')) * parseFloat(item.get('cotizacion6_valor'));
                item.set('total', total);
            });
        },

        totalcotizacion: function( cotizacion2, carrito ){
            var total = 0;
            return total = parseFloat(cotizacion2) + parseFloat(carrito);
        },

        totalize: function(  ) {
            var total = this.total();
            this.totalRow();
            return { 'total': total }
        },
   });

})(this, this.document);
