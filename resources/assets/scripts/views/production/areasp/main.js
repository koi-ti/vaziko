/**
* Class MainAreaspView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainAreaspView = Backbone.View.extend({

        el: '#areasp-main',

        /**
        * Constructor Method
        */
        initialize: function () {
            // DataTable
            this.$areaspSearchTable = this.$('#areasp-search-table');
            this.$areaspSearchTable.DataTable({
				dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
                ajax: window.Misc.urlFull(Route.route('areasp.index')),
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'areap_nombre', name: 'areap_nombre' },
                    { data: 'areap_transporte', name: 'areap_transporte' },
                    { data: 'areap_valor', name: 'areap_valor'}
                ],
				buttons: [
					{
						text: '<i class="fa fa-plus"></i> Nuevo',
                        className: 'btn-sm',
						action: function (e, dt, node, config) {
							window.Misc.redirect(window.Misc.urlFull(Route.route('areasp.create')))
						}
					}
				],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function (data, type, full, row) {
                            return '<a href="'+ window.Misc.urlFull(Route.route('areasp.show', {areasp: full.id}))  +'">' + data + '</a>';
                        }
                    },
                    {
                        targets: 2,
                        className: 'text-right',
                        render: function (data) {
                            return parseInt(data) ? 'SI' : 'NO';
                        }
                    },
                    {
                        targets: 3,
                        className: 'text-right',
                        render: function (data) {
                            return window.Misc.currency(data);
                        }
                    },
                ]
			});
        }
    });

})(jQuery, this, this.document);
