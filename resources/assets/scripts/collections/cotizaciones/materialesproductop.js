/**
* Class MaterialesProductopCotizacionList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.MaterialesProductopCotizacionList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('cotizaciones.productos.materiales.index') );
        },
        model: app.Cotizacion4Model,

        /**
        * Constructor Method
        */
        initialize : function(){

        }
   });

})(this, this.document);
