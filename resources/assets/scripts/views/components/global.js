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

        clickHistorialInsumo: function (e) {
            e.preventDefault();

            var insumo = this.$(e.currentTarget).attr('data-resource');
                tipo = this.$(e.currentTarget).attr('data-tipo');
                title = '';

            if (insumo) {
                if (tipo == 'M') {
                    title = 'Materiales de producción';
                } else if (tipo == 'E') {
                    title = 'Empaques de producción';
                } else {
                    title = 'Transportes de producción';
                }

                this.$modal = $('#modal-historial-resource-component');
                this.$modal.find('.modal-title').text('Historial del insumo ('+ title +')');
                this.$modal.modal('show');

                // Detalle item rollo list
                this.productoHistorialListView = new app.ProductoHistorialListView({
                    collection: new app.ProductoHistorialList(),
                    parameters: {
                        dataFilter: {
                            insumo: insumo,
                            tipo: tipo
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
