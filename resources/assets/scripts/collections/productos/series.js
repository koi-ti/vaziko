/**
* Class ProductoSeriesINList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ProductoSeriesINList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('productos.index') );
        },
        model: app.ProductoModel,

        /**
        * Constructor Method
        */
        initialize : function(){
        }
   });

})(this, this.document);
