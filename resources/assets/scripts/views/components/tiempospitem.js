/**
* Class TiempopItemView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.TiempopItemView = Backbone.View.extend({

        tagName: 'tr',
        templateTiempop: _.template( ($('#tiempop-item-list-tpl').html() || '') ),
        templateTiempopOrdenp: _.template( ($('#ordenp-tiempop-item-list-tpl').html() || '') ),
        events: {
            'click .edit-tiempop': 'editTiempop',
        },
        parameters: {
            edit: false,
            dataFilter: null
        },

        /**
        * Constructor Method
        */
        initialize: function(opts){
	        // Extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            this.$modal = $('#modal-tiempop-edit-component');
            if( this.parameters.dataFilter.type == 'tiemposp' ){
                this.template = this.templateTiempop;

            }else if( this.parameters.dataFilter.type == 'ordenp' ){
                this.template = this.templateTiempopOrdenp;

            }

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.collection, 'sync', this.responseServer );
        },

        /**
        *  Edit tiempo de produccion
        **/
        editTiempop: function(e){
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                // Open tiempopActionView
                if ( this.tiempopActionView instanceof Backbone.View ){
                    this.tiempopActionView.stopListening();
                    this.tiempopActionView.undelegateEvents();
                }

                this.tiempopActionView = new app.TiempopActionView({
                    model: this.model,
                    parameters: {
                        dataFilter: this.parameters.dataFilter,
                    }
                });

                this.tiempopActionView.render();
            }
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

        responseServer: function( model, resp, opts ) {
            if(!_.isUndefined(resp.success)) {
                // Open tiempopActionView
                if ( this.tiempopActionView instanceof Backbone.View ){
                    this.tiempopActionView.stopListening();
                    this.tiempopActionView.undelegateEvents();
                }

                this.$modal.modal('hide');
                this.collection.trigger('reset');
            }
        }
    });
})(jQuery, this, this.document);
