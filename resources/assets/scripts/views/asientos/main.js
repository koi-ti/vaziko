/**
* Class MainAsientosView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainAsientosView = Backbone.View.extend({

        el: '#asientos-main',

        /**
        * Constructor Method
        */
        initialize : function() {            
            this.$asientosSearchTable = this.$('#asientos-search-table');

            this.$asientosSearchTable.DataTable({
				dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('asientos.index') ),
                columns: [
                    { data: 'asiento1_numero', name: 'asiento1_numero' },
                    { data: 'asiento1_ano', name: 'asiento1_ano' },
                    { data: 'asiento1_mes', name: 'asiento1_mes' },
                    { data: 'tercero_nit', name: 'tercero_nit' },
                    { data: 'tercero_nombre', name: 'tercero_nombre' },
                    { data: 'tercero_razonsocial', name: 'tercero_razonsocial'},
                    { data: 'tercero_nombre1', name: 'tercero_nombre1' },
                    { data: 'tercero_nombre2', name: 'tercero_nombre2' },
                    { data: 'tercero_apellido1', name: 'tercero_apellido1' },
                    { data: 'tercero_apellido2', name: 'tercero_apellido2' },
                    { data: 'asiento1_preguardado', name: 'asiento1_preguardado' }
                ],
				buttons: [
					{ 
						text: '<i class="fa fa-user-plus"></i> Nueva asiento',
                        className: 'btn-sm',
						action: function ( e, dt, node, config ) {
							window.Misc.redirect( window.Misc.urlFull( Route.route('asientos.create') ) )
						}
					}
				],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            if( parseInt(full.asiento1_preguardado) ) {
                                return '<a href="'+ window.Misc.urlFull( Route.route('asientos.edit', {asientos: full.id }) )  +'">' + data + ' <span class="label label-warning">PRE</span></a>';
                            }else{
                                return '<a href="'+ window.Misc.urlFull( Route.route('asientos.show', {asientos: full.id }) )  +'">' + data + '</a>';
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
