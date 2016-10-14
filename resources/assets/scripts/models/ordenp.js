/**
* Class OrdenpModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

app || (app = {});

(function (window, document, undefined){

    app.OrdenpModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull (Route.route('ordenes.index') );
        },
        idAttribute: 'id',
        defaults: {
            'orden_codigo': '',
            'orden_referencia': ''
        }
    });

}) (this, this.document);