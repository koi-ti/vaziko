/**
* Class Factura3Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.Factura3Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('asientos.facturas.detalle.index') );
        },
        idAttribute: 'id',
        defaults: {
        	'factura3_factura2': '',
        	'factura3_observaciones': ''
        }
    });

})(this, this.document);
