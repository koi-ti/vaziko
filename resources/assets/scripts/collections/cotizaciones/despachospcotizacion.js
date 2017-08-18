/**
* Class DespachopCotizacionList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.DespachopCotizacionList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('cotizaciones.despachos.index') );
        },
        model: app.DespachoCotizacionModel,

        /**
        * Constructor Method
        */
        initialize : function(){

        }
   });

})(this, this.document);
