/**
* Class MainSucursalesView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainSucursalesView = Backbone.View.extend({

        el: '#sucursales-main',

        /**
        * Constructor Method
        */
        initialize: function () {

            this.$sucursalesSearchTable = this.$('#sucursales-search-table');
            var paginacion = this.$sucursalesSearchTable.data('paginacion');

            this.$sucursalesSearchTable.DataTable({
				dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                pageLength: paginacion,
                lengthMenu: [[paginacion, 10, 25, 50, 100], [paginacion, 10, 25, 50, 100]],
                ajax: window.Misc.urlFull(Route.route('sucursales.index')),
                columns: [
                    { data: 'sucursal_nombre', name: 'sucursal_nombre' }
                ],
				buttons: [
					{
						text: '<i class="fa fa-plus"></i> Nueva',
                        className: 'btn-sm',
						action: function ( e, dt, node, config ) {
							window.Misc.redirect(window.Misc.urlFull(Route.route('sucursales.create')))
						}
					}
				],
                columnDefs: [
                    {
                        targets: 0,
                        render: function (data, type, full, row) {
                            return '<a href="'+ window.Misc.urlFull(Route.route('sucursales.show', {sucursales: full.id }))  +'">' + data + '</a>';
                        }
                    }
                ]
			});
        }
    });

})(jQuery, this, this.document);
