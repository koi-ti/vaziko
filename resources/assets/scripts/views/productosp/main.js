/**
* Class MainProductospView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainProductospView = Backbone.View.extend({

        el: '#productosp-main',
        events: {
            'click .btn-search': 'search',
            'click .btn-clear': 'clear'
        },

        /**
        * Constructor Method
        */
        initialize: function () {
            var _this = this;

            // Rerefences
            this.$productospSearchTable = this.$('#productosp-search-table');
            this.$searchCod = this.$('#productop_codigo');
            this.$searchName = this.$('#productop_nombre');
            var paginacion = this.$productospSearchTable.data('paginacion');

            this.productospSearchTable = this.$productospSearchTable.DataTable({
                dom: "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
            	pageLength: paginacion,
                ajax: {
                    url: window.Misc.urlFull(Route.route('productosp.index')),
                    data: function (data) {
                        data.persistent = true;
                        data.datatables = true;
                        data.productop_codigo = _this.$searchCod.val();
                        data.productop_nombre = _this.$searchName.val();
                    }
                },
                columns: [
                    { data: 'productop_codigo', name: 'productop_codigo' },
                    { data: 'productop_nombre', name: 'productop_nombre' }
                ],
				buttons: [
					{
						text: '<i class="fa fa-user-plus"></i> Nuevo',
                        className: 'btn-sm',
						action: function (e, dt, node, config) {
							window.Misc.redirect(window.Misc.urlFull( Route.route('productosp.create')))
						}
					}
				],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function (data, type, full, row) {
                            return '<a href="'+ window.Misc.urlFull(Route.route('productosp.show', {productosp: full.id})) + '">' + data + '</a>';
                        }
                    }
                ]
			});
        },

        search: function (e) {
            e.preventDefault();

            this.productospSearchTable.ajax.reload();
        },

        clear: function (e) {
            e.preventDefault();

            this.$searchCod.val('');
            this.$searchName.val('');

            this.productospSearchTable.ajax.reload();
        },
    });

})(jQuery, this, this.document);
