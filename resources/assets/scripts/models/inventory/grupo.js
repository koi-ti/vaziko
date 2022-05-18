/**
* Class GrupoModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.GrupoModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull(Route.route('grupos.index'));
        },
        idAttribute: 'id',
        defaults: {
        	'grupo_nombre': ''
        }
    });

})(this, this.document);
