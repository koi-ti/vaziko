/* 
 * Class MainfoldersView
 * @author KOI || @dropecamargo
 * @link http://koi-ti.com
 **/

//global app blackbone
app || (app={});

(function ($, window, document, undefined) {
    
    app.MainFoldersView = Backbone.View.extend({
        el: '#folders-main',
        /*
         * Constructor method
         */
        initialize: function () {
            
            this.$foldersSearchTable = this.$('#folders-search-table');
            
            this.$foldersSearchTable.DataTable({
                dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: true,
                languaje: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('folders.index') ),
                columns: [
                    { data: 'folders_codigo', name: 'folders_codigo' },
                    { data: 'folders_nombre', name: 'folders_nombre' }
                ],
                buttons: [
                    {   
                        text: '<i class="fa fa-user-plus"></i> Agregar Folder',
                        className: 'btn-sm',    
                        action: function ( e, dt, node, config ) {
                                window.Misc.redirect(window.Misc.urlFull( Route.route('folders.create') ) )
                        }
                    }
                ],
 //                columnDefs: [
//                    {
//                        targets: 0,
//                        width: '10%',
//                        render: function ( data, type, full, row ) {
//                            return '<a href="'+ window.Misc.urlFull( Route.route('centroscosto.show', {centroscosto: full.id }) )  +'">' + data + '</a>';
//                        }
//                    },
//                    {
//                        targets: 3,
//                        width: '10%',
//                        render: function ( data, type, full, row ) {
//                            return data == 'S' ? 'Si' : 'No';
//                        }
//                    },
//                    {
//                        targets: [4],
//                        width: '10%',
//                        render: function ( data, type, full, row ) {
//                            return data ? 'Si' : 'No';
//                        }
//                    },
//                ]
            });
        }
    });

})(jQuery, this, this.document);
