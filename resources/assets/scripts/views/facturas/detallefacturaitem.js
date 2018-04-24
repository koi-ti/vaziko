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
        className: 'form-group',
        template: _.template( ($('#facturado-item-list-tpl').html() || '') ),
        events: {
            'change .change-cantidad': 'changeCantidad'
        },
        parameters: {
        },

        /**
        * Constructor Method
        */
        initialize: function(opts){
	        // Extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            if( !this.parameters.edit ){
                this.template = _.template( ($('#add-factura-item-tpl').html() || '') );
            }

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
        },

        /*
        * Render View Element
        */
        render: function(){
            var attributes = this.model.toJSON();
            this.$el.html( this.template(attributes) );
            return this;
        },

        changeCantidad: function(e) {
            var selector = this.$(e.currentTarget);

            // rules && validate
            var min = selector.attr('min');
            var max = selector.attr('max');
            if( selector.val() < parseInt(min) || selector.val() > parseInt(max) || _.isEmpty( selector.val() ) ){
                selector.parent().addClass('has-error');
                return;
            }else{
                selector.parent().removeClass('has-error');
            }

            // Settear el valor al modelo
            this.model.set({ "factura2_cantidad": selector.val() }, {silent: true});
        },
    });

})(jQuery, this, this.document);
