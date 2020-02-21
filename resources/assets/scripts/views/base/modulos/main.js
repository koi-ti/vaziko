/**
* Class MainModuloView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainModuloView = Backbone.View.extend({

        el: '#modulos-main',

        /**
        * Constructor Method
        */
        initialize: function () {

            this.$modulosSearchTable = this.$('#modulos-search-table');
            var paginacion = this.$modulosSearchTable.data('pagination');

            this.$modulosSearchTable.DataTable({
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                pageLength: paginacion,
                lengthMenu: [[paginacion, 10, 25, 50, 100], [paginacion, 10, 25, 50, 100]],
                ajax: window.Misc.urlFull(Route.route('modulos.index')),
                columns: [
                    { data: 'display_name', name: 'display_name'},
                    { data: 'name', name: 'name'}
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '25%'
                    }
                ]
			});
        }
    });

})(jQuery, this, this.document);
