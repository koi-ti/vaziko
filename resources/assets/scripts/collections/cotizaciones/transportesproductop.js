/**
* Class TransportesProductopCotizacionList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.TransportesProductopCotizacionList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('cotizaciones.productos.transportes.index') );
        },
        model: app.Cotizacion10Model,

        /**
        * Constructor Method
        */
        initialize: function () {
            //
        },

        totalTransporte: function () {
            _.each(this.models, function (model) {
                var total = parseFloat(model.get('cotizacion10_valor_unitario')) * model.get('cotizacion10_cantidad');
                model.set('cotizacion10_valor_total', total);
            });
        },

        total: function () {
            return this.reduce(function(sum, model) {
                return sum + parseFloat(model.get('cotizacion10_valor_unitario')) * model.get('cotizacion10_cantidad');
            }, 0);
        },

        totalize: function () {
            var total = this.total();
                this.totalTransporte();
            return { total: total }
        },
   });

})(this, this.document);
