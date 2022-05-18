/**
* Class TrasladoModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.TrasladoModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull(Route.route('traslados.index'));
        },
        idAttribute: 'id',
        defaults: {
        	'traslado1_sucursal': '',
        	'traslado1_numero': '',
        	'traslado1_destino': '',
        	'traslado1_fecha': moment().format('YYYY-MM-DD'),
        	'traslado1_observaciones': ''
		}
    });

})(this, this.document);
