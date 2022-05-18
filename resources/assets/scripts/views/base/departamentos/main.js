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
        initialize: function () {
            // DataTable
            this.$departamentosSearchTable = this.$('#departamentos-search-table');
            this.$departamentosSearchTable.DataTable({
                ajax: window.Misc.urlFull(Route.route('departamentos.index')),
                columns: [
                    { data: 'departamento_codigo', name: 'departamento_codigo' },
                    { data: 'departamento_nombre', name: 'departamento_nombre' }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '15%',
                        render: function (data, type, full, row) {
                            return '<a href="'+ window.Misc.urlFull(Route.route('departamentos.show', {departamentos: full.id}) )  +'">' + data + '</a>';
                        }
                    }
                ]
			});
        }
    });

})(jQuery, this, this.document);
