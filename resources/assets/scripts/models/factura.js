/**
* Class FacturaModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.FacturaModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('facturas.index') );
        },
        idAttribute: 'id',
        defaults: {
            'factura1_fecha': moment().format('YYYY-MM-DD'),
            'factura1_fecha_vencimiento': moment().format('YYYY-MM-DD'),
            'tercero_nit': '',
            'tercero_nombre': '',
        }
    });

})(this, this.document);
