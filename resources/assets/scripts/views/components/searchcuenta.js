/**
* Class ComponentSearchCuentaView  of Backbone
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ComponentSearchCuentaView = Backbone.View.extend({
        
      	el: 'body',
		events: {
			'change input.plancuenta-koi-component': 'cuentaChanged'
		},

        /**
        * Constructor Method
        */
		initialize: function() {
			// Initialize     
		},

		cuentaChanged: function(e) {
			var _this = this;
			
			this.$inputContent = $(e.currentTarget);
			this.$inputName = this.$("#"+$(e.currentTarget).attr("data-name"));
			this.$inputBase = this.$("#"+$(e.currentTarget).attr("data-base"));
			this.$inputValor = this.$("#"+$(e.currentTarget).attr("data-valor"));
			this.$wraperConten = this.$("#"+$(e.currentTarget).attr("data-wrapper"));

			var cuenta = this.$inputContent.val();
			if(!_.isUndefined(cuenta) && !_.isNull(cuenta) && cuenta != '') {
				// Get plan cuenta 
	            $.ajax({
	                url: window.Misc.urlFull(Route.route('plancuentas.search')),
	                type: 'GET',
	                data: { plancuentas_cuenta: cuenta },
	                beforeSend: function() {
						_this.$inputName.val('');	                    
	                    window.Misc.setSpinner( _this.$wraperConten );
	                }
	            })
	            .done(function(resp) {  
	                window.Misc.removeSpinner( _this.$wraperConten );
                   if(resp.success) {
	                    // Set name
	                    if(!_.isUndefined(resp.plancuentas_nombre) && !_.isNull(resp.plancuentas_nombre)){
							_this.$inputName.val(resp.plancuentas_nombre);
	                    }
	                    
	                    // Eval base
                    	if(_this.$inputBase.length) {
							_this.$inputBase.prop('readonly', true);
							
	                    	if(!_.isUndefined(resp.plancuentas_tasa) && !_.isNull(resp.plancuentas_tasa) && resp.plancuentas_tasa > 0) {
	                    		// Case plancuentas_tasa eval value
	                    		_this.$inputBase.prop('readonly', false);
	             				_this.$inputValor.val( (resp.plancuentas_tasa * _this.$inputBase.val()) );
	                    	}else{
	                    		// Case without plancuentas_tasa 
	                    		_this.$inputBase.val(0);
	                    	}
	                    }
	                }
	            })
	            .fail(function(jqXHR, ajaxOptions, thrownError) {
	                window.Misc.removeSpinner( _this.$wraperConten );
	                alertify.error(thrownError);
	            });

	     	}
		}
    });


})(jQuery, this, this.document);
