/**
* Class FacturapModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.FacturapModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('facturap.index') );
        },
        idAttribute: 'id',
        defaults: {
        }
    });

})(this, this.document);
