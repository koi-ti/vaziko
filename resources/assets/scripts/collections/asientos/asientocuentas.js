/**
* Class AsientoCuentasList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.AsientoCuentasList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('asientos.detalle.index') );
        },
        model: app.Asiento2Model,

        /**
        * Constructor Method
        */
        initialize : function(){
        }
   });

})(this, this.document);
