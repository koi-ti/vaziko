/**
* Class MaterialesList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.MaterialesList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('productosp.materiales.index') );
        },
        model: app.Productop5Model,

        /**
        * Constructor Method
        */
        initialize : function(){
        }
   });

})(this, this.document);
