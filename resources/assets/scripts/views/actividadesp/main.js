/**
* Class MainActividadespView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainActividadespView = Backbone.View.extend({

        el: '#actividadesp-main',

        /**
        * Constructor Method
        */
        initialize : function() {

            this.$actividadespSearchTable = this.$('#actividadesp-search-table');
            paginacion = this.$actividadespSearchTable.data('paginacion');

            this.$actividadespSearchTable.DataTable({
				dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: true,
                language: window.Misc.dataTableES(),
                pageLength: paginacion,
                lengthMenu: [[paginacion, 10, 25, 50, 100], [paginacion, 10, 25, 50, 100]],
                ajax: {
                    url: window.Misc.urlFull( Route.route('actividadesp.index') ),
                    data: function( data ) {
                        data.datatables = true;
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'actividadp_nombre', name: 'actividadp_nombre'},
                    { data: 'actividadp_activo', name: 'actividadp_activo' }
                ],
                buttons: [
                    {
                        text: '<i class="fa fa-plus"></i> Nueva actividad',
                        className: 'btn-sm',
                        action: function ( e, dt, node, config ) {
                                window.Misc.redirect( window.Misc.urlFull( Route.route('actividadesp.create') ) )
                        }
                    }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('actividadesp.show', {actividadesp: full.id }) )  +'">' + data + '</a>';
                        }
                    },
                    {
                        targets: 2,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return parseInt(data) ? 'Si' : 'No';
                        }
                    }
                ]
			});
        }
    });

})(jQuery, this, this.document);
