/**
* Class ContactsList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ContactsList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('terceros.contactos.index') );
        },
        model: app.ContactoModel,

        /**
        * Constructor Method
        */
        initialize : function(){
        }
   });

})(this, this.document);
