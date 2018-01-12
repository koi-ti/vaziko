/**
* Class ContabilidadOrdenpList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ContabilidadOrdenpList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('ordenes.contabilidad.index') );
        },
        model: app.TiempopModel,

        /**
        * Constructor Method
        */
        initialize : function(){

        }
   });

})(this, this.document);
