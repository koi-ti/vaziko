/**
* Class PreCotizacion6Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

app || (app = {});

(function (window, document, undefined){

    app.PreCotizacion6Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('precotizaciones.productos.areas.index') );
        },
        idAttribute: 'id',
        defaults: {
            'precotizacion6_areap': '',
        	'precotizacion6_nombre': '',
            'precotizacion6_horas': '',
            'precotizacion6_minutos': '',
            'precotizacion6_valor': 0,
        	'areap_nombre': '',
        	'total': 0,
        }
    });

}) (this, this.document);
