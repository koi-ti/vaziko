/**
* Class AreasList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.AreasList = Backbone.Collection.extend({

        url: function () {
            return window.Misc.urlFull(Route.route('productosp.areas.index'));
        },
        model: app.Productop3Model
   });

})(this, this.document);
