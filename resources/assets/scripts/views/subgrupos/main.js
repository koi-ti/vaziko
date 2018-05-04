/**
* Class MainSubGruposView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainSubGruposView = Backbone.View.extend({

        el: '#subgrupos-main',

        /**
        * Constructor Method
        */
        initialize : function() {

            this.$subgruposSearchTable = this.$('#subgrupos-search-table');

            this.$subgruposSearchTable.DataTable({
				dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('subgrupos.index') ),
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'subgrupo_nombre', name: 'subgrupo_nombre' }
                ],
				buttons: [
					{
						text: '<i class="fa fa-user-plus"></i> Nuevo subgrupo',
                        className: 'btn-sm',
						action: function ( e, dt, node, config ) {
							window.Misc.redirect( window.Misc.urlFull( Route.route('subgrupos.create') ) )
						}
					}
				],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('subgrupos.show', {subgrupos: full.id }) )  +'">' + data + '</a>';
                        }
                    }
                ]
			});
        }
    });

})(jQuery, this, this.document);
