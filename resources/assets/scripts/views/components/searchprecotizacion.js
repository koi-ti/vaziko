/**
* Class ComponentSearchPreCotizacionView of Backbone
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ComponentSearchPreCotizacionView = Backbone.View.extend({

      	el: 'body',
        template: _.template(($('#koi-search-precotizacion-component-tpl').html() || '')),
		events: {
            'click .btn-koi-search-precotizacion-component-table': 'searchCotizacion',
            'click .btn-search-koi-search-precotizacion-component': 'search',
            'click .btn-clear-koi-search-precotizacion-component': 'clear',
            'click .a-koi-search-precotizacion-component-table': 'setCotizacion'
		},

        /**
        * Constructor Method
        */
		initialize: function () {
			// Initialize
            this.$modalComponent = this.$('#modal-search-precotizacion-component');
		},

		searchCotizacion: function (e) {
            e.preventDefault();
            var _this = this;

            // Render template
            this.$modalComponent.find('.content-modal').html(this.template);

            this.$inputContent = this.$("#"+$(e.currentTarget).attr("data-field"));
            this.$inputName = this.$("#"+this.$inputContent.attr("data-name"));

            // References
            this.$searchPreCotizacion = this.$('#search_precotizacion_numero');
            this.$searchPreCotizacionTercero = this.$('#search_precotizacion_tercero');
            this.$searchPreCotizacionTerceroNombre = this.$('#search_precotizacion_tercero_nombre');

            this.$precotizacionesSearchTable = this.$modalComponent.find('#koi-search-precotizacion-component-table');
			this.precotizacionesSearchTable = this.$precotizacionesSearchTable.DataTable({
				dom: "<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: {
                    url: window.Misc.urlFull(Route.route('precotizaciones.index')),
                    data: function (data) {
                        data.precotizacion_numero = _this.$searchPreCotizacion.val();
                        data.precotizacion_tercero_nit = _this.$searchPreCotizacionTercero.val();
                    }
                },
                columns: [
                    { data: 'precotizacion_codigo', name: 'precotizacion_codigo' },
                    { data: 'precotizacion1_ano', name: 'precotizacion1_ano' },
                    { data: 'precotizacion1_numero', name: 'precotizacion1_numero' },
                    { data: 'tercero_nombre', name: 'tercero_nombre' },
                    { data: 'precotizacion1_fecha', name: 'precotizacion1_fecha' },
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
                        	return '<a href="#" class="a-koi-search-precotizacion-component-table">' + data + '</a>';
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
                            if (parseInt(full.precotizacion1_culminada)) {
                                return '<span class="label label-primary">CULMINADA</span>';
                            } else if (parseInt(full.precotizacion1_abierta)) {
                                return '<span class="label label-success">ABIERTA</span>';
                            } else {
                                return '<span class="label label-danger">CERRADA</span>';
                            }
                        }
                    }
                ],
                fnRowCallback: function (row, data) {
                    if (parseInt(data.precotizacion1_culminada)) {
                        $(row).css({color: "#3C8DBC"});
                    } else if (parseInt(data.precotizacion1_abierta)) {
                        $(row).css({color: "#00A65A"});
                    } else {
                        $(row).css({color: "#DD4B39"});
                    }
                }
			});

            // Modal show
            this.ready();
			this.$modalComponent.modal('show');
		},

		search: function (e) {
			e.preventDefault();

		    this.precotizacionesSearchTable.ajax.reload();
		},

		clear: function (e) {
			e.preventDefault();

            this.$searchPreCotizacion.val('');
            this.$searchPreCotizacionTercero.val('');
            this.$searchPreCotizacionTerceroNombre.val('');

            this.precotizacionesSearchTable.ajax.reload();
		},

        setCotizacion: function (e) {
            e.preventDefault();
            var data = this.precotizacionesSearchTable.row($(e.currentTarget).parents('tr')).data();

            this.$inputContent.val(data.precotizacion_codigo);
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
