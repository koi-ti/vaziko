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
            this.$wraperError = this.$('#error-resource-component');
            this.$wraperContent = this.$('#content-create-resource-component');
		},

		/**
        * Display form modal resource
        */
		addResource: function(e) {
            this.resource = $(e.currentTarget).attr("data-resource");
            this.$resourceField = $("#"+$(e.currentTarget).attr("data-field"));

            // stuffToDo resource
            var _this = this,
	            stuffToDo = {
	                'centrocosto' : function() {
                        _this.$modalComponent.find('.inner-title-modal').html('Centros de costo');

    	            	_this.model = new app.CentroCostoModel();
                        var template = _.template($('#add-centrocosto-tpl').html());
            			_this.$modalComponent.find('.content-modal').html( template(_this.model.toJSON()) );
    	            }
	            };

            if (stuffToDo[this.resource]) {
                stuffToDo[this.resource]();
				
                this.$wraperError.hide().empty();                                     

	            // Events
            	this.listenTo( this.model, 'sync', this.responseServer );
            	this.listenTo( this.model, 'request', this.loadSpinner );

                // to fire plugins
                this.ready();

				this.$modalComponent.modal('show');
            } 
		},

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper(); 

            if( typeof window.initComponent.initInputMask == 'function' )
                window.initComponent.initInputMask();  

            if( typeof window.initComponent.initSelect2 == 'function' )
                window.initComponent.initSelect2();  

            if( typeof window.initComponent.initICheck == 'function' )
                window.initComponent.initICheck(); 
        },

        /**
        * Event Create Post
        */
        onStore: function (e) {

            if (!e.isDefaultPrevented()) {
                
                this.$wraperError.hide().empty();                                     

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
                this.$wraperError.empty().append(text);                                     
                this.$wraperError.show();                                     
                return;
            }

            // stuffToDo Response success
            var _this = this,
                stuffToDo = {
                    'centrocosto' : function() {
                        _this.$resourceField.select2({ data: [{id: _this.model.get('id'), text: _this.model.get('centrocosto_nombre')}] }).trigger('change');
                        _this.$resourceField.val(_this.model.get('id')).trigger('change');
                    }
                };

            if (stuffToDo[this.resource]) {
                stuffToDo[this.resource]();
                
                this.$modalComponent.modal('hide');
            }
        }
    });


})(jQuery, this, this.document);
