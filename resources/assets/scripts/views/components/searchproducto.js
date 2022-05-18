/**
* Class ComponentSearchProductoView of Backbone
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ComponentSearchProductoView = Backbone.View.extend({

      	el: 'body',
        template: _.template(($('#koi-search-producto-component-tpl').html() || '')),
		events: {
			'change input.producto-koi-component': 'productoChanged',
            'click .btn-koi-search-producto-component': 'searchProducto',
            'click .btn-search-koi-search-producto-component': 'search',
            'click .btn-clear-koi-search-producto-component': 'clear',
            'click .a-koi-search-producto-component-table': 'setProducto'
		},

        /**
        * Constructor Method
        */
		initialize: function () {
			// Initialize
            this.$modalComponent = this.$('#modal-search-producto-component');
		},

		searchProducto: function (e) {
            e.preventDefault();
            var _this = this;

            // Render template
            this.$modalComponent.find('.content-modal').html(this.template({}));

            // References
            this.$searchCodigo = this.$('#koi_search_producto_codigo');
            this.$searchNombre = this.$('#koi_search_producto_nombre');

            this.$productosSearchTable = this.$modalComponent.find('#koi-search-producto-component-table');
			this.$inputContent = this.$("#" + $(e.currentTarget).attr("data-field"));
			this.$inputName = this.$("#"+this.$inputContent.attr("data-name"));
			this.asiento = this.$inputContent.attr("data-asiento");
			this.naturaleza = this.$inputContent.attr("data-naturaleza");

			this.productosSearchTable = this.$productosSearchTable.DataTable({
				dom: "<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
                pageLength: 10,
                lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                ajax: {
                    url: window.Misc.urlFull(Route.route('search.productos')),
                    data: function (data) {
                        data.search = 'datatable';
                        data.asiento = _this.asiento;
                        data.naturaleza = _this.naturaleza;
                        data.producto_codigo = _this.$searchCodigo.val();
                        data.producto_nombre = _this.$searchNombre.val();
                    }
                },
                columns: [
                    { data: 'producto_codigo', name: 'producto_codigo' },
                    { data: 'producto_nombre', name: 'producto_nombre' },
                    { data: 'producto_unidades', name: 'producto_unidades' }
                ],
                columnDefs: [
					{
						targets: 0,
						width: '10%',
						searchable: false,
						render: function (data, type, full, row) {
							return '<a href="#" class="a-koi-search-producto-component-table">' + data + '</a>';
						}
					},
                    {
                        targets: 2,
                        searchable: false,
                        orderable: false,
                        className: 'text-center',
                        render: function (data, type, full, row) {
                            if (parseInt(parseInt(full.producto_unidades) && parseInt(full.producto_serie))) {
                                return '<span class="label label-success">SERIE</span>';
                            } else if (parseInt(full.producto_unidades) && parseInt(full.producto_metrado)) {
                                return '<span class="label label-success">METRADO</span>';
                            } else {
                                return '<span class="label label-success">UNIDADES</span>';
                            }
                        }
                    }
                ]
			});

            // Modal show
            this.ready();
			this.$modalComponent.modal('show');
		},

		setProducto: function (e) {
			e.preventDefault();

	        var data = this.productosSearchTable.row($(e.currentTarget).parents('tr')).data();

			this.$inputContent.val(data.producto_codigo).trigger('change');
			this.$inputName.val(data.producto_nombre);

			this.$modalComponent.modal('hide');
		},

		search: function (e) {
			e.preventDefault();

		    this.productosSearchTable.ajax.reload();
		},

		clear: function (e) {
			e.preventDefault();

            this.$searchCodigo.val('');
            this.$searchNombre.val('');

            this.productosSearchTable.ajax.reload();
		},

		productoChanged: function (e) {
			var _this = this;

			this.$inputContent = $(e.currentTarget);
			this.$inputName = this.$("#" + $(e.currentTarget).attr("data-name"));
			this.$wraperConten = this.$("#" + $(e.currentTarget).attr("data-wrapper"));
            this.asiento = this.$inputContent.attr("data-asiento");
			this.naturaleza = this.$inputContent.attr("data-naturaleza");

			var producto = this.$inputContent.val();

            // Before eval clear data
            this.$inputName.val('');

			if (!_.isUndefined(producto) && !_.isNull(producto) && producto != '') {
				// Get Producto
	            $.ajax({
	                url: window.Misc.urlFull(Route.route('search.productos')),
	                type: 'GET',
	                data: {
                        search: 'input',
                        producto_codigo: producto,
                        asiento: _this.asiento,
                        naturaleza: _this.naturaleza
                    },
	                beforeSend: function () {
						_this.$inputName.val('');
	                    window.Misc.setSpinner(_this.$wraperConten);
	                }
	            })
	            .done(function (resp) {
	                window.Misc.removeSpinner(_this.$wraperConten);
	                if (resp.success) {
	                    if (!_.isUndefined(resp.producto_nombre) && !_.isNull(resp.producto_nombre)) {
							_this.$inputName.val(resp.producto_nombre);
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
