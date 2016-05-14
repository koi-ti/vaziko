/**
* Class ComponentCreateResourceView  of Backbone
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ComponentCreateResourceView = Backbone.View.extend({
        
      	el: 'body',
		events: {
            'click .btn-add-resource-koi-component': 'addResource',
            'submit #form-create-resource-component': 'onStore'
		},

        /**
        * Constructor Method
        */
		initialize: function() {
			// Initialize            
            this.$modalComponent = this.$('#modal-add-resource-component');
            this.$wraperContent = this.$('#content-create-resource-component');

            console.log(this.$wraperContent)
		},

		/**
        * Display form modal resource
        */
		addResource: function(e) {
			var resource = $(e.currentTarget).attr("data-resource");

            // stuffToDo resource
            var _this = this,
	            stuffToDo = {
	                'centrocosto' : function() {
    	            	_this.model = new app.CentroCostoModel();
            			_this.$modalComponent.find('.content-modal').html( _.template(($('#add-centrocosto-tpl').html() || ''), { }) );
    	            }
	            };

            if (stuffToDo[resource]) {
                stuffToDo[resource]();
				
	            // Events
            	this.listenTo( this.model, 'sync', this.responseServer );
            	this.listenTo( this.model, 'request', this.loadSpinner );

				this.$modalComponent.modal('show');
            } 
		},

        /**
        * Event Create Post
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {
            
                e.preventDefault();
                var data = window.Misc.formToJson( e.target );
                this.model.save( data, {patch: true} );                
            }
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function (model, xhr, opts) {
            window.Misc.setSpinner( this.$wraperConten );
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            window.Misc.removeSpinner( this.$wraperConten );

            // response success or error
            var text = resp.success ? '' : resp.errors;
            if( _.isObject( resp.errors ) ) {
                text = window.Misc.parseErrors(resp.errors);
            }

            if( !resp.success ) {
                alertify.error(text);
                return;
            }

            alertify.success('TODOD OK PCMARO');

            // stuffToDo Callback
            // var _this = this,
            //     stuffToDo = {
            //         'toShow' : function() {
            //             window.Misc.successRedirect(_this.msgSuccess, window.Misc.urlFull( Route.route('centroscosto.show', { centroscosto: resp.id})) );            
            //         },

            //         'default' : function() {
            //             alertify.success(_this.msgSuccess);
            //         }
            //     };

            // if (stuffToDo[this.parameters.callback]) {
            //     stuffToDo[this.parameters.callback]();
            // } else {
            //     stuffToDo['default']();
            // }
        }
    });


})(jQuery, this, this.document);
