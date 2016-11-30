/**
* Class MainPuntoventaView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainPuntoventaView = Backbone.View.extend({

        el: '#puntosventa-main',

        /**
        * Constructor Method
        */
        initialize : function() {

            this.$puntosventaSearchTable = this.$('#puntosventa-search-table');

            this.$puntosventaSearchTable.DataTable({
				dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('puntosventa.index') ),
                columns: [
                    { data: 'puntoventa_nombre', name: 'puntoventa_nombre' },
                    { data: 'puntoventa_prefijo', name: 'puntoventa_prefijo' },
                    { data: 'puntoventa_resolucion_dian', name: 'puntoventa_resolucion_dian' },
                    { data: 'puntoventa_numero', name: 'puntoventa_numero' }
                ],
				buttons: [
					{
						text: '<i class="fa fa-user-plus"></i> Nuevo punto de venta',
                        className: 'btn-sm',
						action: function ( e, dt, node, config ) {
							window.Misc.redirect( window.Misc.urlFull( Route.route('puntosventa.create') ) )
						}
					}
				],
                columnDefs: [
                    {
                        targets: 0,
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('puntosventa.show', {puntosventa: full.id }) )  +'">' + data + '</a>';
                        }
                    }
                ]
			});
        }
    });

})(jQuery, this, this.document);
