/**
* Class TiempoOrdenpModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.TiempoOrdenpModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('tiempoordenesp.index') );
        },
        idAttribute: 'id',
        defaults: {
            'tiempoordenp_fecha': moment().format('Y-m-d'),
            'tiempoordenp_hora_inicio': moment().format('H:m'),
            'tiempoordenp_hora_fin': moment().format('H:m'),
        }
    });

})(this, this.document);
