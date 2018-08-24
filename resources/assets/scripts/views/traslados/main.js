/**
* Class MainTrasladosView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainTrasladosView = Backbone.View.extend({

        el: '#traslados-main',

        /**
        * Constructor Method
        */
        initialize : function() {

            this.$trasladosSearchTable = this.$('#traslados-search-table');
            var paginacion = this.$trasladosSearchTable.data('paginacion');

            this.$trasladosSearchTable.DataTable({
				dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                pageLength: paginacion,
                lengthMenu: [[paginacion, 10, 25, 50, 100], [paginacion, 10, 25, 50, 100]],
                ajax: window.Misc.urlFull( Route.route('traslados.index') ),
                columns: [
                    { data: 'traslado1_numero', name: 'koi_traslado1.traslado1_numero' },
                    { data: 'sucursa_origen', name: 'o.sucursal_nombre' },
                    { data: 'sucursa_destino', name: 'd.sucursal_nombre' },
                    { data: 'traslado1_fecha', name: 'koi_traslado1.traslado1_fecha' }
                ],
				buttons: [
					{
						text: '<i class="fa fa-plus"></i> Nuevo traslado',
                        className: 'btn-sm',
						action: function ( e, dt, node, config ) {
							window.Misc.redirect( window.Misc.urlFull( Route.route('traslados.create') ) )
						}
					}
				],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('traslados.show', {traslados: full.id }) )  +'">' + data + '</a>';
                        }
                    }
                ]
			});
        }
    });

})(jQuery, this, this.document);
