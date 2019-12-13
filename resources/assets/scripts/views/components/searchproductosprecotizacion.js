    /**
* Class ComponentSearchProductosPreCotizacionView of Backbone
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ComponentSearchProductosPreCotizacionView = Backbone.View.extend({

      	el: 'body',
        template: _.template(($('#koi-search-productos-precotizacion-component-tpl').html() || '')),
		events: {
			'change input.producto-precotizacion-koi-component': 'preCotizacionChanged',
            'click .btn-koi-search-producto-precotizacion-component-table': 'searchPreCotizacion',
            'click .btn-search-koi-search-producto-precotizacion-component': 'search',
            'click .btn-clear-koi-search-producto-precotizacion-component': 'clear',
            'click .a-koi-search-producto-precotizacion-component-table': 'setPreCotizacion',
            'click .a-koi-search-producto-precotizacion-show-component-table': 'showProducto'
		},

        /**
        * Constructor Method
        */
		initialize: function () {
			// Initialize
            this.$modalComponent = this.$('#modal-search-productos-precotizacion-component');
            this.$modalProductShowComponent = this.$('#modal-show-productos-component');
		},

		searchPreCotizacion: function (e) {
            e.preventDefault();
            var _this = this;

            // Render template
            this.$modalComponent.find('.content-modal').html(this.template);

            // References
            this.$searchPreCotizacion = this.$('#search_precotizacion');
            this.$searchPreCotizacionNombre = this.$('#search_precotizacion_nombre');
            this.$searchPreCotizacionEstado = this.$('#search_precotizacion_estado');

            this.$productsPreCotizacionSearchTable = this.$modalComponent.find('#koi-search-productos-precotizacion-component-table');
            this.$inputContent = this.$("#"+$(e.currentTarget).attr("data-field"));
            this.$inputName = this.$("#"+this.$inputContent.attr("data-name"));
            this.$inputRender = this.$("#"+$(e.currentTarget).attr("data-render"));

			this.productsPreCotizacionSearchTable = this.$productsPreCotizacionSearchTable.DataTable({
				dom: "<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: {
                    url: window.Misc.urlFull(Route.route('precotizaciones.productos.index')),
                    data: function (data) {
                    	data.datatables = true;
                        data.search_precotizacion = _this.$searchPreCotizacion.val();
                        data.search_precotizacion_estado = _this.$searchPreCotizacionEstado.val();
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'precotizacion_codigo', name: 'precotizacion_codigo' },
                    { data: 'productop_nombre', name: 'productop_nombre' },
                    { data: 'precotizacion1_ano', name: 'precotizacion1_ano' },
                    { data: 'precotizacion1_numero', name: 'precotizacion1_numero' },
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
                        	return '<a href="#" class="a-koi-search-producto-precotizacion-component-table">' + data + '</a>';
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
                            return '<a class="btn btn-default btn-xs a-koi-search-producto-precotizacion-show-component-table" data-resource="' + data + '" data-producto="' + full.precotizacion2_productop + '"><i class="fa fa-search"></i></a>';
                        }
                    }
                ],
                fnRowCallback: function(row, data) {
                    if (parseInt(data.precotizacion1_abierta)) {
                        $(row).css({color: "#00a65a"});
                    } else if (!parseInt(data.precotizacion1_abierta)) {
                        $(row).css({color: "red"});
                    } else if (parseInt(data.precotizacion1_culminada)) {
                        $(row).css({color: "#0073b7"});
                    }
                }
			});

            // Modal show
            this.ready();
			this.$modalComponent.modal('show');
		},

		setPreCotizacion: function (e) {
			e.preventDefault();
	        var data = this.productsPreCotizacionSearchTable.row($(e.currentTarget).parents('tr')).data();

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

		    this.productsPreCotizacionSearchTable.ajax.reload();
		},

		clear: function (e) {
			e.preventDefault();

            this.$searchPreCotizacion.val('');
            this.$searchPreCotizacionNombre.val('');
            this.$searchPreCotizacionEstado.val('');

            this.productsPreCotizacionSearchTable.ajax.reload();
		},

		preCotizacionChanged: function (e) {
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
	                url: window.Misc.urlFull(Route.route('precotizaciones.productos.search')),
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
            this.precotizacion2Model = new app.PreCotizacion2Model();
            this.precotizacion2Model.set({id: resource}, {silent: true});

            // Instance new component
            this.componentProductView = new app.ComponentProductView({
                el: '#modal-show-productos-component',
                model: this.precotizacion2Model,
                parameters: {
                    modal: this.$modalProductShowComponent,
                    collections: {
                        maquinas: new app.MaquinasProductopPreCotizacionList(),
                        acabados: new app.AcabadosProductopPreCotizacionList(),
                        materiales: new app.MaterialesProductopPreCotizacionList(),
                        areas: new app.AreasProductopPreCotizacionList(),
                        empaques: new app.EmpaquesProductopPreCotizacionList(),
                        tranportes: new app.TransportesProductopPreCotizacionList(),
                    },
                    dataFilter: {
                        precotizacion2: resource,
                        producto: producto
                    },
                    fineUploader: {
                        endpoint: window.Misc.urlFull(Route.route('precotizaciones.productos.imagenes.index')),
                        params: {
                            precotizacion2: resource
                        }
                    }
                }
            });
            this.precotizacion2Model.fetch();

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
