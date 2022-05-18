/**
* Class UnidadModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.UnidadModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull(Route.route('unidades.index'));
        },
        idAttribute: 'id',
        defaults: {
        	'unidadmedida_sigla': '',
        	'unidadmedida_nombre': ''
        }
    });

})(this, this.document);
