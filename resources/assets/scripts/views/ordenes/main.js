/**
* Class MainOrdenesView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainOrdenesView = Backbone.View.extend({

        el: '#ordenes-main',
        events: {
            'click .btn-search': 'search',
            'click .btn-clear': 'clear'
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            var _this = this;

            // References
            this.$ordersSearchTable = this.$('#ordenes-search-table');
            this.$searchordenpOrden = this.$('#searchordenp_ordenp_numero');
            this.$searchordenpTercero = this.$('#searchordenp_tercero');
            this.$searchordenpTerceroName = this.$('#searchordenp_tercero_nombre');
            this.$searchordenpEstado = this.$('#searchordenp_ordenp_estado');
            this.$searchordenpReferencia = this.$('#searchordenp_ordenp_referencia');
            this.$searchordenpProductop = this.$('#searchordenp_ordenp_productop');
            var paginacion = this.$ordersSearchTable.data('paginacion');

            this.ordersSearchTable = this.$ordersSearchTable.DataTable({
				dom: "<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                pageLength: paginacion,
                ajax: {
                    url: window.Misc.urlFull( Route.route('ordenes.index') ),
                    data: function( data ) {
                        data.persistent = true;
                        data.orden_numero = _this.$searchordenpOrden.val();
                        data.orden_tercero_nit = _this.$searchordenpTercero.val();
                        data.orden_tercero_nombre = _this.$searchordenpTerceroName.val();
                        data.orden_estado = _this.$searchordenpEstado.val();
                        data.orden_referencia = _this.$searchordenpReferencia.val();
                        data.orden_productop = _this.$searchordenpProductop.val();
                    }
                },
                columns: [
                    { data: 'orden_codigo', name: 'orden_codigo' },
                    { data: 'orden_ano', name: 'orden_ano' },
                    { data: 'orden_numero', name: 'orden_numero' },
                    { data: 'orden_fecha_inicio', name: 'orden_fecha_inicio' },
                    { data: 'orden_fecha_entrega', name: 'orden_fecha_entrega' },
                    { data: 'orden_hora_entrega', name: 'orden_hora_entrega' },
                    { data: 'tercero_nombre', name: 'tercero_nombre' }
                ],
                rowReorder: {
                   selector: 'td:nth-child(1)'
               },
                order: [
                	[ 1, 'desc' ], [ 2, 'desc' ]
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '15%',
                        searchable: false,
                        render: function ( data, type, full, row ) {
                            if( full.cotizacion1_precotizacion && full.orden_cotizacion ){
                                return '<a href="'+ window.Misc.urlFull( Route.route('ordenes.show', {ordenes: full.id }) )  +'">' + data + '</a> <a href="'+ window.Misc.urlFull( Route.route('precotizaciones.show', {precotizaciones: full.cotizacion1_precotizacion}) )+'" title="Ir a precotización"><span class="label label-success">PRE</span></a> <a href="'+ window.Misc.urlFull( Route.route('cotizaciones.show', {cotizaciones: full.orden_cotizacion}) )+'" title="Ir a cotización"><span class="label label-danger">COT</span></a>';
                            }else if( full.cotizacion1_precotizacion ){
                                return '<a href="'+ window.Misc.urlFull( Route.route('ordenes.show', {ordenes: full.id }) )  +'">' + data + '</a> <a href="'+ window.Misc.urlFull( Route.route('precotizaciones.show', {precotizaciones: full.cotizacion1_precotizacion}) )+'" title="Ir a precotización"><span class="label label-success">PRE</span></a>';
                            }else if( full.orden_cotizacion ) {
                                return '<a href="'+ window.Misc.urlFull( Route.route('ordenes.show', {ordenes: full.id }) )  +'">' + data + '</a> <a href="'+ window.Misc.urlFull( Route.route('cotizaciones.show', {cotizaciones: full.orden_cotizacion}) )+'" title="Ir a cotización"><span class="label label-danger">COT</span></a>';
                            }else{
                                return '<a href="'+ window.Misc.urlFull( Route.route('ordenes.show', {ordenes: full.id }) )  +'">' + data + '</a>';
                            }
                        }
                    },
                    {
                        targets: [1, 2],
                        visible: false,
                        width: '10%',
                    },
                    {
                        targets: [3, 4, 5],
                        width: '10%',
                    }
                ],
                fnRowCallback: function( row, data ) {
                    if ( parseInt(data.orden_abierta) ) {
                        $(row).css( {"color":"#00a65a"} );
                    }else if ( parseInt(data.orden_anulada) ) {
                        $(row).css( {"color":"red"} );
                    }else if ( parseInt(data.orden_culminada) ) {
                        $(row).css( {"color":"#0073b7"} );
                    }
                }
			});
        },

        search: function(e) {
            e.preventDefault();

            this.ordersSearchTable.ajax.reload();
        },

        clear: function(e) {
            e.preventDefault();

            this.$searchordenpOrden.val('');
            this.$searchordenpTercero.val('');
            this.$searchordenpTerceroName.val('');
            this.$searchordenpEstado.val('');
            this.$searchordenpReferencia.val('');
            this.$searchordenpProductop.val('').trigger('change');

            this.ordersSearchTable.ajax.reload();
        },
    });

})(jQuery, this, this.document);
