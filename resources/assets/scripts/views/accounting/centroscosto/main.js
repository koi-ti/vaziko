/**
* Class MainCentrosCostoView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainCentrosCostoView = Backbone.View.extend({

        el: '#centroscosto-main',

        /**
        * Constructor Method
        */
        initialize: function () {

            this.$centroscostoSearchTable = this.$('#centroscosto-search-table');
            var paginacion = this.$centroscostoSearchTable.data('pagination');

            this.$centroscostoSearchTable.DataTable({
				dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                pageLength: paginacion,
                lengthMenu: [[paginacion, 10, 25, 50, 100], [paginacion, 10, 25, 50, 100]],
                ajax: window.Misc.urlFull(Route.route('centroscosto.index')),
                columns: [
                    { data: 'centrocosto_codigo', name: 'centrocosto_codigo' },
                    { data: 'centrocosto_centro', name: 'centrocosto_centro' },
                    { data: 'centrocosto_nombre', name: 'centrocosto_nombre' },
                    { data: 'centrocosto_estructura', name: 'centrocosto_estructura' },
                    { data: 'centrocosto_activo', name: 'centrocosto_activo' }
                ],
				buttons: [
					{
						text: '<i class="fa fa-plus"></i> Nuevo',
                        className: 'btn-sm',
						action: function (e, dt, node, config) {
							window.Misc.redirect(window.Misc.urlFull(Route.route('centroscosto.create')))
						}
					}
				],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function (data, type, full, row) {
                            return '<a href="'+ window.Misc.urlFull(Route.route('centroscosto.show', {centroscosto: full.id}))  +'">' + data + '</a>';
                        }
                    },
                    {
                        targets: 3,
                        width: '10%',
                        render: function (data, type, full, row) {
                            return data == 'S' ? 'Si' : 'No';
                        }
                    },
                    {
                        targets: 4,
                        width: '10%',
                        render: function (data, type, full, row) {
                            return parseInt(data) ? 'Si' : 'No';
                        }
                    },
                ]
			});
        }
    });

})(jQuery, this, this.document);
