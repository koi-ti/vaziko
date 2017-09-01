/**
* Class Cotizacion6Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

app || (app = {});

(function (window, document, undefined){

    app.Cotizacion6Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('cotizaciones.productos.areas.index') );
        },
        idAttribute: 'id',
        defaults: {
            'cotizacion6_areap': '',
        	'cotizacion6_nombre': '',
            'cotizacion6_horas': 0,
            'cotizacion6_valor': 0,
        	'areap_nombre': '',
        	'total': 0,
        }
    });

}) (this, this.document);
