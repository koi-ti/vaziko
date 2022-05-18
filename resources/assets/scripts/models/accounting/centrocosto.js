/**
* Class CentroCostoModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.CentroCostoModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull(Route.route('centroscosto.index'));
        },
        idAttribute: 'id',
        defaults: {
            'centrocosto_codigo': '',
        	'centrocosto_centro': '',
            'centrocosto_nombre': '',
            'centrocosto_descripcion1': '',
            'centrocosto_descripcion2': '',
            'centrocosto_estructura': 'N',
            'centrocosto_tipo': 'N',
        	'centrocosto_activo': true
        }
    });

})(this, this.document);
