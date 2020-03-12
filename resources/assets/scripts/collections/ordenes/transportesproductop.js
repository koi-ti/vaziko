/**
* Class TransportesProductopList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.TransportesProductopOrdenList = Backbone.Collection.extend({

        url: function () {
            return window.Misc.urlFull(Route.route('ordenes.productos.transportes.index'));
        },
        model: app.Ordenp10Model,

        /**
        *   Evento para convertir minutos a horas
        */
        convertMinutesToHours: function (model) {
            var horas = parseInt(model.get('orden10_horas'));
            var minutos = parseInt(model.get('orden10_minutos'));

            // Regla de 3 para convertir min a horas
            var total = horas + (minutos / 60);
                total = _.isNaN(total) ? 0 : parseFloat(total);

            return total;
        },

        total: function () {
            var _this = this;

            return this.reduce(function (sum, model) {
                return sum + _this.convertMinutesToHours(model) * parseFloat(model.get('orden10_valor_unitario'));
            }, 0);
        },

        totalTransporte: function () {
            var _this = this;

            _.each(this.models, function (model) {
                total = _this.convertMinutesToHours(model) * parseFloat(model.get('orden10_valor_unitario'));
                model.set('orden10_valor_total', Math.round(total));
            });
        },

        totalize: function () {
            var total = this.total();
                this.totalTransporte();

            return {
                total: Math.round(total)
            }
        }
   });

})(this, this.document);
