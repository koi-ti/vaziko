/**
* Class MainUnidadesView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainUnidadesView = Backbone.View.extend({

        el: '#unidades-main',

        /**
        * Constructor Method
        */
        initialize: function () {
            // DataTable
            this.$unidadesSearchTable = this.$('#unidades-search-table');
            this.$unidadesSearchTable.DataTable({
				dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
                ajax: window.Misc.urlFull(Route.route('unidades.index')),
                columns: [
                    { data: 'unidadmedida_sigla', name: 'unidadmedida_sigla' },
                    { data: 'unidadmedida_nombre', name: 'unidadmedida_nombre' }
                ],
				buttons: [
					{
						text: '<i class="fa fa-plus"></i> Nuevo',
                        className: 'btn-sm',
						action: function (e, dt, node, config) {
							window.Misc.redirect(window.Misc.urlFull(Route.route('unidades.create')))
						}
					}
				],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function (data, type, full, row) {
                            return '<a href="'+ window.Misc.urlFull(Route.route('unidades.show', {unidades: full.id})) + '">' + data + '</a>';
                        }
                    }
                ]
			});
        }
    });

})(jQuery, this, this.document);
