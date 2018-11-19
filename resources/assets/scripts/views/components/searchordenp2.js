    /**
* Class ComponentSearchOrdenP2View of Backbone
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ComponentSearchOrdenP2View = Backbone.View.extend({

      	el: 'body',
        template: _.template( ($('#koi-search-ordenp2-component-tpl').html() || '') ),
		events: {
			'change input.ordenp2-koi-component': 'ordenpChanged',
            'click .btn-koi-search-orden2-component-table': 'searchOrden',
            'click .btn-search-koi-search-ordenp2-component': 'search',
            'click .btn-clear-koi-search-ordenp2-component': 'clear',
            'click .a-koi-search-ordenp2-component-table': 'setOrden'
		},

        /**
        * Constructor Method
        */
		initialize: function() {
			// Initialize
            this.$modalComponent = this.$('#modal-search-ordenp2-component');
		},

		searchOrden: function(e) {
            e.preventDefault();
            var _this = this;

            // Render template
            this.$modalComponent.find('.content-modal').html( this.template({ }) );

            // References
            this.$searchOrdenp = this.$('#search_ordenp');
            this.$searchOrdenpNombre = this.$('#search_ordenpnombre');
            this.$searchordenpEstado = this.$('#searchordenp_ordenp_estado');

            this.$ordersSearchTable = this.$modalComponent.find('#koi-search-ordenp2-component-table');
            this.$inputContent = this.$("#"+$(e.currentTarget).attr("data-field"));
            this.$inputName = this.$("#"+this.$inputContent.attr("data-name"));

            // Validate tercero
            var tercero = this.$inputContent.attr("data-tercero");
            if( _.isUndefined(tercero) || _.isNull(tercero) || tercero == '') {
                alertify.error('Por favor ingrese cliente antes agregar una orden.');
                return;
            }

			this.ordersSearchTable = this.$ordersSearchTable.DataTable({
				dom: "<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: {
                    url: window.Misc.urlFull( Route.route('ordenes.productos.index') ),
                    data: function( data ) {
                    	data.datatables = true;
                        data.search_ordenp = _this.$searchOrdenp.val();
                        data.search_ordenpnombre = _this.$searchOrdenpNombre.val();
                        data.search_ordenpestado = _this.$searchordenpEstado.val();
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'orden_codigo', name: 'orden_codigo' },
                    { data: 'orden_ano', name: 'orden_ano' },
                    { data: 'orden_numero', name: 'orden_numero' },
                    { data: 'productop_nombre', name: 'productop_nombre' },
                    { data: 'orden2_cantidad', name: 'orden2_cantidad' },
                    { data: 'orden2_facturado', name: 'orden2_facturado' },
                ],
                order: [
                	[ 2, 'desc' ], [ 3, 'desc' ]
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        searchable: false,
                        render: function ( data, type, full, row ) {
                        	return '<a href="#" class="a-koi-search-ordenp2-component-table">' + data + '</a>';
                        }
                    },
                    {
                        targets: [2, 3],
                        visible: false,
                    }
                ],
                fnRowCallback: function( row, data ) {
                    if ( parseInt(data.orden_abierta) ) {
                        $(row).css( {"color":"#00a65a"} );
                    }else if ( parseInt(data.orden_anulada) ) {
                        $(row).css( {"color":"red"} );
                    }else if ( parseInt(data.orden_culminada) ) {
                        $(row).css( {"color":"#0073b7"} );
                    }
                }
			});

            // Modal show
            this.ready();
			this.$modalComponent.modal('show');
		},

		setOrden: function(e) {
			e.preventDefault();
	        var data = this.ordersSearchTable.row( $(e.currentTarget).parents('tr') ).data();

            this.$inputContent.val( data.id );
            this.$inputName.val( data.productop_nombre );

			this.$modalComponent.modal('hide');
		},

		search: function(e) {
			e.preventDefault();

		    this.ordersSearchTable.ajax.reload();
		},

		clear: function(e) {
			e.preventDefault();

            this.$searchOrdenp.val('');
            this.$searchOrdenpNombre.val('');
            this.$searchordenpEstado.val('');

            this.ordersSearchTable.ajax.reload();
		},

		ordenpChanged: function(e) {
			var _this = this;

			this.$inputContent = $(e.currentTarget);
			this.$inputName = this.$("#"+$(e.currentTarget).attr("data-name"));
			this.$wraperConten = this.$("#"+$(e.currentTarget).attr("data-wrapper"));

			var ordenp2 = this.$inputContent.val();

            // Validate tercero
            var tercero = this.$inputContent.attr("data-tercero");
            if( _.isUndefined(tercero) || _.isNull(tercero) || tercero == '') {
                alertify.error('Por favor ingrese cliente antes agregar una orden.');
                return;
            }

            // Before eval clear data
            this.$inputName.val('');

			if(!_.isUndefined(ordenp2) && !_.isNull(ordenp2) && ordenp2 != '') {
				// Get Orden
	            $.ajax({
	                url: window.Misc.urlFull(Route.route('ordenes.productos.search')),
	                type: 'GET',
	                data: {
                        ordenp2: ordenp2
                    },
	                beforeSend: function() {
						_this.$inputName.val('');
	                    window.Misc.setSpinner( _this.$wraperConten );
	                }
	            })
	            .done(function(resp) {
	                window.Misc.removeSpinner( _this.$wraperConten );
	                if(resp.success) {
	                    if(!_.isUndefined(resp.productop_nombre) && !_.isNull(resp.productop_nombre)){
							_this.$inputName.val(resp.productop_nombre);
	                    }
	                }
	            })
	            .fail(function(jqXHR, ajaxOptions, thrownError) {
	                window.Misc.removeSpinner( _this.$wraperConten );
	                alertify.error(thrownError);
	            });
	     	}
		},

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();
        }
    });


})(jQuery, this, this.document);
