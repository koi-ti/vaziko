/**
* Class TransportesProductopCotizacionItemView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.TransportesProductopCotizacionItemView = Backbone.View.extend({

        tagName: 'tr',
        template: _.template( ($('#cotizacion-producto-transporte-item-tpl').html() || '') ),
        parameters: {
            edit: false
        },

        /**
        * Constructor Method
        */
        initialize: function(opts){
	        // Extends parameters
            if (opts !== undefined && _.isObject(opts.parameters))
                this.parameters = $.extend({},this.parameters, opts.parameters);

            if (this.parameters.action == 'edit') {
                this.template = _.template( ($('#cotizacion-producto-transporte-edit-item-tpl').html() || '') );
            }

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
        },

        /*
        * Render View Element
        */
        render: function(){
            var attributes = this.model.toJSON();
                attributes.edit = this.parameters.edit;
            this.$el.html( this.template(attributes) );
            return this;
        }
    });

})(jQuery, this, this.document);
