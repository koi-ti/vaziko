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
            'click .btn-clear': 'clear',
            'click .close-ordenp': 'closeOrdenp',
            'click .complete-ordenp': 'completeOrdenp',
            'click .clone-ordenp': 'cloneOrdenp',
            'click .open-ordenp': 'openOrdenp'
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
                    { data: 'orden_create', name: 'orden_create' },
                    { data: 'orden_ano', name: 'orden_ano' },
                    { data: 'orden_numero', name: 'orden_numero' },
                    { data: 'orden_fecha_inicio', name: 'orden_fecha_inicio' },
                    { data: 'orden_fecha_entrega', name: 'orden_fecha_entrega' },
                    { data: 'orden_hora_entrega', name: 'orden_hora_entrega' },
                    { data: 'tercero_nombre', name: 'tercero_nombre' },
                    { data: 'orden_abierta', name: 'orden_abierta' }
                ],
                rowReorder: {
                   selector: 'td:nth-child(1)'
               },
                order: [
                	[ 2, 'desc' ], [ 3, 'desc' ]
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '13%',
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
                        targets: 1,
                        orderable: false,
                        width: '13%',
                        className: 'text-center',
                        render: function ( data, type, full, row ) {
                            const close = '<a class="btn btn-info btn-xs close-ordenp" title="Cerrar orden de producción" data-resource="'+ full.id +'" data-code="'+ full.orden_codigo +'" data-refer="'+ full.tercero_nombre+'"><i class="fa fa-lock"></i></a>';
                            const open = '<a class="btn btn-info btn-xs open-ordenp" title="Reabrir orden de producción" data-resource="'+ full.id +'" data-code="'+ full.orden_codigo +'" data-refer="'+ full.tercero_nombre+'"><i class="fa fa-unlock"></i></a>';
                            const clone = '<a class="btn btn-info btn-xs clone-ordenp" title="Clonar orden de producción" data-resource="'+ full.id +'" data-code="'+ full.orden_codigo +'" data-refer="'+ full.tercero_nombre+'"><i class="fa fa-clone"></i></a>';
                            const complete = '<a class="btn btn-info btn-xs complete-ordenp" title="Culminar orden de producción" data-resource="'+ full.id +'" data-code="'+ full.orden_codigo +'" data-refer="'+ full.tercero_nombre+'"><i class="fa fa-handshake-o"></i></a>';
                            var buttons = '';

                            if ( parseInt(full.orden_create) && parseInt(full.orden_opcional) ){
                                buttons += parseInt(full.orden_abierta) ? close : open;
                            }

                            if ( parseInt(full.orden_opcional) ){
                                // Verificar que este alguno de estos activos para continuar agregando botones
                                if( parseInt(full.orden_anulada) ||  parseInt(full.orden_culminada) || parseInt(full.orden_abierta) ){
                                    buttons += parseInt(full.orden_abierta) ? ' ' + clone + ' ' + complete : '';

                                    buttons += parseInt(full.orden_culminada) ? ' ' + close : '';
                                }
                            }

                            if( parseInt(full.orden_anulada) ){
                                buttons = '';
                            }

                            buttons = (buttons) ? buttons : '----';
                            return '<div class="btn-group btn-group-justified btn-group-xs" role="group">' + buttons + '</div>';
                        },
                    },
                    {
                        targets: [2, 3],
                        visible: false
                    },
                    {
                        targets: [4, 5, 6],
                        width: '10%',
                    },
                    {
                        targets: 7,
                        width: '50%'
                    },
                    {
                        targets: 8,
                        width: '7%',
                        orderable: false,
                        className: 'text-center',
                        render: function ( data, type, full, row ) {
                            if( parseInt(full.orden_anulada) ) {
                                return '<span class="label label-danger">ANULADA</span>';
                            } else if( parseInt(full.orden_abierta) ) {
                                return '<span class="label label-success">ABIERTA</span>';
                            } else if( parseInt(full.orden_culminada) ) {
                                return '<span class="label label-info">CULMINADA</span>';
                            } else if ( !parseInt(full.orden_abierta) ) {
                                return '<span class="label label-warning">CERRADA</span>';
                            }
                        }
                    }
                ],
                fnRowCallback: function( row, data) {
                    if ( parseInt(data.orden_abierta) ) {
                        $(row).css( {"color":"#00A65A"} );
                    }else if ( parseInt(data.orden_anulada) ) {
                        $(row).css( {"color":"#DD4B39"} );
                    }else if ( parseInt(data.orden_culminada) ) {
                        $(row).css( {"color":"#0073B7"} );
                    }
                },
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

        /**
        * Close ordenp
        */
        closeOrdenp: function (e) {
            e.preventDefault();

            var _this = this,
                model = this.$(e.currentTarget).data();

            var cancelConfirm = new window.app.ConfirmWindow({
                parameters: {
                    dataFilter: { orden_codigo: model.code },
                    template: _.template( ($('#ordenp-close-confirm-tpl').html() || '') ),
                    titleConfirm: 'Cerrar orden de producción',
                    onConfirm: function () {
                        // Close orden
                        $.ajax({
                            url: window.Misc.urlFull( Route.route('ordenes.cerrar', { ordenes: model.resource }) ),
                            type: 'GET',
                            beforeSend: function() {
                                window.Misc.setSpinner( _this.el );
                            }
                        })
                        .done(function(resp) {
                            window.Misc.removeSpinner( _this.el );
                            if(!_.isUndefined(resp.success)) {
                                // response success or error
                                var text = resp.success ? '' : resp.errors;
                                if( _.isObject( resp.errors ) ) {
                                    text = window.Misc.parseErrors(resp.errors);
                                }

                                if( !resp.success ) {
                                    alertify.error(text);
                                    return;
                                }

                                alertify.success(resp.msg);
                                _this.ordersSearchTable.ajax.reload();
                            }
                        })
                        .fail(function(jqXHR, ajaxOptions, thrownError) {
                            window.Misc.removeSpinner( _this.el );
                            alertify.error(thrownError);
                        });
                    }
                }
            });

            cancelConfirm.render();
        },

        /**
        * Complete ordenp
        */
        completeOrdenp: function (e) {
            e.preventDefault();

            var _this = this,
                model = this.$(e.currentTarget).data();

            var cancelConfirm = new window.app.ConfirmWindow({
                parameters: {
                    dataFilter: { orden_codigo: model.code },
                    template: _.template( ($('#ordenp-complete-confirm-tpl').html() || '') ),
                    titleConfirm: 'Completar orden de producción',
                    onConfirm: function () {
                        // Close orden
                        $.ajax({
                            url: window.Misc.urlFull( Route.route('ordenes.completar', { ordenes: model.resource }) ),
                            type: 'GET',
                            beforeSend: function() {
                                window.Misc.setSpinner( _this.el );
                            }
                        })
                        .done(function(resp) {
                            window.Misc.removeSpinner( _this.el );

                            if(!_.isUndefined(resp.success)) {
                                // response success or error
                                var text = resp.success ? '' : resp.errors;
                                if( _.isObject( resp.errors ) ) {
                                    text = window.Misc.parseErrors(resp.errors);
                                }

                                if( !resp.success ) {
                                    alertify.error(text);
                                    return;
                                }

                                window.Misc.successRedirect( resp.msg, window.Misc.urlFull(Route.route('ordenes.show', { ordenes: model.resource })) );
                            }
                        })
                        .fail(function(jqXHR, ajaxOptions, thrownError) {
                            window.Misc.removeSpinner( _this.el );
                            alertify.error(thrownError);
                        });
                    }
                }
            });

            cancelConfirm.render();
        },

        /**
        * Clone ordenp
        */
        cloneOrdenp: function (e) {
            e.preventDefault();

            var _this = this,
                model = this.$(e.currentTarget).data(),
                route = window.Misc.urlFull( Route.route('ordenes.clonar', { ordenes: model.resource }) ),
                data = { orden_codigo: model.code };

            var cloneConfirm = new window.app.ConfirmWindow({
                parameters: {
                    dataFilter: data,
                    template: _.template( ($('#ordenp-clone-confirm-tpl').html() || '') ),
                    titleConfirm: 'Clonar orden de producción',
                    onConfirm: function () {
                        // Clone orden
                        window.Misc.cloneModule({
                            'url': route,
                            'wrap': _this.el,
                            'callback': (function (_this) {
                                return function ( resp ) {
                                    window.Misc.successRedirect( resp.msg, window.Misc.urlFull(Route.route('ordenes.edit', { ordenes: resp.id })) );
                                }
                            })(_this)
                        });
                    }
                }
            });

            cloneConfirm.render();
        },

        /**
        * Open ordenp
        */
        openOrdenp: function (e) {
            e.preventDefault();

            var _this = this,
                model = this.$(e.currentTarget).data();

            var cancelConfirm = new window.app.ConfirmWindow({
                parameters: {
                    dataFilter: { orden_codigo: model.code },
                    template: _.template( ($('#ordenp-open-confirm-tpl').html() || '') ),
                    titleConfirm: 'Reabir orden de producción',
                    onConfirm: function () {
                        // Open orden
                        $.ajax({
                            url: window.Misc.urlFull( Route.route('ordenes.abrir', { ordenes: model.resource }) ),
                            type: 'GET',
                            beforeSend: function() {
                                window.Misc.setSpinner( _this.el );
                            }
                        })
                        .done(function(resp) {
                            window.Misc.removeSpinner( _this.el );

                            if(!_.isUndefined(resp.success)) {
                                // response success or error
                                var text = resp.success ? '' : resp.errors;
                                if( _.isObject( resp.errors ) ) {
                                    text = window.Misc.parseErrors(resp.errors);
                                }

                                if( !resp.success ) {
                                    alertify.error(text);
                                    return;
                                }

                                window.Misc.successRedirect( resp.msg, window.Misc.urlFull(Route.route('ordenes.edit', { ordenes: model.resource })) );
                            }
                        })
                        .fail(function(jqXHR, ajaxOptions, thrownError) {
                            window.Misc.removeSpinner( _this.el );
                            alertify.error(thrownError);
                        });
                    }
                }
            });

            cancelConfirm.render();
        }
    });

})(jQuery, this, this.document);
