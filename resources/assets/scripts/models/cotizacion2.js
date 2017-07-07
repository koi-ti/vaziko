/**
* Class Cotizacion2Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.Cotizacion2Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('cotizaciones.detalle.index') );
        },
        idAttribute: 'id',
        defaults: {
        	'cotizacion2_productoc': '',
        	'cotizacion2_medida': '',
        	'cotizacion2_cantidad': '',
            'cotizacion2_materialp': '',
            'total': 0,
        	'materialp_nombre': '',
        	'cotizacion2_valor': 0,
        }
    });

})(this, this.document);
