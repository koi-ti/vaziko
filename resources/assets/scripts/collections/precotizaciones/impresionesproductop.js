/**
* Class ImpresionesProductopPreCotizacionList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ImpresionesProductopPreCotizacionList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('precotizaciones.productos.impresiones.index') );
        },
        model: app.PreCotizacion5Model,

        /**
        * Constructor Method
        */
        initialize : function(){

        },
   });

})(this, this.document);
