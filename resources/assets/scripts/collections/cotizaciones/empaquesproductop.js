/**
* Class EmpaquesProductopCotizacionList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.EmpaquesProductopCotizacionList = Backbone.Collection.extend({

        url: function () {
            return window.Misc.urlFull(Route.route('cotizaciones.productos.empaques.index'));
        },
        model: app.Cotizacion9Model,

        validar: function (data) {
            var error = {
                success: false,
                message: ''
            };

            var current_value = parseFloat(data.cotizacion9_valor_unitario),
                previous_value = parseFloat(data.previo);

            if (current_value != previous_value) {
                var porcent_min = previous_value - (previous_value * 0.05),
                    porcent_max = previous_value + (previous_value * 0.05);

                if (current_value < porcent_min || current_value > porcent_max) {
                    error.message = 'El valor ingresado excede el límite permitido.';
                    return error;
                }
            }

            error.success = true;
            return error;
        },

        totalEmpaque: function () {
            _.each(this.models, function(model) {
                var total = parseFloat(model.get('cotizacion9_valor_unitario')) * model.get('cotizacion9_cantidad');
                model.set('cotizacion9_valor_total', total);
            });
        },

        total: function () {
            return this.reduce(function (sum, model) {
                return sum + parseFloat(model.get('cotizacion9_valor_unitario')) * model.get('cotizacion9_cantidad');
            }, 0);
        },

        totalize: function () {
            var total = this.total();
                this.totalEmpaque();

            return {
                total: total
            }
        }
   });

})(this, this.document);
