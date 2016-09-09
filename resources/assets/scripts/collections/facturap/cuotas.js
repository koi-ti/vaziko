/**
* Class CuotasList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.CuotasList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('facturap.cuotas.index') );
        },
        model: app.Facturap2Model,

        /**
        * Constructor Method
        */
        initialize : function(){
        }
   });

})(this, this.document);
