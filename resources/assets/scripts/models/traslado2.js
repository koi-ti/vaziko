/**
* Class Traslado2Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.Traslado2Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('traslados.detalle.index') );
        },
        idAttribute: 'id',
        defaults: {
        }
    });

})(this, this.document);
