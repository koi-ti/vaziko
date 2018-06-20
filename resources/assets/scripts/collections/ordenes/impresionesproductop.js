/**
* Class ImpresionesProductopOrdenpList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ImpresionesProductopOrdenpList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('ordenes.productos.impresiones.index') );
        },
        model: app.Ordenp7Model,

        /**
        * Constructor Method
        */
        initialize : function(){

        },
   });

})(this, this.document);
