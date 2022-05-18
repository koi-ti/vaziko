/**
* Class MainAsientosNifView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainAsientosNifView = Backbone.View.extend({

        el: '#asientosnif-main',

        /**
        * Constructor Method
        */
        initialize: function () {
            // DataTable
            this.$asientosNifSearchTable = this.$('#asientosnif-search-table');
            this.$asientosNifSearchTable.DataTable({
                ajax: window.Misc.urlFull(Route.route('asientosnif.index')),
                columns: [
                    { data: 'asienton1_numero', name: 'asienton1_numero' },
                    { data: 'asienton1_ano', name: 'asienton1_ano' },
                    { data: 'asienton1_mes', name: 'asienton1_mes' },
                    { data: 'tercero_nit', name: 'tercero_nit' },
                    { data: 'tercero_nombre', name: 'tercero_nombre' },
                    { data: 'tercero_razonsocial', name: 'tercero_razonsocial'},
                    { data: 'tercero_nombre1', name: 'tercero_nombre1' },
                    { data: 'tercero_nombre2', name: 'tercero_nombre2' },
                    { data: 'tercero_apellido1', name: 'tercero_apellido1' },
                    { data: 'tercero_apellido2', name: 'tercero_apellido2' },
                    { data: 'asienton1_preguardado', name: 'asienton1_preguardado' }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            if( parseInt(full.asienton1_preguardado) ) {
                                return '<a href="'+ window.Misc.urlFull( Route.route('asientosnif.edit', {asientosnif: full.id }) )  +'">' + data + ' <span class="label label-warning">PRE</span></a>';
                            }else{
                                return '<a href="'+ window.Misc.urlFull( Route.route('asientosnif.show', {asientosnif: full.id }) )  +'">' + data + '</a>';
                            }
                        }
                    },
                    {
                        targets: [1, 2],
                        width: '10%'
                    },
                    {
                        targets: 3,
                        width: '15%'
                    },
                    {
                        targets: 4,
                        searchable: false
                    },
                    {
                        targets: [5, 6, 7, 8, 9],
                        visible: false
                    },
                    {
                        targets: 10,
                        visible: false,
                        searchable: false
                    }
                ]
			});
        }
    });

})(jQuery, this, this.document);
