/**
* Class MainMaterialespView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainMaterialespView = Backbone.View.extend({

        el: '#materialesp-main',

        /**
        * Constructor Method
        */
        initialize: function () {
            // DataTable
            this.$materialespSearchTable = this.$('#materialesp-search-table');
            this.$materialespSearchTable.DataTable({
				dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
                ajax: window.Misc.urlFull(Route.route('materialesp.index')),
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'materialp_nombre', name: 'materialp_nombre' },
                    { data: 'tipomaterial_nombre', name: 'koi_tipomaterial.tipomaterial_nombre' },
                    { data: 'materialp_empaque', name: 'materialp_empaque' }
                ],
				buttons: [
					{
						text: '<i class="fa fa-plus"></i> Nuevo',
                        className: 'btn-sm',
						action: function ( e, dt, node, config ) {
							window.Misc.redirect(window.Misc.urlFull(Route.route('materialesp.create')))
						}
					}
				],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function (data, type, full, row) {
                            return '<a href="'+ window.Misc.urlFull(Route.route('materialesp.show', {materialesp: full.id}))  +'">' + data + '</a>';
                        }
                    },
                    {
                        targets: 3,
                        width: '10%',
                        render: function (data, type, full, row) {
                            return parseInt(data) ? 'Si' : 'No';
                        }
                    },
                ]
			});
        }
    });

})(jQuery, this, this.document);
