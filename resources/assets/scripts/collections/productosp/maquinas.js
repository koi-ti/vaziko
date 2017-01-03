/**
* Class MaquinasList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.MaquinasList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('productosp.maquinas.index') );
        },
        model: app.Productop4Model,

        /**
        * Constructor Method
        */
        initialize : function(){
        }
   });

})(this, this.document);
