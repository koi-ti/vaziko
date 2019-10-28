/**
* Class AreapModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.AreapModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull(Route.route('areasp.index'));
        },
        idAttribute: 'id',
        defaults: {
            'areap_nombre': '',
            'areap_valor': 0
        }
    });

})(this, this.document);
