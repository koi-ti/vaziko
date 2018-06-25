/**
* Class Ordenp6Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

app || (app = {});

(function (window, document, undefined){

    app.Ordenp6Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('ordenes.productos.areas.index') );
        },
        idAttribute: 'id',
        defaults: {
            'orden6_areap': '',
        	'orden6_nombre': '',
            'orden6_horas': '',
            'orden6_minutos': '',
            'orden6_valor': 0,
        	'areap_nombre': '',
        	'total': 0,
        }
    });

}) (this, this.document);
