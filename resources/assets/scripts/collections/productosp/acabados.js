/**
* Class AcabadosList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.AcabadosList = Backbone.Collection.extend({

        url: function () {
            return window.Misc.urlFull(Route.route('productosp.acabados.index'));
        },
        model: app.Productop6Model
   });

})(this, this.document);
