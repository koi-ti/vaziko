/**
* Class AsientoCuentasItemView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.AsientoCuentasItemView = Backbone.View.extend({

        tagName: 'tr',
        template: _.template( ($('#add-asiento2-item-tpl').html() || '') ),
        templateInfo: _.template( ($('#show-info-asiento2-tpl').html() || '') ),

        events: {
            'click .item-asiento2-show-info': 'showInfo'
        },
        parameters: {
            edit: false
        },

        /**
        * Constructor Method
        */
        initialize: function(opts){
            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            //Init Attributes
            this.$modalInfo = $('#modal-asiento-show-info-component');

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

        /**
        * Show info asiento
        */
        showInfo: function () {
            var attributes = this.model.toJSON();
            // Render info
            this.$modalInfo.find('.content-modal').empty().html( this.templateInfo( attributes ) );
            // Open modal
            this.$modalInfo.modal('show');
        }
    });

})(jQuery, this, this.document);