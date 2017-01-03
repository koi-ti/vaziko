/**
* Class Productop4Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.Productop4Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('productosp.maquinas.index') );
        },
        idAttribute: 'id',
        defaults: {
        	'productop4_productop': '',
            'productop4_maquinap': ''
        }
    });

})(this, this.document);
