/**
* Class MainProductosView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainProductosView = Backbone.View.extend({

        el: '#productos-main',
        events: {
            'click .btn-search': 'search',
            'click .btn-clear': 'clear'
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            var _this = this;

            // Rerefences
            this.$productosSearchTable = this.$('#productos-search-table');
            this.$searchCod = this.$('#producto_codigo');
            this.$searchName = this.$('#producto_nombre');

            this.productosSearchTable = this.$productosSearchTable.DataTable({
                dom: "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: {
                    url: window.Misc.urlFull( Route.route('productos.index') ),
                    data: function( data ) {
                        data.datatables = true;
                        data.persistent = true;
                        data.producto_codigo = _this.$searchCod.val();
                        data.producto_nombre = _this.$searchName.val();
                    }
                },
                columns: [
                    { data: 'producto_codigo', name: 'producto_codigo' },
                    { data: 'producto_nombre', name: 'producto_nombre' },
                    { data: 'materialp_nombre', name: 'materialp_nombre' }
                ],
				buttons: [
					{
						text: '<i class="fa fa-user-plus"></i> Nuevo producto',
                        className: 'btn-sm',
						action: function ( e, dt, node, config ) {
							window.Misc.redirect( window.Misc.urlFull( Route.route('productos.create') ) )
						}
					}
				],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('productos.show', {productos: full.id }) )  +'">' + data + '</a>';
                        }
                    }
                ]
			});
        },

        search: function(e) {
            e.preventDefault();

            this.productosSearchTable.ajax.reload();
        },

        clear: function(e) {
            e.preventDefault();

            this.$searchCod.val('');
            this.$searchName.val('');

            this.productosSearchTable.ajax.reload();
        },
    });

})(jQuery, this, this.document);
