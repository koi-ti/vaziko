/**
* Class Ordenp9Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

app || (app = {});

(function (window, document, undefined){

    app.Ordenp9Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('ordenes.productos.empaques.index') );
        },
        idAttribute: 'id',
        defaults: {
            'empaque_nombre': '',
            'orden9_materialp': '',
            'orden9_medidas': '',
            'orden9_cantidad': 0,
            'orden9_valor_unitario': '',
            'orden9_valor_total': ''
        }
    });

}) (this, this.document);
