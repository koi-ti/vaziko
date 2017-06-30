/**
* Class MainTiposMaterialpView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainTiposMaterialpView = Backbone.View.extend({

        el: '#tiposmaterialp-main',

        /**
        * Constructor Method
        */
        initialize : function() {

            this.$tiposmaterialpSearchTable = this.$('#tiposmaterialp-search-table');

            this.$tiposmaterialpSearchTable.DataTable({
				dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('tiposmaterialp.index') ),
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'tipomaterial_nombre', name: 'tipomaterial_nombre' },
                    { data: 'tipomaterial_activo', name: 'tipomaterial_activo' },
                ],
				buttons: [
					{
						text: '<i class="fa fa-plus"></i> Nueva tipo',
                        className: 'btn-sm',
						action: function ( e, dt, node, config ) {
							window.Misc.redirect( window.Misc.urlFull( Route.route('tiposmaterialp.create') ) )
						}
					}
				],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('tiposmaterialp.show', {tiposmaterialp: full.id }) )  +'">' + data + '</a>';
                        }
                    },
                    {
                        targets: [2],
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return data ? 'Si' : 'No';
                        }
                    },
                ]
			});
        }
    });

})(jQuery, this, this.document);
