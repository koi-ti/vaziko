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
        template: _.template( ($('#koi-address-component-tpl').html() || '') ),

		events: {
        	// 'focus input.address-koi-component': 'addressChanged',
            'click .btn-address-koi-component': 'focusComponent',
            'submit #form-address-component': 'addAddress',

            'change select#koi_nomenclatura1': 'nomenclatura1Changed',
            'change input#koi_numero1': 'numero1Changed',
            'change select#koi_alfabeto1': 'alfabeto1Changed',
            'change select#koi_bis': 'bisChanged',
            'change select#koi_alfabeto2': 'alfabeto2Changed',
            'change select#koi_cardinales1': 'cardinales1Changed',
            'change input#koi_numero2': 'numero2Changed',
            'change select#koi_alfabeto3': 'alfabeto3Changed',
            'change input#koi_numero3': 'numero3Changed',
            'change select#koi_cardinales2': 'cardinales2Changed',

            'click .btn-address-component-add-complement': 'addComplement',
            'click .btn-address-component-remove-item': 'removeItem'
		},

        /**
        * Constructor Method
        */
		initialize: function() {
			// Initialize            
            this.$modalComponent = this.$('#modal-address-component');
		},

		focusComponent: function(e) {
			$("#"+$(e.currentTarget).attr("data-field")).focus();
		},
	
		addressChanged: function(e) {
			this.inputContent = $(e.currentTarget);

            this.$modalComponent.find('.content-modal').html( this.template({ }) );

            // References
            this.$addressField = this.$modalComponent.find('#koi_direccion');
            this.$postalField = this.$modalComponent.find('#koi_postal');
            this.$formComponent = this.$modalComponent.find('#form-address-component');

            // Initialize
            this.addressData = new Array(10);

            // to fire plugins
            if( typeof window.initComponent.initSelect2 == 'function' )
                window.initComponent.initSelect2();

            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();

            this.$formComponent.validator();

            // Modal show
			this.$modalComponent.modal('show');
		},

		addAddress: function(e) {
            if (!e.isDefaultPrevented()) {
            
                e.preventDefault();
    			this.inputContent.val(this.$addressField.val());
    			this.$modalComponent.modal('hide');               
            }
		},

		/**
        * Built changed funtions
        */
        nomenclatura1Changed: function (e) {
        	this.addressData[0] = $(e.currentTarget).val();
            this.buildAddress();
        },

        numero1Changed: function(e) {
        	this.addressData[1] = $(e.currentTarget).val().trim();
            this.buildAddress();
        },

        alfabeto1Changed: function (e) {
        	this.addressData[2] = $(e.currentTarget).val();
            this.buildAddress();
        },

        bisChanged: function (e) {
        	this.addressData[3] = $(e.currentTarget).val();
            this.buildAddress();
        },
        
        alfabeto2Changed: function (e) {
        	this.addressData[4] = $(e.currentTarget).val();
            this.buildAddress();
        },

        cardinales1Changed: function (e) {
        	this.addressData[5] = $(e.currentTarget).val();
            this.buildAddress();
        },

        numero2Changed: function(e) {
        	this.addressData[6] = $(e.currentTarget).val().trim();
            this.buildAddress();
        },

        alfabeto3Changed: function (e) {
        	this.addressData[7] = $(e.currentTarget).val();
            this.buildAddress();
        },

        numero3Changed: function(e) {
        	this.addressData[8] = $(e.currentTarget).val().trim();
            this.buildAddress();
        },

        cardinales2Changed: function (e) {
        	this.addressData[9] = $(e.currentTarget).val();
            this.buildAddress();
        },

        /**
        * Add complement
        */
		addComplement: function(e) {
            e.preventDefault();

            if( !_.isUndefined(this.$('#koi_complementos1').val()) && !_.isNull(this.$('#koi_complementos1').val()) && this.$('#koi_complementos1').val() != '' ) {
                this.addressData.push(this.$('#koi_complementos1').val());

                if( !_.isUndefined(this.$('#koi_complementos2').val()) && !_.isNull(this.$('#koi_complementos2').val()) && this.$('#koi_complementos2').val() != '' ) {
                    this.addressData.push(this.$('#koi_complementos2').val());
                }
    			
                this.$('#koi_complementos1').val('');
    			this.$('#koi_complementos2').val('');
    			
    			this.buildAddress();
            }

		},

        /**
        * remove last item 
        */
        removeItem: function(e) {
            e.preventDefault();

            this.addressData.pop();
            this.buildAddress();
        },
        
     	/**
        * Built address
        */
		buildAddress: function() {
			// console.log('buildAddress', this.addressData, this.addressData.join());
            var addreess = $.grep(this.addressData, Boolean).join(' ').trim();
            this.$addressField.val( addreess );
            
            // console.log('buildAddress', this.addressData, addreess);
            console.log(this.$postalField.val())
		}
    });


})(jQuery, this, this.document);
