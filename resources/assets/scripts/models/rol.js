/**
* Class RolModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.RolModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('rol.index') );
        },
        idAttribute: 'id',
        defaults: {
            'name': '',
            'display_name': '',
            'description': ''
        }
    });

})(this, this.document);
