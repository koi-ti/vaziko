/**
* Class MainPlanCuentasView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainPlanCuentasView = Backbone.View.extend({

        el: '#plancuentas-main',

        /**
        * Constructor Method
        */
        initialize : function() {
            
            this.$plancuentasSearchTable = this.$('#plancuentas-search-table');

            this.$plancuentasSearchTable.DataTable({
				dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('plancuentas.index') ),
                columns: [
                    { data: 'plancuentas_cuenta', name: 'plancuentas_cuenta' },
                    { data: 'plancuentas_nivel', name: 'plancuentas_nivel' },
                    { data: 'plancuentas_nombre', name: 'plancuentas_nombre' },
                    { data: 'plancuentas_naturaleza', name: 'plancuentas_naturaleza' },
                    { data: 'plancuentas_tercero', name: 'plancuentas_tercero' }
                ],
				buttons: [
					{ 
						text: '<i class="fa fa-user-plus"></i> Nueva cuenta',
                        className: 'btn-sm',
						action: function ( e, dt, node, config ) {
							window.Misc.redirect( window.Misc.urlFull( Route.route('plancuentas.create') ) )
						}
					}
				],
                columnDefs: [
                    {
                        targets: 0,
                        width: '15%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('plancuentas.show', {plancuentas: full.id }) )  +'">' + data + '</a>';
                        }
                    },
                    {
                        targets: 1,
                        width: '10%'                    
                    },
                    {
                        targets: 3,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return data == 'D' ? 'Débito' : 'Crédito';
                        }                     
                    },
                    {
                        targets: 4,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            console.log(data)
                            return data ? 'Si' : 'No';
                        }                    
                    }
                ]
			});
        }
    });

})(jQuery, this, this.document);
