/**
* Class Facturap2Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.Facturap2Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull(Route.route('facturasp.cuotas.index'));
        },
        idAttribute: 'id',
        defaults: {
        	'facturap2_factura': '',
        	'facturap2_cuota': '',
        	'facturap2_vencimiento': '',
        	'facturap2_valor': 0,
        	'facturap2_saldo': 0
        }
    });

})(this, this.document);
