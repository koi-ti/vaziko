/**
* Class MaquinasProductopCotizacionList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.MaquinasProductopCotizacionList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('cotizaciones.productos.maquinas.index') );
        },
        model: app.Cotizacion3Model,

        /**
        * Constructor Method
        */
        initialize : function(){

        }
   });

})(this, this.document);
