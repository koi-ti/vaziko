/**
* Class Productop2Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.Productop2Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('productosp.tips.index') );
        },
        idAttribute: 'id',
        defaults: {
        	'productop2_productop': '',
            'productop2_tip': ''
        }
    });

})(this, this.document);
