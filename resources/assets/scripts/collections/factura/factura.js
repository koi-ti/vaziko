/**
* Class FacturaList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.FacturaList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('asientos.facturas.pendientes') );
        },
        model: app.FacturaModel,

        /**
        * Constructor Method
        */
        initialize : function(){
        }
   });

})(this, this.document);
