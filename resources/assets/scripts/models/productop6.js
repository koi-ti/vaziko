/**
* Class Productop6Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.Productop6Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('productosp.acabados.index') );
        },
        idAttribute: 'id',
        defaults: {
        	'productop6_productop': '',
            'productop6_acabadop': ''
        }
    });

})(this, this.document);
