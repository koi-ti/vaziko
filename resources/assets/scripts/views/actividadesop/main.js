/**
* Class MainActividadesOpView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainActividadesOpView = Backbone.View.extend({

        el: '#actividadesop-main',

        /**
        * Constructor Method
        */
        initialize : function() {

            this.$actividadesopSearchTable = this.$('#actividadesop-search-table');

            this.$actividadesopSearchTable.DataTable({
				dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: true,
                language: window.Misc.dataTableES(),
                ajax: {
                    url: window.Misc.urlFull( Route.route('actividadesop.index') ),
                    data: function( data ) {
                        data.datatables = true;
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'actividadop_nombre', name: 'actividadop_nombre'},
                    { data: 'actividadop_activo', name: 'actividadop_activo' }
                ],
                buttons: [
                    {
                        text: '<i class="fa fa-user-plus"></i> Nueva actividad',
                        className: 'btn-sm',
                        action: function ( e, dt, node, config ) {
                                window.Misc.redirect( window.Misc.urlFull( Route.route('actividadesop.create') ) )
                        }
                    }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('actividadesop.show', {actividadesop: full.id }) )  +'">' + data + '</a>';
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
