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

            this.$trasladosSearchTable.DataTable({
				dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('traslados.index') ),
                columns: [
                    { data: 'traslado1_numero', name: 'traslado1_numero' },
                    { data: 'sucursa_origen', name: 'sucursa_origen' },
                    { data: 'sucursa_destino', name: 'sucursa_destino' },
                    { data: 'traslado1_fecha', name: 'traslado1_fecha' }
                ],
				buttons: [
					{
						text: '<i class="fa fa-user-plus"></i> Nuevo traslado',
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
