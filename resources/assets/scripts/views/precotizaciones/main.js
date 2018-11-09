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
            'click .close-precotizacion': 'closePreCotizacion',
            'click .clone-precotizacion': 'clonePreCotizacion',
            'click .finish-precotizacion': 'finishPreCotizacion',
            'click .open-precotizacion': 'openPreCotizacion',
            'click .generate-precotizacion': 'generatePreCotizacion',
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
            var paginacion = this.$precotizacionesSearchTable.data('paginacion');

            this.precotizacionesSearchTable = this.$precotizacionesSearchTable.DataTable({
                dom: "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: true,
                language: window.Misc.dataTableES(),
                pageLength: paginacion,
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
                    { data: 'precotizacion1_abierta', name: 'precotizacion1_abierta' },
                    { data: 'id', name: 'id' },
                    { data: 'id', name: 'id' },
                    { data: 'id', name: 'id' },
                    { data: 'id', name: 'id' }
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
                    },
                    {
                        targets: 3,
                        width: '60%',
                    },
                    {
                        targets: 4,
                        width: '7%',
                    },
                    {
                        targets: 5,
                        width: '10%',
                        searchable: false,
                        orderable: false,
                        render: function ( data, type, full, row ) {
                            if( parseInt(full.precotizacion1_terminada) ) {
                                return '<span class="label label-primary">TERMINADA</span>';
                            } else if( parseInt(full.precotizacion1_abierta) ) {
                                return '<span class="label label-success">ABIERTA</span>';
                            } else {
                                return '<span class="label label-danger">CERRADA</span>';
                            }
                        }
                    },
                    {
                        targets: 6,
                        orderable: false,
                        width: '3%',
                        className: "text-center",
                        render: function ( data, type, full, row ) {
                            if( parseInt(full.precotizacion1_abierta) ){
                                return '<a class="btn btn-success btn-xs close-precotizacion" title="Cerrar pre-cotización" data-resource="'+ data +'" data-code="'+ full.precotizacion_codigo +'" data-refer="'+ full.tercero_nombre+'"><i class="fa fa-lock"></i></a>';
                            }else{
                                return '<a class="btn btn-success btn-xs open-precotizacion" title="Reabrir pre-cotización" data-resource="'+ data +'" data-code="'+ full.precotizacion_codigo +'" data-refer="'+ full.tercero_nombre+'"><i class="fa fa-unlock"></i></a>';
                            }
                        }
                    },
                    {
                        targets: 7,
                        orderable: false,
                        width: '3%',
                        className: "text-center",
                        render: function ( data, type, full, row ) {
                            if( !parseInt(full.precotizacion1_terminada) ){
                                return '<a class="btn btn-success btn-xs finish-precotizacion" title="Terminar pre-cotización" data-resource="'+ data +'" data-code="'+ full.precotizacion_codigo +'" data-refer="'+ full.tercero_nombre+'"><i class="fa fa-handshake-o"></i></a>';
                            }else{
                                return '';
                            }
                        }
                    },
                    {
                        targets: 8,
                        orderable: false,
                        width: '3%',
                        className: "text-center",
                        render: function ( data, type, full, row ) {
                            return '<a class="btn btn-success btn-xs clone-precotizacion" title="Clonar pre-cotización" data-resource="'+ data +'" data-code="'+ full.precotizacion_codigo +'" data-refer="'+ full.tercero_nombre+'"><i class="fa fa-clone"></i></a>';
                        }
                    },
                    {
                        targets: 9,
                        orderable: false,
                        width: '3%',
                        className: "text-center",
                        render: function ( data, type, full, row ) {
                            return '<a class="btn btn-success btn-xs generate-precotizacion" title="Generar cotización" data-resource="'+ data +'" data-code="'+ full.precotizacion_codigo +'" data-refer="'+ full.tercero_nombre+'"><i class="fa fa-envelope-o"></i></a>';
                        }
                    },
                ],
                fnRowCallback: function( row, data ) {
                    if ( parseInt(data.precotizacion1_terminada) ) {
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
            this.$searchprecotizacionEstado.val('');

            this.precotizacionesSearchTable.ajax.reload();
        },

        /**
        * Close pre-cotizacion
        */
        closePreCotizacion: function (e) {
            e.preventDefault();
            var _this = this;
                model = this.$(e.currentTarget).data();

            var cancelConfirm = new window.app.ConfirmWindow({
                parameters: {
                    dataFilter: { precotizacion_codigo: model.code },
                    template: _.template( ($('#precotizacion-close-confirm-tpl').html() || '') ),
                    titleConfirm: 'Cerrar pre-cotización',
                    onConfirm: function () {
                        // Close orden
                        $.ajax({
                            url: window.Misc.urlFull( Route.route('precotizaciones.cerrar', { precotizaciones: model.resource }) ),
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

                                window.Misc.successRedirect( resp.msg, window.Misc.urlFull(Route.route('precotizaciones.show', { precotizaciones: model.resource })) );
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
        * Clone precotizacion
        */
        clonePreCotizacion: function (e) {
            e.preventDefault();

            var _this = this,
                model = this.$(e.currentTarget).data(),
                route = window.Misc.urlFull( Route.route('precotizaciones.clonar', { precotizaciones: model.resource }) ),
                data = { precotizacion_codigo: model.code };

            var cloneConfirm = new window.app.ConfirmWindow({
                parameters: {
                    dataFilter: data,
                    template: _.template( ($('#precotizacion-clone-confirm-tpl').html() || '') ),
                    titleConfirm: 'Clonar pre-cotización',
                    onConfirm: function () {
                        // Clone orden
                        window.Misc.cloneModule({
                            'url': route,
                            'wrap': _this.el,
                            'callback': (function (_this) {
                                return function ( resp ) {
                                    window.Misc.successRedirect( resp.msg, window.Misc.urlFull(Route.route('precotizaciones.edit', { precotizaciones: resp.id })) );
                                }
                            })(_this)
                        });
                    }
                }
            });

            cloneConfirm.render();
        },

        /**
        * finish pre-cotizacion
        */
        finishPreCotizacion: function (e) {
            e.preventDefault();
            var _this = this,
                model = this.$(e.currentTarget).data();

            var cancelConfirm = new window.app.ConfirmWindow({
                parameters: {
                    dataFilter: { precotizacion_codigo: model.code },
                    template: _.template( ($('#precotizacion-terminar-confirm-tpl').html() || '') ),
                    titleConfirm: 'Terminar pre-cotización',
                    onConfirm: function () {
                        // Close orden
                        $.ajax({
                            url: window.Misc.urlFull( Route.route('precotizaciones.terminar', { precotizaciones: model.resource }) ),
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

                                window.Misc.successRedirect( resp.msg, window.Misc.urlFull( Route.route('precotizaciones.show', { precotizaciones: model.resource })) );
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
        * Generate pre-cotizacion
        */
        generatePreCotizacion: function (e) {
            e.preventDefault();

            var _this = this,
                model = this.$(e.currentTarget).data();
                route =  window.Misc.urlFull( Route.route('precotizaciones.generar', { precotizaciones: model.resource }) ),
                data = { precotizacion_codigo: model.code, precotizacion_referencia: model.refer };

            var cancelConfirm = new window.app.ConfirmWindow({
                parameters: {
                    dataFilter: data,
                    template: _.template( ($('#precotizacion-generate-confirm-tpl').html() || '') ),
                    titleConfirm: 'Generar cotización',
                    onConfirm: function () {
                        // Close orden
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

                                // Redireccionar a cotizacion cuando todo este !OK
                                window.Misc.successRedirect( resp.msg, window.Misc.urlFull(Route.route('cotizaciones.edit', { cotizaciones: resp.cotizacion_id })) );
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
        * Open pre-cotizacion
        */
        openPreCotizacion: function (e) {
            e.preventDefault();
            var _this = this,
                model = this.$(e.currentTarget).data();

            var cancelConfirm = new window.app.ConfirmWindow({
                parameters: {
                    dataFilter: { precotizacion_codigo: model.code },
                    template: _.template( ($('#precotizaciones-open-confirm-tpl').html() || '') ),
                    titleConfirm: 'Reabir pre-cotización',
                    onConfirm: function () {
                        // Open pre-cotizacion
                        $.ajax({
                            url: window.Misc.urlFull( Route.route('precotizaciones.abrir', { precotizaciones: model.resource }) ),
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

                                window.Misc.successRedirect( resp.msg, window.Misc.urlFull(Route.route('precotizaciones.edit', { precotizaciones: model.resource })) );
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
    });
})(jQuery, this, this.document);
