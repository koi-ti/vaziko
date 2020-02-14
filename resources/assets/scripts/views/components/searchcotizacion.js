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
        template: _.template(($('#koi-search-cotizacion-component-tpl').html() || '')),
		events: {
            'click .btn-koi-search-cotizacion-component-table': 'searchCotizacion',
            'click .btn-search-koi-search-cotizacion-component': 'search',
            'click .btn-clear-koi-search-cotizacion-component': 'clear',
            'click .a-koi-search-cotizacion-component-table': 'setCotizacion'
		},

        /**
        * Constructor Method
        */
		initialize: function () {
			// Initialize
            this.$modalComponent = this.$('#modal-search-cotizacion-component');
		},

		searchCotizacion: function (e) {
            e.preventDefault();
            var _this = this;

            // Reference state
            this.state = $(e.currentTarget).attr("data-state");

            // Render template
            this.$modalComponent.find('.content-modal').html(this.template({state: this.state}));

            this.$inputContent = this.$("#" + $(e.currentTarget).attr("data-field"));
            this.$inputName = this.$("#" + this.$inputContent.attr("data-name"));

            // References
            this.$searchCotizacion = this.$('#search_cotizacion_numero');
            this.$searchCotizacionTercero = this.$('#search_cotizacion_tercero');
            this.$searchCotizacionTerceroNombre = this.$('#search_cotizacion_tercero_nombre');

            this.$cotizacionesSearchTable = this.$modalComponent.find('#koi-search-cotizacion-component-table');
			this.cotizacionesSearchTable = this.$cotizacionesSearchTable.DataTable({
				dom: "<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: {
                    url: window.Misc.urlFull(Route.route('search.cotizaciones')),
                    data: function (data) {
                        data.search = true;
                        data.cotizacion_estado = _this.state;
                        data.cotizacion_numero = _this.$searchCotizacion.val();
                        data.cotizacion_tercero_nit = _this.$searchCotizacionTercero.val();
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
                        targets: 0,
                        searchable: false,
                        render: function (data, type, full, row) {
                        	return '<a href="#" class="a-koi-search-cotizacion-component-table">' + data + '</a>';
                        }
                    },
                    {
                        targets: [1, 2],
                        visible: false
                    },
                    {
                        targets: 3,
                        render: function (data, type, full, row) {
                            var estado = window.Misc.stateProduction(full.cotizacion1_estados);
                            return data + ' <span class="label label-' + estado.color + '">' + estado.nombre + '</span>';
                        }
                    },
                    {
                        targets: 4 ,
                        render: function (data, type, full, row) {
                            return window.moment(data).format('YYYY-MM-DD');
                        }
                    }
                ],
                fnRowCallback: function(row, data) {
                    if (parseInt(data.cotizacion1_anulada)) {
                        $(row).css({color: "#DD4B39"});
                    } else if (parseInt(data.cotizacion1_abierta)) {
                        $(row).css({color: "#00A65A"});
                    } else {
                        $(row).css({color: "black"});
                    }
                }
			});

            // Modal show
            this.ready();
			this.$modalComponent.modal('show');
		},

		search: function (e) {
			e.preventDefault();

		    this.cotizacionesSearchTable.ajax.reload();
		},

		clear: function (e) {
			e.preventDefault();

            this.$searchCotizacion.val('');
            this.$searchCotizacionTercero.val('');
            this.$searchCotizacionTerceroNombre.val('');

            this.cotizacionesSearchTable.ajax.reload();
		},

        setCotizacion: function (e) {
            e.preventDefault();
            var data = this.cotizacionesSearchTable.row($(e.currentTarget).parents('tr')).data();

            this.$inputContent.val(data.cotizacion_codigo);
            this.$inputName.val(data.tercero_nombre);

            this.$modalComponent.modal('hide');
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
