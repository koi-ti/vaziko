/**
* Class ItemRolloModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ItemRolloModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull(Route.route('productos.rollos.index'));
        },
        idAttribute: 'id',
        defaults: {
        	'prodboderollo_item': 0,
        	'prodboderollo_centimetro': 0,
        	'prodboderollo_saldo': 0
        }
    });

})(this, this.document);
