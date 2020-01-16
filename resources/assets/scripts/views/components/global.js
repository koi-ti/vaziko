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
            'click .history-back': 'clickHistorialBack',
            'click .view-notification': 'clickViewNotification',
            'click .historial-insumo': 'clickHistorialInsumo',
            'change .calculate-formula': 'calculateFormula',
            'hidden.bs.modal': 'multiModal',
		},

		clickSidebar: function (e) {
			e.preventDefault();

			var expiration = new Date();
			expiration.setFullYear(expiration.getFullYear() + 1);

			// Create or update the cookie:
			document.cookie = "sidebar_toggle=" + (this.$el.hasClass('sidebar-collapse') ? '' : 'sidebar-collapse') + "; path=/; expires=" + expiration.toUTCString();
		},

		clickHistorialBack: function (e) {
			e.preventDefault();

			window.history.back();
		},

        clickViewNotification: function (e) {
            var _this = this;
                notification = this.$(e.currentTarget).attr('data-notification');

            // Update machine
            $.ajax({
                url: window.Misc.urlFull(Route.route('notificaciones.update', {notification: notification})),
                type: 'PUT',
            })
            .done(function(resp) {
                if (!_.isUndefined(resp.success)) {
                    // response success or error
                    var text = resp.success ? '' : resp.errors;
                    if (_.isObject(resp.errors)) {
                        text = window.Misc.parseErrors(resp.errors);
                    }

                    if (!resp.success) {
                        alertify.error(text);
                        return;
                    }

                    window.Misc.redirect(window.Misc.urlFull(Route.route('notificaciones.index')));
                }
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                alertify.error(thrownError);
            });
        },

        clickHistorialInsumo: function (e) {
            e.preventDefault();
            var insumo = this.$(e.currentTarget).attr('data-resource');
                call = this.$(e.currentTarget).attr('data-call');
                title = '';

            if (insumo) {
                if (call == 'materialp') {
                    title = 'Materiales de producción';
                } else {
                    title = 'Empaques de producción';
                }

                this.$modal = $('#modal-historial-resource-component');
                this.$modal.find('.modal-title').text('Historial del insumo ('+ title +')');
                this.$modal.modal('show');

                // Detalle item rollo list
                this.productoHistorialListView = new app.ProductoHistorialListView({
                    collection: new app.ProductoHistorialList(),
                    parameters: {
                        dataFilter: {
                            producto_id: insumo,
                            call: call
                        }
                    }
                });
            }
        },

        calculateFormula: function (e) {
            var formula = this.$(e.currentTarget).val(),
                response = this.$(e.currentTarget).data('response');

            this.$('#' + response).val(eval(formula)).trigger('change');
        },

		multiModal: function () {
			if ($('.modal.in').length > 0) {
                $('body').addClass('modal-open');
            }
		},
    });
})(jQuery, this, this.document);
