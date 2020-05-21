/**
* Class AsientoMovimientosList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.AsientoMovimientosList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull(Route.route('asientos.detalle.movimientos.index'));
        },
        model: app.AsientoMovimientoModel,

        totalize: function (valor) {
            _.each(this.models, function (model) {
                if (model.get('type') == 'FP') {
                    var count = _.filter(model.get('father'), function (child) {
                        return child.movimiento_nuevo != 1;
                    });

                    var nuevo = (valor / count.length);
                    _.each(count, function (cuota) {
                        $('#movimiento_valor_' + cuota.movimiento_id).text(window.Misc.currency(nuevo));
                    });
                } else if (model.get('type') == 'F') {
                    var nuevo = (valor/model.get('childrens').length);
                    _.each(model.get('childrens'), function (children) {
                        $('#movimiento_valor_' + children.movimiento_id).text(window.Misc.currency(nuevo));
                    });
                }
            });
        }
   });

})(this, this.document);
