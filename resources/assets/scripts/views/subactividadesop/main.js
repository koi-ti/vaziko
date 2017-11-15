/**
* Class MainSubActividadesOpView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainSubActividadesOpView = Backbone.View.extend({

        el: '#subactividadesop-main',

        /**
        * Constructor Method
        */
        initialize : function() {

            this.$subactividadesopSearchTable = this.$('#subactividadesop-search-table');

            this.$subactividadesopSearchTable.DataTable({
				dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: true,
                language: window.Misc.dataTableES(),
                ajax: {
                    url: window.Misc.urlFull( Route.route('subactividadesop.index') ),
                    data: function( data ) {
                        data.datatables = true;
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'actividadop_nombre', name: 'actividadop_nombre'},
                    { data: 'subactividadop_nombre', name: 'subactividadop_nombre'},
                    { data: 'subactividadop_activo', name: 'subactividadop_activo' }
                ],
                buttons: [
                    {
                        text: '<i class="fa fa-user-plus"></i> Nueva Subactividad',
                        className: 'btn-sm',
                        action: function ( e, dt, node, config ) {
                                window.Misc.redirect( window.Misc.urlFull( Route.route('subactividadesop.create') ) )
                        }
                    }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('subactividadesop.show', {subactividadesop: full.id }) )  +'">' + data + '</a>';
                        }
                    },
                    {
                        targets: 3,
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
