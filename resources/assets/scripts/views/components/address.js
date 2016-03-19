/**
* Class ComponentAddressView  of Backbone
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ComponentAddressView = Backbone.View.extend({
        
      	el: 'body',

		events: {
        	// 'focus input.address-koi-component': 'addressChanged',
        	'click .btn-address-koi-component': 'focusComponent'
		},

        /**
        * Constructor Method
        */
		initialize: function() {
            this.$modalComponent = $('#modal-address-component');
			
            this.$('#departamento_codigo').select2({ language: 'es' });
		},

		focusComponent: function(e) {
			$("#"+$(e.currentTarget).attr("data-field")).focus();
		},

		addressChanged: function(e) {
			this.inputContent = $(e.currentTarget);
			this.$modalComponent.modal('show');

			console.log(this.inputContent.val('asasdasd'))
		}
    });


})(jQuery, this, this.document);
