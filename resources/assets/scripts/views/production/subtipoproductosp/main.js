/**
* Class MainSubtipoProductospView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainSubtipoProductospView = Backbone.View.extend({

        el: '#subtipoproductosp-main',

        /**
        * Constructor Method
        */
        initialize: function () {

            this.$subtipoproductospSearchTable = this.$('#subtipoproductosp-search-table');
            var paginacion = this.$subtipoproductospSearchTable.data('pagination');

            this.$subtipoproductospSearchTable.DataTable({
				dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
            	pageLength: paginacion,
                lengthMenu: [[paginacion, 10, 25, 50, 100], [paginacion, 10, 25, 50, 100]],
                ajax: {
                    url: window.Misc.urlFull(Route.route('subtipoproductosp.index')),
                    data: function (data) {
                        data.datatables = true;
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'subtipoproductop_nombre', name: 'subtipoproductop_nombre' },
                    { data: 'tipoproductop_nombre', name: 'koi_tipoproductop.tipoproductop_nombre' },
                    { data: 'subtipoproductop_activo', name: 'subtipoproductop_activo' },
                ],
				buttons: [
					{
						text: '<i class="fa fa-plus"></i> Nuevo',
                        className: 'btn-sm',
						action: function (e, dt, node, config) {
							window.Misc.redirect(window.Misc.urlFull(Route.route('subtipoproductosp.create')))
						}
					}
				],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function (data, type, full, row) {
                            return '<a href="'+ window.Misc.urlFull(Route.route('subtipoproductosp.show', {subtipoproductosp: full.id})) + '">' + data + '</a>';
                        }
                    },
                    {
                        targets: [3],
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
