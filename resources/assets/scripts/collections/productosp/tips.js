/**
* Class TipsList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.TipsList = Backbone.Collection.extend({

        url: function () {
            return window.Misc.urlFull(Route.route('productosp.tips.index'));
        },
        model: app.Productop2Model
   });

})(this, this.document);
