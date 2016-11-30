/**
* Class AsientoMovimientosItemView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.AsientoMovimientosItemView = Backbone.View.extend({

        tagName: 'tr',
        template: _.template( ($('#show-info-asiento2-movimientos-tpl').html() || '') ),

        /**
        * Constructor Method
        */
        initialize: function() {
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
        }
    });

})(jQuery, this, this.document);