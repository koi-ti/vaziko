/**
* Class MainAcabadospView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainAcabadospView = Backbone.View.extend({

        el: '#acabadosp-main',

        /**
        * Constructor Method
        */
        initialize : function() {

            this.$acabadospSearchTable = this.$('#acabadosp-search-table');
            var paginacion = this.$acabadospSearchTable.data('paginacion');

            this.$acabadospSearchTable.DataTable({
				dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
            	pageLength: paginacion,
                lengthMenu: [[paginacion, 10, 25, 50, 100], [paginacion, 10, 25, 50, 100]],
                ajax: window.Misc.urlFull( Route.route('acabadosp.index') ),
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'acabadop_nombre', name: 'acabadop_nombre' },
                    { data: 'acabadop_descripcion', name: 'acabadop_descripcion' }
                ],
				buttons: [
					{
						text: '<i class="fa fa-plus"></i> Nuevo acabado',
                        className: 'btn-sm',
						action: function ( e, dt, node, config ) {
							window.Misc.redirect( window.Misc.urlFull( Route.route('acabadosp.create') ) )
						}
					}
				],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('acabadosp.show', {acabadosp: full.id }) )  +'">' + data + '</a>';
                        }
                    }
                ]
			});
        }
    });

})(jQuery, this, this.document);
