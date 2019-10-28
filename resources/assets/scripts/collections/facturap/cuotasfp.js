/**
* Class CuotasFPList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.CuotasFPList = Backbone.Collection.extend({

        url: function () {
            return window.Misc.urlFull(Route.route('facturap.cuotas.index'));
        },
        model: app.Facturap2Model
   });

})(this, this.document);
