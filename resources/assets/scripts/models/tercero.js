/**
* Class TerceroModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.TerceroModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('terceros.index') );
        },
        idAttribute: 'id',
        defaults: {
        	
        }
    });

})(this, this.document);
