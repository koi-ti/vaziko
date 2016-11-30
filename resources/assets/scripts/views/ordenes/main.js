/**
* Class MainOrdenesView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainOrdenesView = Backbone.View.extend({

        el: '#ordenes-main',

        /**
        * Constructor Method
        */
        initialize : function() {
            this.$ordersSearchTable = this.$('#ordenes-search-table');

            this.ordersSearchTable = this.$ordersSearchTable.DataTable({
				dom: "<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: {
                    url: window.Misc.urlFull( Route.route('ordenes.index') ),
                    data: function( data ) {
                        // data.ordenp_numero = _this.$searchordenpOrden.val();
                        // data.ordenp_tercero_nit = _this.$searchordenpTercero.val();
                    }
                },
                columns: [
                    { data: 'ordenp_codigo', name: 'ordenp_codigo' },
                    { data: 'ordenp_ano', name: 'ordenp_ano' },
                    { data: 'ordenp_numero', name: 'ordenp_numero' },
                    { data: 'tercero_nombre', name: 'tercero_nombre' },
                    { data: 'ordenp_fecha', name: 'ordenp_fecha' }
                ],
                order: [
                	[ 1, 'desc' ], [ 2, 'desc' ]
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        searchable: false,
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('ordenes.show', {ordenes: full.id }) )  +'">' + data + '</a>';
                        }
                    },
                    {
                        targets: [1, 2],
                        visible: false
                    }
                ]
			});
        }
    });

})(jQuery, this, this.document);
