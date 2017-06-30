/**
* Class MainCotizacionesView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainCotizacionesView = Backbone.View.extend({

        el: '#cotizaciones-main',
        events: {
            'click .btn-search': 'search',
            'click .btn-clear': 'clear'
        },


        /**
        * Constructor Method
        */
        initialize : function() {
            var _this = this;

            // Rerefences
            this.$cotizacionesSearchTable = this.$('#cotizaciones-search-table');

            // References
            this.$searchcotizacionCodigo = this.$('#searchcotizacion_numero');
            this.$searchcotizacionEstado = this.$('#searchcotizacion_estado');
            this.$searchcotizacionTercero = this.$('#searchcotizacion_tercero');
            this.$searchcotizacionTerceroNombre = this.$('#searchcotizacion_tercero_nombre');
            
            this.cotizacionesSearchTable = this.$cotizacionesSearchTable.DataTable({
                dom: "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: true,
                language: window.Misc.dataTableES(),
                ajax: {
                    url: window.Misc.urlFull( Route.route('cotizaciones.index') ),
                    data: function( data ) {
                        data.persistent = true;
                        data.cotizacion_numero = _this.$searchcotizacionCodigo.val();
                        data.estado = _this.$searchcotizacionEstado.val();
                        data.tercero_nit = _this.$searchcotizacionTercero.val();
                        data.tercero_nombre = _this.$searchcotizacionTerceroNombre.val();
                    }
                },
                columns: [ 
                    { data: 'id', name: 'id' },
                    { data: 'tercero_nombre', name: 'tercero_nombre' },
                    { data: 'cotizacion1_fecha', name: 'cotizacion1_fecha' },
                    { data: 'cotizacion1_entrega', name: 'cotizacion1_entrega' },
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '5%',
                        render: function ( data, type, full, row ) {
                           return '<a href="'+ window.Misc.urlFull( Route.route('cotizaciones.show', {cotizaciones: full.id }) )  +'">' + data + '</a>';
                        },
                    },
                ]
            });
        },

        search: function(e) {
            e.preventDefault();

            this.cotizacionesSearchTable.ajax.reload();
        },

        clear: function(e) {
            e.preventDefault();

            this.$searchcotizacionCodigo.val('');
            this.$searchcotizacionEstado.val('');
            this.$searchcotizacionTercero.val('');
            this.$searchcotizacionTerceroNombre.val('');

            this.cotizacionesSearchTable.ajax.reload();
        },
    });
})(jQuery, this, this.document);
