/**
* Class MainMunicipioView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainMunicipioView = Backbone.View.extend({

        el: '#municipios-main',

        /**
        * Constructor Method
        */
        initialize : function() {
            
            this.$municipiosSearchTable = this.$('#municipios-search-table');

            this.$municipiosSearchTable.DataTable({
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('municipios.index') ),
                columns: [
                    { data: 'departamento_codigo', name: 'koi_departamento.departamento_codigo'},
                    { data: 'departamento_nombre', name: 'departamento_nombre'},
                    { data: 'municipio_codigo', name: 'municipio_codigo' },
                    { data: 'municipio_nombre', name: 'municipio_nombre'}
                ]
			});
        }
    });

})(jQuery, this, this.document);
