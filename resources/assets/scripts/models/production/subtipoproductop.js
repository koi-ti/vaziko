/**
* Class SubtipoProductopModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.SubtipoProductopModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull(Route.route('subtipoproductosp.index'));
        },
        idAttribute: 'id',
        defaults: {
            'subtipoproductop_nombre': '',
            'subtipoproductop_tipoproductop': '',
            'subtipoproductop_activo': 1
        }
    });

})(this, this.document);
