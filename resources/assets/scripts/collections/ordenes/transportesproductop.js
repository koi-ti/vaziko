/**
* Class TransportesProductopList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.TransportesProductopOrdenList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('ordenes.productos.transportes.index') );
        },
        model: app.Ordenp10Model,

        /**
        * Constructor Method
        */
        initialize: function () {
            //
        },

        totalTransporte: function () {
            _.each(this.models, function (model) {
                var total = parseFloat(model.get('orden10_valor_unitario')) * model.get('orden10_cantidad');
                model.set('orden10_valor_total', total);
            });
        },

        total: function () {
            return this.reduce(function(sum, model) {
                return sum + parseFloat(model.get('orden10_valor_unitario')) * model.get('orden10_cantidad');
            }, 0);
        },

        totalize: function () {
            var total = this.total();
                this.totalTransporte();
            return { total: total }
        },
   });

})(this, this.document);
