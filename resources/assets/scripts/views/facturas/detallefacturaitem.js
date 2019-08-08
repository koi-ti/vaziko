/**
* Class DetalleFacturaItemView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.DetalleFacturaItemView = Backbone.View.extend({

        tagName: 'tr',
        template: _.template(($('#add-factura-item-tpl').html() || '')),

        /**
        * Constructor Method
        */
        initialize: function (opts) {
	        // Extends parameters
            if (opts !== undefined && _.isObject(opts.parameters))
                this.parameters = $.extend({},this.parameters, opts.parameters);

            this.impuestos = {};

            // Events Listener
            this.listenTo(this.model, 'change', this.render);
        },

        /*
        * Render View Element
        */
        render: function () {
            var attributes = this.model.toJSON();
            this.$el.html( this.template(attributes) );
            return this;
        }
    });

})(jQuery, this, this.document);
