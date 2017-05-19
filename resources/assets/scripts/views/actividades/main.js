/**
* Class MainActividadView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainActividadView = Backbone.View.extend({

        el: '#actividades-main',

        /**
        * Constructor Method
        */
        initialize : function() {
            
            this.$actividadesSearchTable = this.$('#actividades-search-table');

            this.$actividadesSearchTable.DataTable({
				dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: true,
                language: window.Misc.dataTableES(),
                ajax: {
                    url: window.Misc.urlFull( Route.route('actividades.index') ),
                    data: function( data ) {
                        data.datatables = true;
                    }
                },
                columns: [
                    { data: 'actividad_codigo', name: 'actividad_codigo' },
                    { data: 'actividad_nombre', name: 'actividad_nombre'},
                    { data: 'actividad_categoria', name: 'actividad_categoria'}, 
                    { data: 'actividad_tarifa', name: 'actividad_tarifa' }
                ],
                buttons: [
                    { 
                        text: '<i class="fa fa-user-plus"></i> Nueva actividad', 
                        className: 'btn-sm',
                        action: function ( e, dt, node, config ) {
                                window.Misc.redirect( window.Misc.urlFull( Route.route('actividades.create') ) )
                        }
                    }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '15%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('actividades.show', {actividades: full.id }) )  +'">' + data + '</a>';
                        }
                    }
                ]
			});
        }
    });

})(jQuery, this, this.document);
