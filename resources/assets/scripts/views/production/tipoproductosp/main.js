/**
* Class MainTipoProductospView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainTipoProductospView = Backbone.View.extend({

        el: '#tipoproductosp-main',

        /**
        * Constructor Method
        */
        initialize: function () {

            this.$tipoproductospSearchTable = this.$('#tipoproductosp-search-table');
            var paginacion = this.$tipoproductospSearchTable.data('pagination');

            this.$tipoproductospSearchTable.DataTable({
				dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
            	pageLength: paginacion,
                lengthMenu: [[paginacion, 10, 25, 50, 100], [paginacion, 10, 25, 50, 100]],
                ajax: window.Misc.urlFull( Route.route('tipoproductosp.index') ),
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'tipoproductop_nombre', name: 'tipoproductop_nombre' },
                    { data: 'tipoproductop_activo', name: 'tipoproductop_activo' },
                ],
				buttons: [
					{
						text: '<i class="fa fa-plus"></i> Nuevo tipo de producto',
                        className: 'btn-sm',
						action: function ( e, dt, node, config ) {
							window.Misc.redirect( window.Misc.urlFull( Route.route('tipoproductosp.create') ) )
						}
					}
				],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('tipoproductosp.show', {tipoproductosp: full.id }) )  +'">' + data + '</a>';
                        }
                    },
                    {
                        targets: [2],
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return parseInt(data) ? 'Si' : 'No';
                        }
                    },
                ]
			});
        }
    });

})(jQuery, this, this.document);
