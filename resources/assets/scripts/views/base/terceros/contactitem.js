/**
* Class ContactItemView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ContactItemView = Backbone.View.extend({

        tagName: 'tr',
        template: _.template( ($('#contact-item-list-tpl').html() || '') ),
        parameters: {
            edit: false,
        },

        /**
        * Constructor Method
        */
        initialize: function (opts) {
            // extends parameters
            if (opts !== undefined && _.isObject(opts.parameters))
                this.parameters = $.extend({},this.parameters, opts.parameters);

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
        },

        /*
        * Render View Element
        */
        render: function () {
            var attributes = this.model.toJSON();
                attributes.edit = this.parameters.edit;

            if (!attributes.tcontacto_activo) {
                this.$el.addClass('disable-row');
            }

            this.$el.html(this.template(attributes));
            return this;
        }
    });

})(jQuery, this, this.document);
