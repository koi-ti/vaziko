/**
* Class AreasProductopPreCotizacionList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.AreasProductopPreCotizacionList = Backbone.Collection.extend({

        url: function () {
            return window.Misc.urlFull(Route.route('precotizaciones.productos.areas.index'));
        },
        model: app.PreCotizacion6Model,

        /**
        *   Evento para convertir minutos a horas
        */
        convertMinutesToHours: function (model) {
            var horas = parseInt(model.get('precotizacion6_horas'));
            var minutos = parseInt(model.get('precotizacion6_minutos'));

            // Regla de 3 para convertir min a horas
            var total = horas + (minutos / 60);
                total = _.isNaN(total) ? 0 : parseFloat(total);

            return total;
        },

        validar: function (data) {
            var error = {
                success: false,
                message: ''
            };

            // Validate exist
            if (!_.isNull(data.precotizacion6_areap) && !_.isUndefined(data.precotizacion6_areap) && data.precotizacion6_areap != '') {
                var modelExits = _.find(this.models, function(item) {
                    return item.get('precotizacion6_areap') == data.precotizacion6_areap;
                });
            } else {
                var modelExits = _.find(this.models, function(item) {
                    return item.get('precotizacion6_nombre') == data.precotizacion6_nombre;
                });
            }

            if (modelExits instanceof Backbone.Model) {
                error.message = 'El area que intenta ingresar ya existe.'
                return error;
            }

            error.success = true;
            return error;
        },

        total: function () {
            var _this = this;

            return this.reduce(function(sum, model) {
                var func = _this.convertMinutesToHours(model);
                return sum + func * parseFloat(model.get('precotizacion6_valor'));
            }, 0);
        },

        totalAreap: function () {
            var _this = this;

            _.each(this.models, function(model) {
                var func = _this.convertMinutesToHours(model),
                    total = func * parseFloat(model.get('precotizacion6_valor'));
                model.set('total', Math.round(total));
            });
        },

        totalize: function () {
            var total = this.total();
                this.totalAreap();

            return {
                'total': Math.round(total)
            }
        }
   });

})(this, this.document);
