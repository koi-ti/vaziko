/**
* Class AcabadopModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.AcabadopModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('acabadosp.index') );
        },
        idAttribute: 'id',
        defaults: {
            'acabadop_nombre': '',
            'acabadop_descripcion': ''
        }
    });

})(this, this.document);
