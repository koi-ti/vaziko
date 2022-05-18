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
            // DataTable
            this.$foldersSearchTable = this.$('#folders-search-table');
            this.$foldersSearchTable.DataTable({
                dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                ajax: window.Misc.urlFull(Route.route('folders.index')),
                columns: [
                    { data: 'folder_codigo', name: 'folder_codigo' },
                    { data: 'folder_nombre', name: 'folder_nombre' }
                ],
                buttons: [
                    {
                        text: '<i class="fa fa-plus"></i> Nuevo',
                        className: 'btn-sm',
                        action: function (e, dt, node, config) {
                            window.Misc.redirect(window.Misc.urlFull(Route.route('folders.create')))
                        }
                    }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '15%',
                        render: function (data, type, full, row) {
                            return '<a href="'+ window.Misc.urlFull(Route.route('folders.show', {folders: full.id}))  +'">' + data + '</a>';
                        }
                    }
                ]
            });
        }
    });

})(jQuery, this, this.document);
