/**
* Class DocumentoModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.DocumentoModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull(Route.route('documentos.index'));
        },
        idAttribute: 'id',
        defaults: {
        	'documento_codigo': '',
        	'documento_nombre': '',
        	'documento_folder': '',
            'documento_tipo_consecutivo': 'A',
            'documento_nif':'',
            'documento_actual': 1,
        }
    });

})(this, this.document);
