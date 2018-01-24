/**
* Class MainTipoMaterialespView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainTipoMaterialespView = Backbone.View.extend({

        el: '#tipomaterialesp-main',
        
        /**
        * Constructor Method
        */
        initialize : function() {

            this.$tipomaterialpSearchTablese = this.$('#tipomaterialesp-search-table');

            this.$tipomaterialpSearchTablese.DataTable({
				dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('tipomaterialesp.index') ),
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'tipomaterialp_nombre', name: 'tipomaterialp_nombre' },
                    { data: 'tipomaterialp_activo', name: 'tipomaterialp_activo' },
                ],
				buttons: [
					{
						text: '<i class="fa fa-plus"></i> Nueva tipo',
                        className: 'btn-sm',
						action: function ( e, dt, node, config ) {
							window.Misc.redirect( window.Misc.urlFull( Route.route('tipomaterialesp.create') ) )
						}
					}
				],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('tipomaterialesp.show', {tipomaterialesp: full.id }) )  +'">' + data + '</a>';
                        }
                    },
                    {
                        targets: [2],
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return parseInt(data) ? 'Si' : 'No';
                        }
                    },
                ]
			});
        }
    });

})(jQuery, this, this.document);
