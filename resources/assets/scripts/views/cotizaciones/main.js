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
            'click .state-cotizacion': 'stateCotizacion',
            'click .clone-cotizacion': 'cloneCotizacion',
            'click .generate-cotizacion': 'generateCotizacion',
            'click .open-cotizacion': 'openCotizacion',
            'click .export-cotizacion': 'exportCotizacion',
        },

        /**
        * Constructor Method
        */
        initialize: function () {
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
                    url: window.Misc.urlFull(Route.route('cotizaciones.index')),
                    data: function(data) {
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
                    { data: 'productos[0].total', name: 'productos[0].total' }
                ],
                order: [
                    [ 2, 'desc' ], [ 3, 'desc' ]
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function (data, type, full, row) {
                            if (full.cotizacion1_precotizacion) {
                                return '<a href="'+ window.Misc.urlFull(Route.route('cotizaciones.show', {cotizaciones: full.id }))  +'">' + data + '</a> <a href="'+ window.Misc.urlFull(Route.route('precotizaciones.show', {precotizaciones: full.cotizacion1_precotizacion })) +'" title="Ir a precotización"><span class="label label-success">' + full.precotizacion_codigo + '</span></a>';
                            } else {
                                return '<a href="'+ window.Misc.urlFull(Route.route('cotizaciones.show', {cotizaciones: full.id }))  +'">' + data + '</a>';
                            }
                        }
                    },
                    {
                        targets: 1,
                        orderable: false,
                        width: '13%',
                        className: 'text-center',
                        render: function (data, type, full, row) {
                            const close = '<div class="btn-group btn-group-xs">' +
                            '<a class="btn btn-danger dropdown-toggle" data-toggle="dropdown" title="Cerrar cotización" role="button"><i class="fa fa-lock"></i> <span class="caret"></span></a>' +
                            '<ul class="dropdown-menu pull-right">' +
                            '<li><a href="#" class="state-cotizacion" data-state="CR" data-resource="' + full.id + '" data-code="' + full.cotizacion_codigo + '">RECOTIZAR</a></li>' +
                            '<li><a href="#" class="state-cotizacion" data-state="CN" data-resource="' + full.id + '" data-code="' + full.cotizacion_codigo + '">NO ACEPTADA</a></li>' +
                            '</ul></div>';

                            const exportar = '<a class="btn btn-danger export-cotizacion" data-resource="' + full.id + '" data-code="' + full.cotizacion_codigo + '" title="Exportar cotización"><i class="fa fa-file-pdf-o"></i></a>';

                            const prev = '<a class="btn btn-success btn-xs state-cotizacion" title="Estado anterior de la cotización" data-resource="' + full.id + '" data-state="' + full.cotizacion1_estados + '" data-method="prev"><i class="fa fa-arrow-left"></i></a>';

                            const next = '<a class="btn btn-success btn-xs state-cotizacion" title="Siguiente estado de la cotización" data-resource="' + full.id + '" data-state="' + full.cotizacion1_estados + '" data-method="next"><i class="fa fa-arrow-right"></i></a>';

                            const open = '<a class="btn btn-danger btn-xs open-cotizacion" title="Reabrir cotización" data-resource="' + full.id + '" data-code="' + full.cotizacion_codigo + '" data-refer="' + full.tercero_nombre + '"><i class="fa fa-unlock"></i></a>';

                            const clone = '<a class="btn btn-danger btn-xs clone-cotizacion" title="Clonar cotización" data-resource="' + full.id + '" data-code="' + full.cotizacion_codigo + '" data-refer="' + full.tercero_nombre + '"><i class="fa fa-clone"></i></a>';

                            const generate = '<a class="btn btn-danger btn-xs generate-cotizacion" title="Generar orden de producción" data-resource="' + full.id + '" data-code="' + full.cotizacion_codigo + '" data-refer="' + full.tercero_nombre + '"><i class="fa fa-sticky-note"></i></a>';

                            var buttons = '';

                            if (parseInt(full.isOptional) || parseInt(full.isAdmin)) {
                                if (['CC' , 'CF', 'CS'].indexOf(full.cotizacion1_estados) !== -1 && parseInt(full.cotizacion1_abierta)) {
                                    buttons += close;
                                } else if (!parseInt(full.cotizacion1_abierta)) {
                                    buttons += open;
                                }
                                buttons += clone;
                            }

                            if (['PC' , 'PF'].indexOf(full.cotizacion1_estados) === -1) {
                                buttons += exportar;
                            }

                            if (parseInt(full.cotizacion1_abierta)) {
                                if (parseInt(full.isAdmin)) {
                                    if (full.cotizacion1_estados != 'PC') {
                                        buttons += prev;
                                    }
                                }

                                if (parseInt(full.isOptional) || parseInt(full.isAdmin)) {
                                    if (full.cotizacion1_estados != 'CS') {
                                        buttons += next;
                                    }
                                }
                            }
                            return '<div class="btn-group btn-group-justified btn-group-xs" role="group">' + buttons + '</div>';
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
                        width: '63%',
                        render: function (data, type, full, row) {
                            var estado = window.Misc.stateProduction(full.cotizacion1_estados);
                            return data + ' <span class="label label-' + estado.color + '">' + estado.nombre + '</span>';
                        }
                    },
                    {
                        targets: 6,
                        width: '7%',
                        searchable: false,
                        orderable: false,
                        className: 'text-right',
                        render: function (data, type, full, row) {
                            return parseInt(full.isAdmin) ? window.Misc.currency(parseFloat(data)) : '-';
                        }
                    },
                ],
                fnRowCallback: function(row, data) {
                    if (parseInt(data.cotizacion1_anulada)) {
                        $(row).css({color: "#DD4B39"});
                    } else if (parseInt(data.cotizacion1_abierta)) {
                        $(row).css({color: "#00A65A"});
                    } else {
                        $(row).css({color: "black"});
                    }
                }
            });
        },

        /**
        * Search dataTable
        */
        search: function(e) {
            e.preventDefault();

            this.cotizacionesSearchTable.ajax.reload();
        },

        /**
        * Clear dataTable
        */
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
        stateCotizacion: function (e) {
            e.preventDefault();

            var data = this.$(e.currentTarget).data(),
                name = this.$(e.currentTarget).text(),
                method = this.$(e.currentTarget).data('method'),
                new_state = window.Misc.previewState(data.state, method),
                _this = this;

            if (data.state != new_state) {
                if (['CN', 'CR', 'CO'].indexOf(data.state) !== -1) {
                    new_state = data.state;
                }

                var stateConfirm = new window.app.ConfirmWindow({
                    parameters: {
                        dataFilter: {
                            estado: window.Misc.stateProduction(new_state),
                            codigo: data.code
                        },
                        template: _.template(($('#cotizacion-state-confirm-tpl').html() || '')),
                        titleConfirm: 'Estado cotización',
                        onConfirm: function () {
                            $.ajax({
                                url: window.Misc.urlFull(Route.route('cotizaciones.estados', {cotizaciones: data.resource})),
                                type: 'GET',
                                data: {
                                    state: data.state
                                },
                                beforeSend: function () {
                                    window.Misc.setSpinner(_this.el);
                                }
                            })
                            .done(function (resp) {
                                window.Misc.removeSpinner(_this.el);
                                if (!_.isUndefined(resp.success)) {
                                    // response success or error
                                    var text = resp.success ? '' : resp.errors;
                                    if (_.isObject(resp.errors)) {
                                        text = window.Misc.parseErrors(resp.errors);
                                    }

                                    if (!resp.success) {
                                        alertify.error(text);
                                        return;
                                    }

                                    alertify.success(resp.msg);
                                    _this.cotizacionesSearchTable.ajax.reload();
                                }
                            })
                            .fail(function (jqXHR, ajaxOptions, thrownError) {
                                window.Misc.removeSpinner(_this.el);
                                alertify.error(thrownError);
                            });
                        }
                    }
                });
                stateConfirm.render();
            }
        },

        /**
        * Clone cotizacion
        */
        cloneCotizacion: function (e) {
            e.preventDefault();

            var model = this.$(e.currentTarget).data(),
                route =  window.Misc.urlFull(Route.route('cotizaciones.clonar', { cotizaciones: model.resource })),
                _this = this;

            var cloneConfirm = new window.app.ConfirmWindow({
                parameters: {
                    dataFilter: {
                        cotizacion_codigo: model.code
                    },
                    template: _.template(($('#cotizacion-clone-confirm-tpl').html() || '')),
                    titleConfirm: 'Clonar cotización',
                    onConfirm: function () {
                        // Clone cotizacion
                        window.Misc.cloneModule({
                            'url': route,
                            'wrap': _this.el,
                            'callback': (function (_this) {
                                return function (resp) {
                                    window.Misc.successRedirect(resp.msg, window.Misc.urlFull(Route.route('cotizaciones.edit', {cotizaciones: resp.id})));
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

            var model = this.$(e.currentTarget).data(),
                route =  window.Misc.urlFull(Route.route('cotizaciones.generar', {cotizaciones: model.resource})),
                _this = this;

            var generateConfirm = new window.app.ConfirmWindow({
                parameters: {
                    dataFilter: {
                        cotizacion_codigo: model.code,
                        cotizacion_referencia: model.refer
                    },
                    template: _.template(($('#cotizacion-generate-confirm-tpl').html() || '')),
                    titleConfirm: 'Generar orden de producción',
                    onConfirm: function () {
                        // Generate orden
                        $.ajax({
                            url: route,
                            type: 'GET',
                            beforeSend: function () {
                                window.Misc.setSpinner(_this.el);
                            }
                        })
                        .done(function (resp) {
                            window.Misc.removeSpinner(_this.el);
                            if (!_.isUndefined(resp.success)) {
                                // response success or error
                                var text = resp.success ? '' : resp.errors;
                                if (_.isObject(resp.errors)) {
                                    text = window.Misc.parseErrors(resp.errors);
                                }

                                if (!resp.success) {
                                    alertify.error(text);
                                    return;
                                }
                                window.Misc.successRedirect(resp.msg, window.Misc.urlFull(Route.route('ordenes.edit', {ordenes: resp.orden_id})));
                            }
                        })
                        .fail(function (jqXHR, ajaxOptions, thrownError) {
                            window.Misc.removeSpinner(_this.el);
                            alertify.error(thrownError);
                        });
                    }
                }
            });
            generateConfirm.render();
        },

        /**
        * Open cotizacion
        */
        openCotizacion: function (e) {
            e.preventDefault();

            var model = this.$(e.currentTarget).data(),
                _this = this;

            var openConfirm = new window.app.ConfirmWindow({
                parameters: {
                    dataFilter: {
                        cotizacion_codigo: model.code
                    },
                    template: _.template(($('#cotizacion-open-confirm-tpl').html() || '')),
                    titleConfirm: 'Reabir cotización',
                    onConfirm: function () {
                        $.ajax({
                            url: window.Misc.urlFull(Route.route('cotizaciones.abrir', {cotizaciones: model.resource})),
                            type: 'GET',
                            beforeSend: function () {
                                window.Misc.setSpinner(_this.el);
                            }
                        })
                        .done(function (resp) {
                            window.Misc.removeSpinner(_this.el);
                            if (!_.isUndefined(resp.success)) {
                                // response success or error
                                var text = resp.success ? '' : resp.errors;
                                if (_.isObject(resp.errors)) {
                                    text = window.Misc.parseErrors(resp.errors);
                                }

                                if (!resp.success) {
                                    alertify.error(text);
                                    return;
                                }

                                window.Misc.successRedirect(resp.msg, window.Misc.urlFull(Route.route('cotizaciones.edit', {cotizaciones: model.resource})));
                            }
                        })
                        .fail(function (jqXHR, ajaxOptions, thrownError) {
                            window.Misc.removeSpinner(_this.el);
                            alertify.error(thrownError);
                        });
                    }
                }
            });
            openConfirm.render();
        },

        /**
        * export to PDF
        */
        exportCotizacion: function (e) {
            e.preventDefault();

            // Redirect to pdf
            window.open(window.Misc.urlFull(Route.route('cotizaciones.exportar', {cotizaciones: $(e.currentTarget).data('code')})), '_blank');
        },
    });
})(jQuery, this, this.document);
