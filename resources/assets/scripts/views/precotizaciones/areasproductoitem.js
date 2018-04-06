/**
* Class AreasProductopPreCotizacionItemView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.AreasProductopPreCotizacionItemView = Backbone.View.extend({

        tagName: 'tr',
        className: 'form-group',
        template: _.template( ($('#precotizacion-producto-areasp-item-tpl').html() || '') ),
        events: {
            'change .change-time': 'changeTime'
        },
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

        changeTime: function(e) {
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

            if ( selector.data('type') == 'hs' ){
                this.model.set({
                    'precotizacion6_horas': selector.val(),
                });
            }else if( selector.data('type') == 'ms' ){
                this.model.set({
                    'precotizacion6_minutos': selector.val()
                });
            }
            
            this.collection.trigger('reset');
        },
    });

})(jQuery, this, this.document);
