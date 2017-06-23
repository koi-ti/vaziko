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
        template: _.template( ($('#koi-search-ordenp-component-tpl').html() || '') ),

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
		initialize: function() {
			// Initialize
            this.$modalComponent = this.$('#modal-search-ordenp-component');
		},

		searchOrden: function(e) {
            e.preventDefault();
            var _this = this;

            // Render template
            this.$modalComponent.find('.content-modal').html( this.template({ }) );

            // References
            this.$searchordenpOrden = this.$('#searchordenp_ordenp_numero');
            this.$searchordenpTercero = this.$('#searchordenp_tercero');
            this.$searchordenpTerceroNombre = this.$('#searchordenp_tercero_nombre');

            this.$ordersSearchTable = this.$modalComponent.find('#koi-search-ordenp-component-table');
            this.$inputContent = this.$("#"+$(e.currentTarget).attr("data-field"));
            this.$inputName = this.$("#"+this.$inputContent.attr("data-name"));
            this.$factura = this.$inputContent.attr("data-factura");

			this.ordersSearchTable = this.$ordersSearchTable.DataTable({
				dom: "<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: {
                    url: window.Misc.urlFull( Route.route('ordenes.index') ),
                    data: function( data ) {
                        data.orden_numero = _this.$searchordenpOrden.val();
                        data.orden_tercero_nit = _this.$searchordenpTercero.val();
                    }
                },
                columns: [
                    { data: 'orden_codigo', name: 'orden_codigo' },
                    { data: 'orden_ano', name: 'orden_ano' },
                    { data: 'orden_numero', name: 'orden_numero' },
                    { data: 'tercero_nombre', name: 'tercero_nombre' },
                    { data: 'orden_fecha', name: 'orden_fecha' }
                ],
                order: [
                	[ 1, 'desc' ], [ 2, 'desc' ]
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        searchable: false,
                        render: function ( data, type, full, row ) {
                        	return '<a href="#" class="a-koi-search-ordenp-component-table">' + data + '</a>';
                        }
                    },
                    {
                        targets: [1, 2],
                        visible: false
                    },
                    {
                        targets: 4 ,
                        render: function ( data, type, full, row ) {
                            return window.moment(data).format('YYYY-MM-DD');
                        } 
                    }
                ]

			});

            // Modal show
            this.ready();
			this.$modalComponent.modal('show');
		},

		setOrden: function(e) {
			e.preventDefault();
	        var data = this.ordersSearchTable.row( $(e.currentTarget).parents('tr') ).data();

            this.$inputContent.val( data.orden_codigo );
            this.$inputName.val( data.tercero_nombre );

            if(this.$factura == 'true'){
                this.$inputContent.trigger('change');
            }

			this.$modalComponent.modal('hide');
		},

		search: function(e) {
			e.preventDefault();

		    this.ordersSearchTable.ajax.reload();
		},

		clear: function(e) {
			e.preventDefault();

            this.$searchordenpOrden.val('');
            this.$searchordenpTercero.val('');
            this.$searchordenpTerceroNombre.val('');

            this.ordersSearchTable.ajax.reload();
		},

		ordenpChanged: function(e) {
			var _this = this;

			this.$inputContent = $(e.currentTarget);
			this.$inputName = this.$("#"+$(e.currentTarget).attr("data-name"));
			this.$wraperConten = this.$("#"+$(e.currentTarget).attr("data-wrapper"));

			var orden = this.$inputContent.val();

            // Before eval clear data
            this.$inputName.val('');

			if(!_.isUndefined(orden) && !_.isNull(orden) && orden != '') {
				// Get Orden
	            $.ajax({
	                url: window.Misc.urlFull(Route.route('ordenes.search')),
	                type: 'GET',
	                data: { orden_codigo: orden },
	                beforeSend: function() {
						_this.$inputName.val('');
	                    window.Misc.setSpinner( _this.$wraperConten );
	                }
	            })
	            .done(function(resp) {
	                window.Misc.removeSpinner( _this.$wraperConten );
	                if(resp.success) {
	                    if(!_.isUndefined(resp.tercero_nombre) && !_.isNull(resp.tercero_nombre)){
							_this.$inputName.val(resp.tercero_nombre);
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
