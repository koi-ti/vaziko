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
            'click .btn-clear': 'clear',
        },

        /**
        * Constructor Method
        */
        initialize: function () {
            var _this = this;

            // Rerefences
            this.$precotizacionesSearchTable = this.$('#precotizaciones-search-table');
            this.$searchprecotizacionNumero = this.$('#searchprecotizacion_numero');
            this.$searchprecotizacionTercero = this.$('#searchprecotizacion_tercero');
            this.$searchprecotizacionTerceroName = this.$('#searchprecotizacion_tercero_nombre');
            this.$searchprecotizacionReferencia = this.$('#searchprecotizacion_referencia');
            this.$searchprecotizacionEstado = this.$('#searchprecotizacion_estado');
            this.$searchprecotizacionProductop = this.$('#searchprecotizacion_productop');
            var paginacion = this.$precotizacionesSearchTable.data('pagination');

            this.precotizacionesSearchTable = this.$precotizacionesSearchTable.DataTable({
                dom: "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: true,
                language: window.Misc.dataTableES(),
                pageLength: paginacion,
                ajax: {
                    url: window.Misc.urlFull( Route.route('precotizaciones.index') ),
                    data: function(data) {
                        data.persistent = true;
                        data.precotizacion_numero = _this.$searchprecotizacionNumero.val();
                        data.precotizacion_tercero_nit = _this.$searchprecotizacionTercero.val();
                        data.precotizacion_tercero_nombre = _this.$searchprecotizacionTerceroName.val();
                        data.precotizacion_referencia = _this.$searchprecotizacionReferencia.val();
                        data.precotizacion_estado = _this.$searchprecotizacionEstado.val();
                        data.precotizacion_productop = _this.$searchprecotizacionProductop.val();
                    }
                },
                columns: [
                    { data: 'precotizacion_codigo', name: 'precotizacion_codigo' },
                    { data: 'precotizacion1_ano', name: 'precotizacion1_ano' },
                    { data: 'precotizacion1_numero', name: 'precotizacion1_numero' },
                    { data: 'tercero_nombre', name: 'tercero_nombre' },
                    { data: 'precotizacion1_fecha', name: 'precotizacion1_fecha' },
                    { data: 'precotizacion1_fh_culminada', name: 'precotizacion1_fh_culminada' },
                    { data: 'precotizacion1_abierta', name: 'precotizacion1_abierta' },
                ],
                order: [
                    [ 1, 'desc' ], [ 2, 'desc' ]
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '7%',
                        render: function ( data, type, full, row ) {
                           return '<a href="'+ window.Misc.urlFull( Route.route('precotizaciones.show', {precotizaciones: full.id }) )  +'">' + data + '</a>';
                        },
                    },
                    {
                        targets: [1, 2],
                        visible: false,
                    },
                    {
                        targets: 3,
                        width: '60%',
                    },
                    {
                        targets: 4,
                        width: '10%',
                    },
                    {
                        targets: 5,
                        width: '10%',
                        searchable: false,
                        orderable: false,
                    },
                    {
                        targets: 6,
                        width: '7%',
                        searchable: false,
                        orderable: false,
                        className: 'text-center',
                        render: function ( data, type, full, row ) {
                            if( parseInt(full.precotizacion1_culminada) ) {
                                return '<span class="label label-primary">CULMINADA</span>';
                            } else if( parseInt(full.precotizacion1_abierta) ) {
                                return '<span class="label label-success">ABIERTA</span>';
                            } else {
                                return '<span class="label label-danger">CERRADA</span>';
                            }
                        }
                    }
                ],
                fnRowCallback: function( row, data ) {
                    if ( parseInt(data.precotizacion1_culminada) ) {
                        $(row).css( {"color":"#3C8DBC"} );
                    }else if( parseInt(data.precotizacion1_abierta) ) {
                        $(row).css( {"color":"#00A65A"} );
                    }else{
                        $(row).css( {"color":"#DD4B39"} );
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
            this.$searchprecotizacionReferencia.val('');
            this.$searchprecotizacionEstado.val('');
            this.$searchprecotizacionProductop.val('').trigger('change');

            this.precotizacionesSearchTable.ajax.reload();
        }
    });

})(jQuery, this, this.document);
