/**
* Class ItemRolloINListView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ItemRolloINListView = Backbone.View.extend({

        tagName: 'tr',
        template: null,

        /**
        * Constructor Method
        */
        initialize: function (opts) {
            if (opts.parameters.choose) {
                this.template = _.template(($('#choose-itemrollo-tpl').html() || ''));
            } else if (!opts.parameters.choose && opts.parameters.show) {
                this.template = _.template(($('#itemrollo-tpl').html() || ''));
            } else {
                this.template = _.template(($('#add-itemrollo-tpl').html() || ''));
            }

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
        },

        /*
        * Render View Element
        */
        render: function () {
            var attributes = this.model.toJSON();
            this.$el.html(this.template(attributes));
            return this;
        }
    });

})(jQuery, this, this.document);
