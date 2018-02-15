/**
* Class TiempopList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.TiempopList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('tiemposp.detalle.index') );
        },
        model: app.DetalleTiempopModel,

        /**
        * Constructor Method
        */
        initialize : function(){
        }
   });

})(this, this.document);
