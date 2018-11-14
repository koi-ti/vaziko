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
            'click .btn-clear': 'clear',
            'click .close-cotizacion': 'closeCotizacion',
            'click .clone-cotizacion': 'cloneCotizacion',
            'click .generate-cotizacion': 'generateCotizacion',
            'click .open-cotizacion': 'openCotizacion'
        },


        /**
        * Constructor Method
        */
        initialize : function() {
            var _this = this;

            // Rerefences
            this.$cotizacionesSearchTable = this.$('#cotizaciones-search-table');
            this.$searchcotizacionCotizacion = this.$('#searchcotizacion_numero');
            this.$searchcotizacionTercero = this.$('#searchcotizacion_tercero');
            this.$searchcotizacionTerceroName = this.$('#searchcotizacion_tercero_nombre');
            this.$searchcotizacionEstado = this.$('#searchcotizacion_estado');
            this.$searchcotizacionReferencia = this.$('#searchcotizacion_referencia');
            this.$searchcotizacionProductop = this.$('#searchcotizacion_productop');
            var paginacion = this.$cotizacionesSearchTable.data('paginacion');

            this.cotizacionesSearchTable = this.$cotizacionesSearchTable.DataTable({
                dom: "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: true,
                language: window.Misc.dataTableES(),
                pageLength: paginacion,
                ajax: {
                    url: window.Misc.urlFull( Route.route('cotizaciones.index') ),
                    data: function( data ) {
                        data.persistent = true;
                        data.cotizacion_numero = _this.$searchcotizacionCotizacion.val();
                        data.cotizacion_tercero_nit = _this.$searchcotizacionTercero.val();
                        data.cotizacion_tercero_nombre = _this.$searchcotizacionTerceroName.val();
                        data.cotizacion_estado = _this.$searchcotizacionEstado.val();
                        data.cotizacion_referencia = _this.$searchcotizacionReferencia.val();
                        data.cotizacion_productop = _this.$searchcotizacionProductop.val();
                    }
                },
                columns: [
                    { data: 'cotizacion_codigo', name: 'cotizacion_codigo' },
                    { data: 'cotizacion_create', name: 'cotizacion_create' },
                    { data: 'cotizacion1_ano', name: 'cotizacion1_ano' },
                    { data: 'cotizacion1_numero', name: 'cotizacion1_numero' },
                    { data: 'cotizacion1_fecha_inicio', name: 'cotizacion1_fecha_inicio' },
                    { data: 'tercero_nombre', name: 'tercero_nombre' },
                    { data: 'cotizacion1_abierta', name: 'cotizacion1_abierta' }
                ],
                order: [
                    [ 2, 'desc' ], [ 3, 'desc' ]
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            if( full.cotizacion1_precotizacion ){
                                return '<a href="'+ window.Misc.urlFull( Route.route('cotizaciones.show', {cotizaciones: full.id }) )  +'">' + data + '</a> <a href="'+ window.Misc.urlFull( Route.route('precotizaciones.show', {precotizaciones: full.cotizacion1_precotizacion }) ) +'" title="Ir a precotización"><span class="label label-success">PRE</span></a>';
                            }else{
                                return '<a href="'+ window.Misc.urlFull( Route.route('cotizaciones.show', {cotizaciones: full.id }) )  +'">' + data + '</a>';
                            }
                        }
                    },
                    {
                        targets: 1,
                        orderable: false,
                        width: '8%',
                        className: 'text-center',
                        render: function ( data, type, full, row ) {
                            const close = '<a class="btn btn-danger btn-xs close-cotizacion" title="Cerrar cotización" data-resource="'+ full.id +'" data-code="'+ full.cotizacion_codigo +'" data-refer="'+ full.tercero_nombre+'"><i class="fa fa-lock"></i></a>';
                            const open = '<a class="btn btn-danger btn-xs open-cotizacion" title="Reabrir cotización" data-resource="'+ full.id +'" data-code="'+ full.cotizacion_codigo +'" data-refer="'+ full.tercero_nombre+'"><i class="fa fa-unlock"></i></a>';
                            const clone = '<a class="btn btn-danger btn-xs clone-cotizacion" title="Clonar cotización" data-resource="'+ full.id +'" data-code="'+ full.cotizacion_codigo +'" data-refer="'+ full.tercero_nombre+'"><i class="fa fa-clone"></i></a>';
                            const generate = '<a class="btn btn-danger btn-xs generate-cotizacion" title="Generar orden de producción" data-resource="'+ full.id +'" data-code="'+ full.cotizacion_codigo +'" data-refer="'+ full.tercero_nombre+'"><i class="fa fa-sticky-note"></i></a>';
                            var buttons = '';

                            if ( parseInt(full.cotizacion_create) ){
                                buttons += parseInt(full.cotizacion1_abierta) ? close : open;
                            }

                            if ( parseInt(full.cotizacion_opcional) ){
                                buttons += ' ' + clone + ' ';

                                buttons += parseInt(full.cotizacion1_abierta) ? generate : '';
                            }

                            return buttons ? buttons : ' - ';
                        }
                    },
                    {
                        targets: [2, 3],
                        visible: false
                    },
                    {
                        targets: 4,
                        width: '10%'
                    },
                    {
                        targets: 5,
                        width: '63%'
                    },
                    {
                        targets: 6,
                        width: '7%',
                        searchable: false,
                        orderable: false,
                        render: function ( data, type, full, row ) {
                            if( parseInt(full.cotizacion1_anulada) ) {
                                return '<span class="label label-danger">ANULADA</span>';
                            } else if( parseInt(full.cotizacion1_abierta) ) {
                                return '<span class="label label-success">ABIERTA</span>';
                            } else {
                                return '<span class="label label-warning">CERRADA</span>';
                            }
                        }
                    }
                ],
                fnRowCallback: function( row, data ) {
                    if ( parseInt(data.cotizacion1_anulada) ) {
                        $(row).css( {"color":"#DD4B39"} );
                    }else if ( parseInt(data.cotizacion1_abierta) ) {
                        $(row).css( {"color":"#00A65A"} );
                    }else{
                        $(row).css( {"color":"black"} );
                    }
                }
            });
        },

        search: function(e) {
            e.preventDefault();

            this.cotizacionesSearchTable.ajax.reload();
        },

        clear: function(e) {
            e.preventDefault();

            this.$searchcotizacionCotizacion.val('');
            this.$searchcotizacionTercero.val('');
            this.$searchcotizacionTerceroName.val('');
            this.$searchcotizacionEstado.val('');
            this.$searchcotizacionReferencia.val('');
            this.$searchcotizacionProductop.val('').trigger('change');

            this.cotizacionesSearchTable.ajax.reload();
        },

        /**
        * Close cotizacion
        */
        closeCotizacion: function (e) {
            e.preventDefault();
            var _this = this,
                model = this.$(e.currentTarget).data();

            var cancelConfirm = new window.app.ConfirmWindow({
                parameters: {
                    dataFilter: { cotizacion_codigo: model.code },
                    template: _.template( ($('#cotizacion-close-confirm-tpl').html() || '') ),
                    titleConfirm: 'Cerrar cotización',
                    onConfirm: function () {
                        // Close cotizacion
                        $.ajax({
                            url: window.Misc.urlFull( Route.route('cotizaciones.cerrar', { cotizaciones: model.resource }) ),
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

                                window.Misc.successRedirect( resp.msg, window.Misc.urlFull(Route.route('cotizaciones.show', { cotizaciones: model.resource })) );
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
        * Clone cotizacion
        */
        cloneCotizacion: function (e) {
            e.preventDefault();

            var _this = this,
                model = this.$(e.currentTarget).data(),
                route =  window.Misc.urlFull( Route.route('cotizaciones.clonar', { cotizaciones: model.resource }) ),
                data = { cotizacion_codigo: model.code };

            var cloneConfirm = new window.app.ConfirmWindow({
                parameters: {
                    dataFilter: data,
                    template: _.template( ($('#cotizacion-clone-confirm-tpl').html() || '') ),
                    titleConfirm: 'Clonar cotización',
                    onConfirm: function () {
                        // Clone cotizacion
                        window.Misc.cloneModule({
                            'url': route,
                            'wrap': _this.el,
                            'callback': (function (_this) {
                                return function ( resp ) {
                                    window.Misc.successRedirect( resp.msg, window.Misc.urlFull(Route.route('cotizaciones.edit', { cotizaciones: resp.id })) );
                                }
                            })(_this)
                        });
                    }
                }
            });

            cloneConfirm.render();
        },

        /**
        * Generate cotizacion
        */
        generateCotizacion: function (e) {
            e.preventDefault();

            var _this = this,
                model = this.$(e.currentTarget).data(),
                route =  window.Misc.urlFull( Route.route('cotizaciones.generar', { cotizaciones: model.resource }) ),
                data = { cotizacion_codigo: model.code, cotizacion_referencia: model.refer };

            var cloneConfirm = new window.app.ConfirmWindow({
                parameters: {
                    dataFilter: data,
                    template: _.template( ($('#cotizacion-generate-confirm-tpl').html() || '') ),
                    titleConfirm: 'Generar orden de producción',
                    onConfirm: function () {
                        // Generate orden
                        $.ajax({
                            url: route,
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

                                window.Misc.successRedirect( resp.msg, window.Misc.urlFull(Route.route('ordenes.edit', { ordenes: resp.orden_id })) );
                            }
                        })
                        .fail(function(jqXHR, ajaxOptions, thrownError) {
                            window.Misc.removeSpinner( _this.el );
                            alertify.error(thrownError);
                        });
                    }
                }
            });

            cloneConfirm.render();
        },

        /**
        * Open cotizacion
        */
        openCotizacion: function (e) {
            e.preventDefault();

            var _this = this,
                model = this.$(e.currentTarget).data();

            var cancelConfirm = new window.app.ConfirmWindow({
                parameters: {
                    dataFilter: { cotizacion_codigo: model.code },
                    template: _.template( ($('#cotizacion-open-confirm-tpl').html() || '') ),
                    titleConfirm: 'Reabir cotización',
                    onConfirm: function () {
                        // Open cotizacion
                        $.ajax({
                            url: window.Misc.urlFull( Route.route('cotizaciones.abrir', { cotizaciones: model.resource }) ),
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

                                window.Misc.successRedirect( resp.msg, window.Misc.urlFull(Route.route('cotizaciones.edit', { cotizaciones: model.resource })) );
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
