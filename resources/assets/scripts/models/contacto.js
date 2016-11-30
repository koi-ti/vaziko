/**
* Class ContactoModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ContactoModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('terceros.contactos.index') );
        },
        idAttribute: 'id',
        defaults: {
        	'tcontacto_nombres': '',
        	'tcontacto_apellidos': '',
        	'tcontacto_telefono': '',
        	'tcontacto_celular': '',
        	'tcontacto_municipio': '',
        	'tcontacto_direccion': '',
        	'tcontacto_email': '',
        	'tcontacto_cargo': ''
        }
    });

})(this, this.document);