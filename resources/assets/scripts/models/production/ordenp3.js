/**
* Class Ordenp3Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

app || (app = {});

(function (window, document, undefined){

    app.Ordenp3Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull(Route.route('ordenes.productos.maquinas.index'));
        },
        idAttribute: 'id',
        defaults: {}
    });

}) (this, this.document);
