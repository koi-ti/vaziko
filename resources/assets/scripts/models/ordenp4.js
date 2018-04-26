/**
* Class Ordenp4Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

app || (app = {});

(function (window, document, undefined){

    app.Ordenp4Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('ordenes.productos.materiales.index') );
        },
        idAttribute: 'id',
        defaults: {
            'orden4_id': '',
        }
    });

}) (this, this.document);
