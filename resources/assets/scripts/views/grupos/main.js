/**
* Class MainGruposView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainGruposView = Backbone.View.extend({

        el: '#grupos-main',

        /**
        * Constructor Method
        */
        initialize : function() {

            this.$gruposSearchTable = this.$('#grupos-search-table');

            this.$gruposSearchTable.DataTable({
				dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('grupos.index') ),
                columns: [
                    { data: 'grupo_codigo', name: 'grupo_codigo' },
                    { data: 'grupo_nombre', name: 'grupo_nombre' }
                ],
				buttons: [
					{
						text: '<i class="fa fa-user-plus"></i> Nuevo grupo',
                        className: 'btn-sm',
						action: function ( e, dt, node, config ) {
							window.Misc.redirect( window.Misc.urlFull( Route.route('grupos.create') ) )
						}
					}
				],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('grupos.show', {grupos: full.id }) )  +'">' + data + '</a>';
                        }
                    }
                ]
			});
        }
    });

})(jQuery, this, this.document);