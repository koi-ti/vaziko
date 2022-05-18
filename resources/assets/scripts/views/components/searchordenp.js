/**
* Class ComponentSearchOrdenPView of Backbone
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ComponentSearchOrdenPView = Backbone.View.extend({

      	el: 'body',
        template: _.template(($('#koi-search-ordenp-component-tpl').html() || '')),
		events: {
			'change input.ordenp-koi-component': 'ordenpChanged',
            'click .btn-koi-search-orden-component-table': 'searchOrden',
            'click .btn-search-koi-search-ordenp-component': 'search',
            'click .btn-clear-koi-search-ordenp-component': 'clear',
            'click .a-koi-search-ordenp-component-table': 'setOrden'
		},

        /**
        * Constructor Method
        */
		initialize: function () {
			// Initialize
            this.$modalComponent = this.$('#modal-search-ordenp-component');
		},

		searchOrden: function (e) {
            e.preventDefault();
            var _this = this;

            // Render template
            this.$modalComponent.find('.content-modal').html(this.template({}));

            // References
            this.$searchordenpOrden = this.$('#searchordenp_ordenp_numero');
            this.$searchordenpTercero = this.$('#searchordenp_tercero');
            this.$searchordenpTerceroNombre = this.$('#searchordenp_tercero_nombre');
            this.$ordersSearchTable = this.$modalComponent.find('#koi-search-ordenp-component-table');
            this.$inputContent = this.$("#" + $(e.currentTarget).attr("data-field"));
            this.$inputName = this.$("#"+this.$inputContent.attr("data-name"));
            this.$factura = this.$inputContent.attr("data-factura");
            this.$estado = this.$inputContent.attr("data-estado");

			this.ordersSearchTable = this.$ordersSearchTable.DataTable({
				dom: "<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
                pageLength: 10,
                lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                ajax: {
                    url: window.Misc.urlFull(Route.route('search.ordenes')),
                    data: function (data) {
                        data.search = true;
                        data.factura = _this.$factura;
                        data.orden_estado = _this.$estado;
                        data.orden_numero = _this.$searchordenpOrden.val();
                        data.orden_tercero_nit = _this.$searchordenpTercero.val();
                    }
                },
                columns: [
                    { data: 'orden_codigo', name: 'orden_codigo' },
                    { data: 'orden_ano', name: 'orden_ano' },
                    { data: 'orden_numero', name: 'orden_numero' },
                    { data: 'tercero_nombre', name: 'tercero_nombre' },
                    { data: 'orden_fecha', name: 'orden_fecha' },
                    { data: 'id', name: 'id' }
                ],
                order: [
                	[ 1, 'desc' ], [ 2, 'desc' ]
                ],
                columnDefs: [
                    {
                        targets: 0,
                        searchable: false,
                        render: function (data, type, full, row) {
                        	return '<a href="#" class="a-koi-search-ordenp-component-table">' + data + '</a>';
                        }
                    },
                    {
                        targets: [1, 2],
                        visible: false
                    },
                    {
                        targets: 4 ,
                        render: function (data, type, full, row) {
                            return window.moment(data).format('YYYY-MM-DD');
                        }
                    },
                    {
                        targets: 5,
                        orderable: false,
                        className: 'text-center',
                        render: function (data, type, full, row) {
                            if (parseInt(full.orden_anulada)) {
                                return '<span class="label label-danger">ANULADA</span>';
                            } else if (parseInt(full.orden_abierta)) {
                                return '<span class="label label-success">ABIERTA</span>';
                            } else if (parseInt(full.orden_culminada)) {
                                return '<span class="label label-info">CULMINADA</span>';
                            } else if (!parseInt(full.orden_abierta)) {
                                return '<span class="label label-warning">CERRADA</span>';
                            }
                        }
                    }
                ],
                fnRowCallback: function (row, data) {
                    if (parseInt(data.orden_abierta)) {
                        $(row).css({"color":"#00A65A"});
                    } else if (parseInt(data.orden_anulada)) {
                        $(row).css({"color":"#DD4B39"});
                    } else if (parseInt(data.orden_culminada)) {
                        $(row).css({"color":"#0073B7"});
                    }
                }

			});

            // Modal show
            this.ready();
			this.$modalComponent.modal('show');
		},

		setOrden: function (e) {
			e.preventDefault();
	        var data = this.ordersSearchTable.row($(e.currentTarget).parents('tr')).data();

            this.$inputContent.val(data.orden_codigo);
            this.$inputName.val(data.tercero_nombre);

            if (this.$factura == 'true') {
                this.$inputContent.trigger('change');
            }

			this.$modalComponent.modal('hide');
		},

		search: function (e) {
			e.preventDefault();

		    this.ordersSearchTable.ajax.reload();
		},

		clear: function (e) {
			e.preventDefault();

            this.$searchordenpOrden.val('');
            this.$searchordenpTercero.val('');
            this.$searchordenpTerceroNombre.val('');

            this.ordersSearchTable.ajax.reload();
		},

		ordenpChanged: function (e) {
			var _this = this;

			this.$inputContent = $(e.currentTarget);
			this.$inputName = this.$("#" + $(e.currentTarget).attr("data-name"));
			this.$wraperConten = this.$("#" + $(e.currentTarget).attr("data-wrapper"));
            this.$estado = this.$inputContent.attr("data-estado");

			var orden = this.$inputContent.val(),
                estado = this.$estado;

            // Before eval clear data
            this.$inputName.val('');

			if (!_.isUndefined(orden) && !_.isNull(orden) && orden != '') {
				// Get Orden
	            $.ajax({
	                url: window.Misc.urlFull(Route.route('search.ordenes')),
	                type: 'GET',
	                data: {
                        orden_codigo: orden,
                        orden_estado: estado
                    },
	                beforeSend: function () {
						_this.$inputName.val('');
	                    window.Misc.setSpinner(_this.$wraperConten);
	                }
	            })
	            .done(function (resp) {
	                window.Misc.removeSpinner(_this.$wraperConten);
	                if (resp.success) {
	                    if (!_.isUndefined(resp.tercero_nombre) && !_.isNull(resp.tercero_nombre)) {
							_this.$inputName.val(resp.tercero_nombre);
	                    }
	                }
	            })
	            .fail(function (jqXHR, ajaxOptions, thrownError) {
	                window.Misc.removeSpinner(_this.$wraperConten);
	                alertify.error(thrownError);
	            });
	     	}
		},

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if (typeof window.initComponent.initToUpper == 'function')
                window.initComponent.initToUpper();
        }
    });


})(jQuery, this, this.document);
