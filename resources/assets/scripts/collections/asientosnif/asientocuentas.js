/**
* Class AsientoNifCuentasList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.AsientoNifCuentasList = Backbone.Collection.extend({

        url: function () {
            return window.Misc.urlFull(Route.route('asientosnif.detalle.index'));
        },
        model: app.AsientoNif2Model,

        debitos: function () {
            return this.reduce(function(sum, model) {
                return sum + parseFloat(model.get('asienton2_debito'))
            }, 0);
        },

        creditos: function () {
            return this.reduce(function(sum, model) {
                return sum + parseFloat(model.get('asienton2_credito'))
            }, 0);
        },

        totalize: function () {
            var debitos = this.debitos();
            var creditos = this.creditos();
            return { 'debitos': debitos, 'creditos': creditos, 'diferencia': Math.abs(creditos - debitos)}
        }
   });

})(this, this.document);
