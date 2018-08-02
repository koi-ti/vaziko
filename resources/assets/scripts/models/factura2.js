/**
* Class Factura2Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.Factura2Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('facturas.facturado.index') );
        },
        idAttribute: 'id',
        defaults: {
            'factura2_cantidad': 0,
            'factura2_subtotal': 0,
        }
    });

})(this, this.document);
