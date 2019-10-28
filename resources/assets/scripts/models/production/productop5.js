/**
* Class Productop5Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.Productop5Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull(Route.route('productosp.materiales.index'));
        },
        idAttribute: 'id',
        defaults: {
        	'productop5_productop': '',
            'productop5_materialp': ''
        }
    });

})(this, this.document);
