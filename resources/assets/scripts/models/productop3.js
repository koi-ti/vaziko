/**
* Class Productop3Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.Productop3Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('productosp.areas.index') );
        },
        idAttribute: 'id',
        defaults: {
        	'productop3_productop': '',
            'productop3_areap': ''
        }
    });

})(this, this.document);
