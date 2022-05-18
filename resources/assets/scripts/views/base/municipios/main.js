/**
* Class MainMunicipioView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainMunicipioView = Backbone.View.extend({

        el: '#municipios-main',

        /**
        * Constructor Method
        */
        initialize: function () {
            // DataTable
            this.$municipiosSearchTable = this.$('#municipios-search-table');
            this.$municipiosSearchTable.DataTable({
                ajax: window.Misc.urlFull(Route.route('municipios.index')),
                columns: [
                    { data: 'departamento_codigo', name: 'koi_departamento.departamento_codigo'},
                    { data: 'departamento_nombre', name: 'koi_departamento.departamento_nombre'},
                    { data: 'municipio_codigo', name: 'koi_municipio.municipio_codigo' },
                    { data: 'municipio_nombre', name: 'koi_municipio.municipio_nombre'},
                    { data: 'departamento_id', name: 'koi_departamento.departamento_id'}
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '15%'
                    },
                    {
                        targets: [1, 3],
                        width: '35%'
                    },
                    {
                        targets: 2,
                        width: '15%',
                        render: function (data, type, full, row) {
                            return '<a href="'+ window.Misc.urlFull(Route.route('departamentos.show', {departamentos: full.departamento_id}))  +'">' + data + '</a>';
                        }
                    },
                    {
                        targets: 4,
                        visible: false,
                        searchable: false
                    }
                ]
			});
        }
    });

})(jQuery, this, this.document);
