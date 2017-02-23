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
        events: {
            'click .btn-edit-tcontacto': 'editContacto',
        },

        /**
        * Constructor Method
        */
        initialize: function(){

            //Init Attributes

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

        editContacto: function() {
            if ( this.createTContactoView instanceof Backbone.View ){
                this.createTContactoView.stopListening();
                this.createTContactoView.undelegateEvents();
            }

            this.createTContactoView = new app.CreateTContactoView({
                model: this.model
            });
            console.log( this.createTContactoView );
            this.createTContactoView.render();
        }

    });

})(jQuery, this, this.document);