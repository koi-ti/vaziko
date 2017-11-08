/**
* Class AcabadosProductopItemView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.AcabadosProductopItemView = Backbone.View.extend({

        tagName: 'div',
        className : 'row',
        template: _.template( ($('#orden-producto-acabado-item-tpl').html() || '') ),
        parameters: {
            edit: false
        },

        /**
        * Constructor Method
        */
        initialize: function(opts){
	        // Extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

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
        },
    });

})(jQuery, this, this.document);
