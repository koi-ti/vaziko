/**
* Class RolList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.RolList = Backbone.Collection.extend({

        url: function () {
            return window.Misc.urlFull(Route.route('terceros.roles.index'));
        },
        model: app.UsuarioRolModel
   });

})(this, this.document);
