/**
* Class MainDepartamentoView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainDepartamentoView = Backbone.View.extend({
        el: '#departamentos-main',
        /**
        * Constructor Method
        */
        initialize : function() {

            this.$departamentosSearchTable = this.$('#departamentos-search-table');
            var paginacion = this.$departamentosSearchTable.data('paginacion');

            this.$departamentosSearchTable.DataTable({
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                pageLength: paginacion,
                lengthMenu: [[paginacion, 10, 25, 50, -1], [paginacion, 10, 25, 50, 100]],
                ajax: window.Misc.urlFull( Route.route('departamentos.index') ),
                columns: [
                    { data: 'departamento_codigo', name: 'departamento_codigo' },
                    { data: 'departamento_nombre', name: 'departamento_nombre'}
                ]
			});
        }
    });

})(jQuery, this, this.document);
