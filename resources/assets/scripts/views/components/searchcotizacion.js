/**
* Class ComponentSearchCotizacionView of Backbone
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ComponentSearchCotizacionView = Backbone.View.extend({

      	el: 'body',
        template: _.template( ($('#koi-search-cotizacion-component-tpl').html() || '') ),
		events: {
            'click .btn-koi-search-cotizacion-component-table': 'searchCotizacion',
            'click .btn-search-koi-search-cotizacion-component': 'search',
            'click .btn-clear-koi-search-cotizacion-component': 'clear',
		},

        /**
        * Constructor Method
        */
		initialize: function() {
			// Initialize
            this.$modalComponent = this.$('#modal-search-cotizacion-component');
		},

		searchCotizacion: function(e) {
            e.preventDefault();
            var _this = this;

            // Render template
            this.$modalComponent.find('.content-modal').html( this.template({ }) );

            // References
            this.$searchcotizacionCotizacion = this.$('#searchcotizacion_cotizacion_numero');
            this.$searchcotizacionTercero = this.$('#searchcotizacion_tercero');
            this.$searchcotizacionTerceroNombre = this.$('#searchcotizacion_tercero_nombre');
            this.$cotizacionSearchTable = this.$modalComponent.find('#koi-search-cotizacion-component-table');

			this.cotizacionSearchTable = this.$cotizacionSearchTable.DataTable({
				dom: "<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: {
                    url: window.Misc.urlFull( Route.route('cotizaciones.index') ),
                    data: function( data ) {
                        data.cotizacion_numero = _this.$searchcotizacionCotizacion.val();
                        data.cotizacion_tercero_nit = _this.$searchcotizacionTercero.val();
                    }
                },
                columns: [
                    { data: 'cotizacion_codigo', name: 'cotizacion_codigo' },
                    { data: 'cotizacion1_ano', name: 'cotizacion1_ano' },
                    { data: 'cotizacion1_numero', name: 'cotizacion1_numero' },
                    { data: 'tercero_nombre', name: 'tercero_nombre' },
                    { data: 'cotizacion1_fecha', name: 'cotizacion1_fecha' }
                ],
                order: [
                	[ 1, 'desc' ], [ 2, 'desc' ]
                ],
                columnDefs: [
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

		search: function(e) {
			e.preventDefault();

		    this.cotizacionSearchTable.ajax.reload();
		},

		clear: function(e) {
			e.preventDefault();

            this.$searchcotizacionCotizacion.val('');
            this.$searchcotizacionTercero.val('');
            this.$searchcotizacionTerceroNombre.val('');

            this.cotizacionSearchTable.ajax.reload();
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
