/**
* Class Ordenp10Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

app || (app = {});

(function (window, document, undefined){

    app.Ordenp10Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('ordenes.productos.transportes.index') );
        },
        idAttribute: 'id',
        defaults: {
            'transporte_nombre': '',
            'orden10_materialp': '',
            'orden10_medidas': '',
            'orden10_cantidad': 0,
            'orden10_valor_unitario': '',
            'orden10_valor_total': ''
        }
    });

}) (this, this.document);
