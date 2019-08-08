/**
 * Class MainDocumentosView
 * @author KOI || @dropecamargo
 * @link http://koi-ti.com
 */

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainDocumentosView = Backbone.View.extend({

        el: '#documentos-main',
        /**
         * Constructor Method
         */
        initialize: function () {

            this.$documentosSearchTable = this.$('#documentos-search-table');
            var paginacion = this.$documentosSearchTable.data('paginacion');

            this.$documentosSearchTable.DataTable({
                dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                pageLength: paginacion,
                lengthMenu: [[paginacion, 10, 25, 50, 100], [paginacion, 10, 25, 50, 100]],
                ajax: window.Misc.urlFull(Route.route('documentos.index')),
                columns: [
                    { data: 'documento_codigo', name: 'documento_codigo' },
                    { data: 'documento_nombre', name: 'documento_nombre' },
                    { data: 'folder_codigo', name: 'koi_folder.folder_codigo' },
                    { data: 'documento_actual', name: 'documento_actual' },
                    { data: 'documento_nif', name: 'documento_nif' }
                ],
                buttons: [
                    {
                        text: '<i class="fa fa-plus"></i> Nuevo',
                        className: 'btn-sm',
                        action: function (e, dt, node, config) {
                            window.Misc.redirect(window.Misc.urlFull(Route.route('documentos.create')))
                        }
                    }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '7%',
                        render: function (data, type, full, row) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('documentos.show', {documentos: full.id}))  +'">' + data + '</a>';
                        }
                    },
                    {
                        targets: 1,
                        width: '63%'
                    },
                    {
                        targets: 2,
                        width: '10%',
                        render: function (data, type, full, row) {
                            if (!_.isNull(full.folder_codigo) && !_.isUndefined(full.folder_codigo)) {
                                return '<a href="'+ window.Misc.urlFull( Route.route('folders.show', {folders: full.folder_id }) )  +'">' + data + '</a>';
                            }
                            return '';
                        }
                    },
                    {
                        targets: 3,
                        width: '10%',
                        render: function (data, type, full, row) {
                            return parseInt(data) ? 'Si' : 'No';
                        }
                    },
                    {
                        targets: 4,
                        width: '10%',
                        render: function (data, type, full, row) {
                            return parseInt(data) ? 'Si' : 'No';
                        }
                    },
                ]
            });
        }
    });

})(jQuery, this, this.document);
