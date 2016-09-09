/**
* Class ComponentTerceroView  of Backbone
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ComponentTerceroView = Backbone.View.extend({

      	el: 'body',
        templateName: _.template( ($('#tercero-name-tpl').html() || '') ),
		events: {
			'change .change-nit-koi-component': 'nitChanged',
            'change .change-actividad-koi-component': 'actividadChanged'
		},

        /**
        * Constructor Method
        */
		initialize: function() {
			// Initialize
		},

        nitChanged: function(e) {
            var _this = this;

            // Reference to fields
            this.$dv = $("#"+$(e.currentTarget).attr("data-field"));
        	this.$wraperContent = this.$('#tercero-create');
            if(!this.$wraperContent.length) {
	            this.$modalComponent = this.$('#modal-add-resource-component');
	            this.$wraperContent = this.$modalComponent.find('.modal-body');
   			}

            $.ajax({
                url: window.Misc.urlFull(Route.route('terceros.dv')),
                type: 'GET',
                data: { tercero_nit: $(e.currentTarget).val() },
                beforeSend: function() {
                    window.Misc.setSpinner( _this.$wraperContent );
                }
            })
            .done(function(resp) {
                window.Misc.removeSpinner( _this.$wraperContent );
                if(resp.success) {
                    // Dv
                    _this.$dv.val(resp.dv);
                }
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                window.Misc.removeSpinner( _this.$wraperContent );
                alertify.error(thrownError);
            });
        },

        actividadChanged: function(e) {
            var _this = this;

            // Reference to fields
            this.$retecree = $("#"+$(e.currentTarget).attr("data-field"));
            this.$wraperContent = this.$('#tercero-create');
            if(!this.$wraperContent.length) {
                this.$modalComponent = this.$('#modal-add-resource-component');
                this.$wraperContent = this.$modalComponent.find('.modal-body');
            }

            $.ajax({
                url: window.Misc.urlFull(Route.route('terceros.rcree')),
                type: 'GET',
                data: { tercero_actividad: $(e.currentTarget).val() },
                beforeSend: function() {
                    window.Misc.setSpinner( _this.$wraperContent );
                }
            })
            .done(function(resp) {
                window.Misc.removeSpinner( _this.$wraperContent );
                if(resp.success) {
                    // % cree
                    if(!_.isUndefined(resp.rcree) && !_.isNull(resp.rcree)){
                        _this.$retecree.html(resp.rcree);
                    }
                }
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                window.Misc.removeSpinner( _this.$wraperContent );
                alertify.error(thrownError);
            });
        }
    });


})(jQuery, this, this.document);
