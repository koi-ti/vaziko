/**
* Class DespachospPendientesCotizacionList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.DespachospPendientesCotizacionList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('cotizaciones.despachos.pendientes') );
        },
        model: app.Cotizacion2Model,

        /**
        * Constructor Method
        */
        initialize : function(){

        }
   });

})(this, this.document);
