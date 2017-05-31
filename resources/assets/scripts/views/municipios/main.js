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
        initialize : function() {
            
            this.$municipiosSearchTable = this.$('#municipios-search-table');

            this.$municipiosSearchTable.DataTable({
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: {
                    url: window.Misc.urlFull( Route.route('municipios.index') ),
                    data: function( data ) {
                        data.datatables = true;
                    }
                },
                columns: [
                    { data: 'departamento_codigo', name: 'koi_departamento.departamento_codigo'},
                    { data: 'departamento_nombre', name: 'departamento_nombre'},
                    { data: 'municipio_codigo', name: 'municipio_codigo' },
                    { data: 'municipio_nombre', name: 'municipio_nombre'},
                    { data: 'departamento_id', name: 'departamento_id'}
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '15%'
                    },
                    {
                        targets: 1,
                        width: '35%'
                    },
                    {
                        targets: 2,
                        width: '15%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('departamentos.show', {departamentos: full.departamento_id }) )  +'">' + data + '</a>';
                        }
                    },
                    {
                        targets: 3,
                        width: '35%'
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
