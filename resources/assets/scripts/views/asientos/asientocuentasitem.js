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
        events: {
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

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
        },

        /*
        * Render View Element
        */
        render: function(){
            console.log(this.parameters);
            var attributes = this.model.toJSON();
            attributes.edit = this.parameters.edit;
            this.$el.html( this.template(attributes) );

            return this;
        }
    });

})(jQuery, this, this.document);