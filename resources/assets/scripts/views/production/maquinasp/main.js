/**
* Class MainMaquinaspView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainMaquinaspView = Backbone.View.extend({

        el: '#maquinasp-main',

        /**
        * Constructor Method
        */
        initialize: function () {
            // DataTable
            this.$maquinaspSearchTable = this.$('#maquinasp-search-table');
            this.$maquinaspSearchTable.DataTable({
				dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
                ajax: window.Misc.urlFull(Route.route('maquinasp.index')),
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'maquinap_nombre', name: 'maquinap_nombre' }
                ],
				buttons: [
					{
						text: '<i class="fa fa-plus"></i> Nuevo',
                        className: 'btn-sm',
						action: function ( e, dt, node, config ) {
							window.Misc.redirect(window.Misc.urlFull(Route.route('maquinasp.create')))
						}
					}
				],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function (data, type, full, row) {
                            return '<a href="'+ window.Misc.urlFull(Route.route('maquinasp.show', {maquinasp: full.id}))  +'">' + data + '</a>';
                        }
                    }
                ]
			});
        }
    });

})(jQuery, this, this.document);
