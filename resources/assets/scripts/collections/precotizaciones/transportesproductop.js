/**
* Class TransportesProductopPreCotizacionList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.TransportesProductopPreCotizacionList = Backbone.Collection.extend({

        url: function () {
            return window.Misc.urlFull(Route.route('precotizaciones.productos.transportes.index'));
        },
        model: app.PreCotizacion10Model,

        totalTransporte: function () {
            _.each(this.models, function(model) {
                var total = parseFloat(model.get('precotizacion10_valor_unitario')) * model.get('precotizacion10_cantidad');
                model.set('precotizacion10_valor_total', total);
            });
        },

        total: function () {
            return this.reduce(function(sum, model) {
                return sum + parseFloat(model.get('precotizacion10_valor_unitario')) * model.get('precotizacion10_cantidad');
            }, 0);
        },

        totalize: function () {
            var total = this.total();
                this.totalTransporte();

            return {
                total: total
            }
        }
   });

})(this, this.document);
