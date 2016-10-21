/**
* Class TrasladoProductosList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.TrasladoProductosList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('traslados.detalle.index') );
        },
        model: app.Traslado2Model,

        /**
        * Constructor Method
        */
        initialize : function() {

        }
   });

})(this, this.document);
