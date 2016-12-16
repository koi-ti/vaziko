/**
* Class MaquinapModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.MaquinapModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('maquinasp.index') );
        },
        idAttribute: 'id',
        defaults: {
            'maquinap_nombre': ''
        }
    });

})(this, this.document);
