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
            
            this.$documentosSearchTable.DataTable({
                dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('documentos.index') ),
                columns: [
                    { data: 'documento_codigo', name: 'documento_codigo' },
                    { data: 'documento_nombre', name: 'documento_nombre' }
                ],
                buttons: [
                    { 
                        text: '<i class="fa fa-user-plus"></i> Nuevo documento', 
                        className: 'btn-sm',
                        action: function ( e, dt, node, config ) {
                                window.Misc.redirect( window.Misc.urlFull( Route.route('documentos.create') ) )
                        }
                    }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '15%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('documentos.show', {documentos: full.id }) )  +'">' + data + '</a>';
                        }
                    }
                ]
            });
        }
    });

})(jQuery, this, this.document);
