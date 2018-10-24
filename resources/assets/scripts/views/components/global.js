/**
* Class ComponentGlobalView  of Backbone
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ComponentGlobalView = Backbone.View.extend({

      	el: 'body',
		events: {
            'click .sidebar-toggle': 'clickSidebar',
            'click .history-back': 'clickHistoryBack',
            'click .view-notification': 'clickViewNotification',
            'hidden.bs.modal': 'multiModal'
		},

        /**
        * Constructor Method
        */
		initialize: function() {
			// Initialize
		},

		clickSidebar: function(e) {
			e.preventDefault();

			var expiration = new Date();
			expiration.setFullYear(expiration.getFullYear() + 1);

			// Create or update the cookie:
			document.cookie = "sidebar_toggle=" + (this.$el.hasClass('sidebar-collapse') ? '' : 'sidebar-collapse') + "; path=/; expires=" + expiration.toUTCString();
		},

		clickHistoryBack: function(e) {
			e.preventDefault();

			window.history.back();
		},

        clickViewNotification: function(e) {
            var _this = this;
                notification = this.$(e.currentTarget).attr('data-notification');

            // Update machine
            $.ajax({
                url: window.Misc.urlFull( Route.route('notificaciones.update', {notification: notification}) ),
                type: 'PUT',
            })
            .done(function(resp) {
                if(!_.isUndefined(resp.success)) {
                    // response success or error
                    var text = resp.success ? '' : resp.errors;
                    if( _.isObject( resp.errors ) ) {
                        text = window.Misc.parseErrors(resp.errors);
                    }

                    if( !resp.success ) {
                        alertify.error(text);
                        return;
                    }

                    location.href = location.href;
                }
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                alertify.error(thrownError);
            });
        },

		multiModal: function(){
			if( $('.modal.in').length > 0){
                $('body').addClass('modal-open');
            }
		},
    });
})(jQuery, this, this.document);
