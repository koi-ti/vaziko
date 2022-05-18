/**
* Class BitacoraModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.BitacoraModel = Backbone.Model.extend({
        idAttribute: 'id',
        defaults: {}
    });

})(this, this.document);
