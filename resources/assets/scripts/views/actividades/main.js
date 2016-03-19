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
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('actividades.index') ),
                columns: [
                    { data: 'actividad_codigo', name: 'actividad_codigo' },
                    { data: 'actividad_nombre', name: 'actividad_nombre'},
                    { data: 'actividad_categoria', name: 'actividad_categoria'}, 
                    { data: 'actividad_tarifa', name: 'actividad_tarifa' }
                ]
			});
        }
    });

})(jQuery, this, this.document);
