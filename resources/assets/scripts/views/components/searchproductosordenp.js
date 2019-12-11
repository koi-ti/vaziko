    /**
* Class ComponentSearchProductosOrdenView of Backbone
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ComponentSearchProductosOrdenView = Backbone.View.extend({

      	el: 'body',
        template: _.template(($('#koi-search-productos-orden-component-tpl').html() || '')),
		events: {
			'change input.producto-orden-koi-component': 'ordenpChanged',
            'click .btn-koi-search-producto-orden-component-table': 'searchProducto',
            'click .btn-search-koi-search-producto-orden-component': 'search',
            'click .btn-clear-koi-search-producto-orden-component': 'clear',
            'click .a-koi-search-producto-orden-component-table': 'setProducto',
            'click .a-koi-search-producto-orden-show-component-table': 'showProducto'
		},

        /**
        * Constructor Method
        */
		initialize: function () {
			// Initialize
            this.$modalComponent = this.$('#modal-search-productos-orden-component');
            this.$modalProductShowComponent = this.$('#modal-show-productos-component');
		},

		searchProducto: function (e) {
            e.preventDefault();
            var _this = this;

            // Render template
            this.$modalComponent.find('.content-modal').html(this.template);

            // References
            this.$searchOrdenp = this.$('#search_ordenp');
            this.$searchOrdenpNombre = this.$('#search_ordenp_nombre');
            this.$searchOrdenpEstado = this.$('#search_ordenp_estado');

            this.$productsOrderSearchTable = this.$modalComponent.find('#koi-search-productos-orden-component-table');
            this.$inputContent = this.$("#"+$(e.currentTarget).attr("data-field"));
            this.$inputName = this.$("#"+this.$inputContent.attr("data-name"));
            this.$inputRender = this.$("#"+$(e.currentTarget).attr("data-render"));

			this.productsOrderSearchTable = this.$productsOrderSearchTable.DataTable({
				dom: "<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: {
                    url: window.Misc.urlFull(Route.route('ordenes.productos.index')),
                    data: function (data) {
                    	data.datatables = true;
                        data.search_ordenp = _this.$searchOrdenp.val();
                        data.search_ordenp_estado = _this.$searchOrdenpEstado.val();
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'orden_codigo', name: 'orden_codigo' },
                    { data: 'productop_nombre', name: 'productop_nombre' },
                    { data: 'orden_ano', name: 'orden_ano' },
                    { data: 'orden_numero', name: 'orden_numero' },
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
                        	return '<a href="#" class="a-koi-search-producto-orden-component-table">' + data + '</a>';
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
                            return '<a class="btn btn-default btn-xs a-koi-search-producto-orden-show-component-table" data-resource="' + data + '" data-producto="' + full.orden2_productop + '"><i class="fa fa-search"></i></a>';
                        }
                    }
                ],
                fnRowCallback: function(row, data) {
                    if (parseInt(data.orden_abierta)) {
                        $(row).css({color: "#00a65a"});
                    } else if (parseInt(data.orden_anulada)) {
                        $(row).css({color: "red"});
                    } else if (parseInt(data.orden_culminada)) {
                        $(row).css({color: "#0073b7"});
                    }
                }
			});

            // Modal show
            this.ready();
			this.$modalComponent.modal('show');
		},

		setProducto: function (e) {
			e.preventDefault();
	        var data = this.productsOrderSearchTable.row($(e.currentTarget).parents('tr')).data();

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

		    this.productsOrderSearchTable.ajax.reload();
		},

		clear: function (e) {
			e.preventDefault();

            this.$searchOrdenp.val('');
            this.$searchOrdenpNombre.val('');
            this.$searchOrdenpEstado.val('');

            this.productsOrderSearchTable.ajax.reload();
		},

		ordenpChanged: function (e) {
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
	                url: window.Misc.urlFull(Route.route('ordenes.productos.search')),
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

            var dataFilter = {
                orden2: $(e.currentTarget).attr('data-resource'),
                producto: $(e.currentTarget).attr('data-producto')
            }

            // this.ordenp2Model = new app.Ordenp2Model();
            // this.ordenp2Model.set({id: resource}, {silent: true});
            //
            // if (this.componentProductView instanceof Backbone.View) {
            //     this.componentProductView.stopListening();
            //     this.componentProductView.undelegateEvents();
            // }
            //
            // this.componentProductView = new app.ComponentProductView({
            //     el: '#modal-wrapper-show-productos',
            //     model: this.ordenp2Model,
            //     parameters: {
            //         modal: this.$modalProductShowComponent,
            //         dataFilter: {
            //             orden2: this.model.get('id'),
            //             productop: this.model.get('orden2_productop')
            //         }
            //     }
            // });
            // this.ordenp2Model.fetch();
            //
            // this.$modalProductShowComponent.modal('show');
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
