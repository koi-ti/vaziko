/**
* Class MainSubActividadespView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainSubActividadespView = Backbone.View.extend({

        el: '#subactividadesp-main',

        /**
        * Constructor Method
        */
        initialize: function () {
            // DataTable
            this.$subactividadespSearchTable = this.$('#subactividadesp-search-table');
            this.$subactividadespSearchTable.DataTable({
				dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                ajax: window.Misc.urlFull(Route.route('subactividadesp.index')),
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'actividadp_nombre', name: 'koi_actividadp.actividadp_nombre'},
                    { data: 'subactividadp_nombre', name: 'subactividadp_nombre'},
                    { data: 'subactividadp_activo', name: 'subactividadp_activo' }
                ],
                buttons: [
                    {
                        text: '<i class="fa fa-plus"></i> Nuevo',
                        className: 'btn-sm',
                        action: function (e, dt, node, config) {
                            window.Misc.redirect(window.Misc.urlFull(Route.route('subactividadesp.create')))
                        }
                    }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function (data, type, full, row) {
                            return '<a href="'+ window.Misc.urlFull(Route.route('subactividadesp.show', {subactividadesp: full.id})) + '">' + data + '</a>';
                        }
                    },
                    {
                        targets: 3,
                        width: '10%',
                        render: function (data, type, full, row) {
                            return parseInt(data) ? 'Si' : 'No';
                        }
                    }
                ]
			});
        }
    });

})(jQuery, this, this.document);
