/**
* Class Ordenp10Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

app || (app = {});

(function (window, document, undefined){

    app.Ordenp10Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull(Route.route('ordenes.productos.transportes.index'));
        },
        idAttribute: 'id',
        defaults: {
            'orden10_nombre': '',
            'orden10_tiempo': '',
            'orden10_horas': '',
            'orden10_minutos': '',
            'orden10_valor_unitario': '',
            'orden10_valor_total': '',
            'transporte_nombre': ''
        }
    });

}) (this, this.document);
