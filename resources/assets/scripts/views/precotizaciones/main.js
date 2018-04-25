/**
* Class MainPreCotizacionesView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainPreCotizacionesView = Backbone.View.extend({

        el: '#precotizaciones-main',
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
            this.$precotizacionesSearchTable = this.$('#precotizaciones-search-table');
            this.$searchprecotizacionNumero = this.$('#searchprecotizacion_numero');
            this.$searchprecotizacionTercero = this.$('#searchprecotizacion_tercero');
            this.$searchprecotizacionTerceroName = this.$('#searchprecotizacion_tercero_nombre');
            this.$searchprecotizacionEstado = this.$('#searchprecotizacion_estado');

            this.precotizacionesSearchTable = this.$precotizacionesSearchTable.DataTable({
                dom: "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: true,
                language: window.Misc.dataTableES(),
                ajax: {
                    url: window.Misc.urlFull( Route.route('precotizaciones.index') ),
                    data: function( data ) {
                        data.persistent = true;
                        data.precotizacion_numero = _this.$searchprecotizacionNumero.val();
                        data.precotizacion_tercero_nit = _this.$searchprecotizacionTercero.val();
                        data.precotizacion_tercero_nombre = _this.$searchprecotizacionTerceroName.val();
                        data.precotizacion_estado = _this.$searchprecotizacionEstado.val();
                    }
                },
                columns: [
                    { data: 'precotizacion_codigo', name: 'precotizacion_codigo' },
                    { data: 'precotizacion1_ano', name: 'precotizacion1_ano' },
                    { data: 'precotizacion1_numero', name: 'precotizacion1_numero' },
                    { data: 'tercero_nombre', name: 'tercero_nombre' },
                    { data: 'precotizacion1_fecha', name: 'precotizacion1_fecha' },
                    { data: 'precotizacion1_abierta', name: 'precotizacion1_abierta' }
                ],
                order: [
                    [ 1, 'desc' ], [ 2, 'desc' ]
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                           return '<a href="'+ window.Misc.urlFull( Route.route('precotizaciones.show', {precotizaciones: full.id }) )  +'">' + data + '</a>';
                        },
                    },
                    {
                        targets: [1, 2],
                        visible: false,
                        width: '10%',
                    },
                    {
                        targets: 3,
                        width: '60%',
                    },
                    {
                        targets: 5,
                        render: function ( data, type, full, row ) {
                            return parseInt(data) ? 'Si' : 'No';
                        }
                    }
                ],
                fnRowCallback: function( row, data ) {
                    if ( parseInt(data.precotizacion1_abierta) ) {
                        $(row).css( {"color":"#00a65a"} );
                    }else{
                        $(row).css( {"color":"black"} );
                    }
                }
            });
        },

        search: function(e) {
            e.preventDefault();

            this.precotizacionesSearchTable.ajax.reload();
        },

        clear: function(e) {
            e.preventDefault();

            this.$searchprecotizacionNumero.val('');
            this.$searchprecotizacionTercero.val('');
            this.$searchprecotizacionTerceroName.val('');
            this.$searchprecotizacionEstado.val('');

            this.precotizacionesSearchTable.ajax.reload();
        },
    });
})(jQuery, this, this.document);
