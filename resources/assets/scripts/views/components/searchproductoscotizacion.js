    /**
* Class ComponentSearchProductosCotizacionView of Backbone
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ComponentSearchProductosCotizacionView = Backbone.View.extend({

      	el: 'body',
        template: _.template(($('#koi-search-productos-cotizacion-component-tpl').html() || '')),
		events: {
			'change input.producto-cotizacion-koi-component': 'cotizacionChanged',
            'click .btn-koi-search-producto-cotizacion-component-table': 'searchCotizacion',
            'click .btn-search-koi-search-producto-cotizacion-component': 'search',
            'click .btn-clear-koi-search-producto-cotizacion-component': 'clear',
            'click .a-koi-search-producto-cotizacion-component-table': 'setCotizacion',
            'click .a-koi-search-producto-cotizacion-show-component-table': 'showProducto'
		},

        /**
        * Constructor Method
        */
		initialize: function () {
			// Initialize
            this.$modalComponent = this.$('#modal-search-productos-cotizacion-component');
            this.$modalProductShowComponent = this.$('#modal-show-productos-component');
		},

		searchCotizacion: function (e) {
            e.preventDefault();
            var _this = this;

            // Render template
            this.$modalComponent.find('.content-modal').html(this.template);

            // References
            this.$searchCotizacion = this.$('#search_cotizacion');
            this.$searchCotizacionNombre = this.$('#search_cotizacion_nombre');
            this.$searchCotizacionEstado = this.$('#search_cotizacion_estado');

            this.$productsCotizacionSearchTable = this.$modalComponent.find('#koi-search-productos-cotizacion-component-table');
            this.$inputContent = this.$("#"+$(e.currentTarget).attr("data-field"));
            this.$inputName = this.$("#"+this.$inputContent.attr("data-name"));
            this.$inputRender = this.$("#"+$(e.currentTarget).attr("data-render"));

			this.productsCotizacionSearchTable = this.$productsCotizacionSearchTable.DataTable({
				dom: "<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: {
                    url: window.Misc.urlFull(Route.route('cotizaciones.productos.index')),
                    data: function (data) {
                    	data.datatables = true;
                        data.search_cotizacion = _this.$searchCotizacion.val();
                        data.search_cotizacion_estado = _this.$searchCotizacionEstado.val();
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'cotizacion_codigo', name: 'cotizacion_codigo' },
                    { data: 'productop_nombre', name: 'productop_nombre' },
                    { data: 'cotizacion1_ano', name: 'cotizacion1_ano' },
                    { data: 'cotizacion1_numero', name: 'cotizacion1_numero' },
                    { data: 'id', name: 'id' }
                ],
                order: [
                	[ 3, 'desc' ], [ 4, 'desc' ]
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        searchable: false,
                        render: function (data, type, full, row) {
                        	return '<a href="#" class="a-koi-search-producto-cotizacion-component-table">' + data + '</a>';
                        }
                    },
                    {
                        targets: [3, 4],
                        visible: false,
                    },
                    {
                        targets: 5,
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        render: function (data, type, full, row) {
                            return '<a class="btn btn-default btn-xs a-koi-search-producto-cotizacion-show-component-table" data-resource="' + data + '" data-producto="' + full.cotizacion2_productop + '"><i class="fa fa-search"></i></a>';
                        }
                    }
                ],
                fnRowCallback: function(row, data) {
                    if (parseInt(data.cotizacion1_abierta)) {
                        $(row).css({color: "#00a65a"});
                    } else if (!parseInt(data.cotizacion1_abierta)) {
                        $(row).css({color: "black"});
                    } else if (parseInt(data.cotizacion1_anulada)) {
                        $(row).css({color: "red"});
                    }
                }
			});

            // Modal show
            this.ready();
			this.$modalComponent.modal('show');
		},

		setCotizacion: function (e) {
			e.preventDefault();
	        var data = this.productsCotizacionSearchTable.row($(e.currentTarget).parents('tr')).data();

            if (this.$inputRender.length) {
                this.$inputRender.html('').append("<option value='" + data.id + "' selected>" + data.productop_nombre + "</option>").removeAttr('disabled');
            } else {
                this.$inputContent.val(data.id);
                this.$inputName.val(data.productop_nombre);
            }

			this.$modalComponent.modal('hide');
		},

		search: function (e) {
			e.preventDefault();

		    this.productsCotizacionSearchTable.ajax.reload();
		},

		clear: function (e) {
			e.preventDefault();

            this.$searchCotizacion.val('');
            this.$searchCotizacionNombre.val('');
            this.$searchCotizacionEstado.val('');

            this.productsCotizacionSearchTable.ajax.reload();
		},

		cotizacionChanged: function (e) {
			var _this = this;

			this.$inputContent = $(e.currentTarget);
			this.$inputName = this.$("#"+$(e.currentTarget).attr("data-name"));
			this.$wraperConten = this.$("#"+$(e.currentTarget).attr("data-wrapper"));

			var producto = this.$inputContent.val();

            // Before eval clear data
            this.$inputName.val('');

			if (!_.isUndefined(producto) && !_.isNull(producto) && producto != '') {
				// Get Orden
	            $.ajax({
	                url: window.Misc.urlFull(Route.route('cotizaciones.productos.search')),
	                type: 'GET',
	                data: {
                        producto: producto
                    },
	                beforeSend: function () {
						_this.$inputName.val('');
	                    window.Misc.setSpinner(_this.$wraperConten);
	                }
	            })
	            .done(function(resp) {
	                window.Misc.removeSpinner(_this.$wraperConten);
	                if (resp.success) {
	                    if (!_.isUndefined(resp.productop_nombre) && !_.isNull(resp.productop_nombre)){
							_this.$inputName.val(resp.productop_nombre);
	                    }
	                }
	            })
	            .fail(function(jqXHR, ajaxOptions, thrownError) {
	                window.Misc.removeSpinner(_this.$wraperConten);
	                alertify.error(thrownError);
	            });
	     	}
		},

        showProducto: function (e) {
            e.preventDefault();

            // Declare variables
            var resource = $(e.currentTarget).attr('data-resource'),
                producto = $(e.currentTarget).attr('data-producto');

            // Delegate view in case exists
            if (this.componentProductView instanceof Backbone.View) {
                this.componentProductView.stopListening();
                this.componentProductView.undelegateEvents();
            }

            // Instance new model of products
            this.cotizacion2Model = new app.Cotizacion2Model();
            this.cotizacion2Model.set({id: resource}, {silent: true});

            // Instance new component
            this.componentProductView = new app.ComponentProductView({
                el: '#modal-show-productos-component',
                model: this.cotizacion2Model,
                parameters: {
                    modal: this.$modalProductShowComponent,
                    collections: {
                        maquinas: new app.MaquinasProductopCotizacionList(),
                        acabados: new app.AcabadosProductopCotizacionList(),
                        materiales: new app.MaterialesProductopCotizacionList(),
                        areas: new app.AreasProductopCotizacionList(),
                        empaques: new app.EmpaquesProductopCotizacionList(),
                        tranportes: new app.TransportesProductopCotizacionList(),
                    },
                    dataFilter: {
                        cotizacion2: resource,
                        producto: producto
                    },
                    fineUploader: {
                        endpoint: window.Misc.urlFull(Route.route('cotizaciones.productos.imagenes.index')),
                        params: {
                            cotizacion2: resource
                        }
                    }
                }
            });
            this.cotizacion2Model.fetch();

            // Open modal
            this.$modalProductShowComponent.modal('show');
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
