/**
* Class ComponentSearchFacturaView of Backbone
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ComponentSearchFacturaView = Backbone.View.extend({

      	el: 'body',
        template: _.template( ($('#koi-search-factura-component-tpl').html() || '') ),

		events: {
			'change input.factura-koi-component': 'facturaChanged',
            'click .btn-koi-search-factura-component-table': 'searchFactura',
            'click .btn-search-koi-search-factura-component': 'search',
            'click .btn-clear-koi-search-factura-component': 'clear',
            'click .a-koi-search-factura-component-table': 'setFactura'
		},

        /**
        * Constructor Method
        */
		initialize: function() {
			// Initialize
            this.$modalComponent = this.$('#modal-search-factura-component');
		},

		searchFactura: function(e) {
            e.preventDefault();
            var _this = this;

            // Render template
            this.$modalComponent.find('.content-modal').html( this.template({ }) );

            // References
            this.$searchfacturaNumero = this.$('#searchfactura_numero');
            this.$searchfacturaOrdenp = this.$('#searchfactura_ordenp');
            this.$searchfacturaOrdenpBeneficiario = this.$('#searchfactura_ordenp_beneficiario');
            this.$searchfacturaTercero = this.$('#searchfactura_tercero');
            this.$searchfacturaTerceroNombre = this.$('#searchfactura_tercero_nombre');

            this.$facturaSearchTable = this.$modalComponent.find('#koi-search-factura-component-table');
            this.$inputContent = this.$("#"+$(e.currentTarget).attr("data-field"));
            this.$inputName = this.$("#"+this.$inputContent.attr("data-name"));
            this.$factura = this.$inputContent.attr("data-factura");

			this.facturaSearchTable = this.$facturaSearchTable.DataTable({
				dom: "<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: {
                    url: window.Misc.urlFull( Route.route('facturas.index') ),
                    data: function( data ) {
                        data.id = _this.$searchfacturaNumero.val();
                        data.orden_codigo = _this.$searchfacturaOrdenp.val();
                        data.tercero_nit = _this.$searchfacturaTercero.val();
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'orden_codigo', name: 'orden_codigo' },
                    { data: 'tercero_nombre', name: 'tercero_nombre' },
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        searchable: false,
                        render: function ( data, type, full, row ) {
                        	return '<a href="#" class="a-koi-search-factura-component-table">' + data + '</a>';
                        }
                    }
                ]

			});

            // Modal show
            this.ready();
			this.$modalComponent.modal('show');
		},

		setFactura: function(e) {
			e.preventDefault();
	        var data = this.facturaSearchTable.row( $(e.currentTarget).parents('tr') ).data();

            this.$inputContent.val( data.id );
            this.$inputName.val( data.tercero_nombre );

			if(this.$factura == 'true'){
                this.$inputContent.trigger('change'); 
            }

			this.$modalComponent.modal('hide');
		},

		search: function(e) {
			e.preventDefault();

		    this.facturaSearchTable.ajax.reload();
		},

		clear: function(e) {
			e.preventDefault();

            this.$searchfacturaNumero.val('');
            this.$searchfacturaOrdenp.val('');
            this.$searchfacturaOrdenpBeneficiario.val('');
            this.$searchfacturaTercero.val('');
            this.$searchfacturaTerceroNombre.val('');

            this.facturaSearchTable.ajax.reload();
		},

		facturaChanged: function(e) {
			var _this = this;

			this.$inputContent = $(e.currentTarget);
			this.$inputName = this.$("#"+$(e.currentTarget).attr("data-name"));
			this.$wraperConten = this.$("#"+$(e.currentTarget).attr("data-wrapper"));

			var factura = this.$inputContent.val();

            // Before eval clear data
            this.$inputName.val('');

			if(!_.isUndefined(factura) && !_.isNull(factura) && factura != '') {
				// Get Factura
	            $.ajax({
	                url: window.Misc.urlFull(Route.route('facturas.search')),
	                type: 'GET',
	                data: { factura_numero: factura },
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
