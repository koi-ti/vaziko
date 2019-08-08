/**
* Class MainTerceroView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainTerceroView = Backbone.View.extend({

        el: '#terceros-main',
        events: {
            'click .btn-search': 'search',
            'click .btn-clear': 'clear'
        },

        /**
        * Constructor Method
        */
        initialize: function () {
            var _this = this;

            // Rerefences
            this.$tercerosSearchTable = this.$('#terceros-search-table');
            this.$searchNit = this.$('#tercero_nit');
            this.$searchName = this.$('#tercero_nombre');
            var paginacion = this.$tercerosSearchTable.data('paginacion');

            this.tercerosSearchTable = this.$tercerosSearchTable.DataTable({
				dom: "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                pageLength: paginacion,
                ajax: {
                    url: window.Misc.urlFull(Route.route('terceros.index')),
                    data: function (data) {
                        data.persistent = true;
                        data.tercero_nit = _this.$searchNit.val();
                        data.tercero_nombre = _this.$searchName.val();
                    }
                },
                columns: [
                    { data: 'tercero_nit', name: 'tercero_nit' },
                    { data: 'tercero_nombre', name: 'tercero_nombre' },
                    { data: 'tercero_razonsocial', name: 'tercero_razonsocial'},
                    { data: 'tercero_nombre1', name: 'tercero_nombre1' },
                    { data: 'tercero_nombre2', name: 'tercero_nombre2' },
                    { data: 'tercero_apellido1', name: 'tercero_apellido1' },
                    { data: 'tercero_apellido2', name: 'tercero_apellido2' }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '15%',
                        render: function (data, type, full, row) {
                            return '<a href="'+ window.Misc.urlFull(Route.route('terceros.show', {terceros: full.id }))  +'">' + data + '</a>';
                        }
                    },
                    {
                        targets: 1,
                        width: '85%',
                        searchable: false
                    },
                    {
                        targets: [2, 3, 4, 5, 6],
                        visible: false
                    }
                ]
			});
        },

        search: function (e) {
            e.preventDefault();

            this.tercerosSearchTable.ajax.reload();
        },

        clear: function (e) {
            e.preventDefault();

            this.$searchNit.val('');
            this.$searchName.val('');

            this.tercerosSearchTable.ajax.reload();
        },
    });

})(jQuery, this, this.document);
