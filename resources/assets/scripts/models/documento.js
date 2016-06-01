/**
* Class DocumentoModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.DocumentoModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('documentos.index') );
        },
        idAttribute: 'id',
        defaults: {
        }
    });

})(this, this.document);
