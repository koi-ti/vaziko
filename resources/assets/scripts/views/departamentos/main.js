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

            this.$departamentosSearchTable.DataTable({
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('departamentos.index') ),
                columns: [
                    { data: 'departamento_codigo', name: 'departamento_codigo' },
                    { data: 'departamento_nombre', name: 'departamento_nombre'}
                ]
			});
        }
    });

})(jQuery, this, this.document);
