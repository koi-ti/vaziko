/**
* Class ComponentSearchTerceroView  of Backbone
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ComponentSearchTerceroView = Backbone.View.extend({
        
      	el: 'body',
		events: {
			'change input.tercero-koi-component': 'terceroChanged'
		},

        /**
        * Constructor Method
        */
		initialize: function() {
			// Initialize     
		},

		terceroChanged: function(e) {
			var _this = this;
			
			this.$inputContent = $(e.currentTarget);
			this.$inputName = this.$("#"+$(e.currentTarget).attr("data-name"));
			this.$wraperConten = this.$("#"+$(e.currentTarget).attr("data-wrapper"));

			var tercero = this.$inputContent.val();
			
			if(!_.isUndefined(tercero) && !_.isNull(tercero) && tercero != '') {
				// Get tercero
	            $.ajax({
	                url: window.Misc.urlFull(Route.route('terceros.search')),
	                type: 'GET',
	                data: { tercero_nit: tercero },
	                beforeSend: function() {
						_this.$inputName.val('');
	                    window.Misc.setSpinner( _this.$wraperConten );
	                }
	            })
	            .done(function(resp) {  
	                window.Misc.removeSpinner( _this.$wraperConten );
	                if(resp.success) {
	                    if(!_.isUndefined(resp.tercero_nombre) && !_.isNull(resp.tercero_nombre)){
							_this.$inputName.val(resp.tercero_nombre);
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
