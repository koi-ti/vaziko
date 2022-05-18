/**
* Class MaterialpModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.MaterialpModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull(Route.route('materialesp.index'));
        },
        idAttribute: 'id',
        defaults: {
            'materialp_nombre': '',
            'materialp_descripcion': '',
            'materialp_tipomaterial': '',
            'materialp_empaque': 0
        }
    });

})(this, this.document);
