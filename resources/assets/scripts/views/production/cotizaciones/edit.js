/**
* Class EditCotizacionView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.EditCotizacionView = Backbone.View.extend({

        el: '#cotizaciones-create',
        template: _.template( ($('#add-cotizacion-tpl').html() || '') ),
        events: {
            'click .submit-cotizacion': 'submitCotizacion',
            'click .state-cotizacion': 'stateCotizacion',
            'click .clone-cotizacion': 'cloneCotizacion',
            'click .generate-cotizacion': 'generateCotizacion',
            'click .export-cotizacion': 'exportCotizacion',
            'change #typeproductop': 'changeTypeProduct',
            'change #subtypeproductop': 'changeSubtypeProduct',
            'submit #form-cotizaciones': 'onStore',
            'click .change-producto': 'changeProducto',
            'change .change-producto': 'changeProducto',
            'submit #form-productosp3': 'onStoreProducto'
        },
        parameters: {},

        /**
        * Constructor Method
        */
        initialize: function (opts) {
            // Initialize
            if (opts !== undefined && _.isObject(opts.parameters))
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            _.bindAll(this, 'onCompleteLoadFile', 'onSessionRequestComplete');

            this.productopCotizacionList = new app.ProductopCotizacionList();
            this.bitacoraCotizacionList = new app.BitacoraCotizacionList();

            // Events
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        /*
        * Render View Element
        */
        render: function () {
            var attributes = this.model.toJSON();
                attributes.edit = true;
            this.$el.html(this.template(attributes));

            this.$product = this.$('#productop');
            this.$subtypeproduct = this.$('#subtypeproductop');
            this.$form = this.$('#form-cotizaciones');
            this.spinner = this.$('#spinner-main');
            this.$renderChartProductos = this.$('#render-chart-cotizacion');

            // Initialize fineuploader && textarea tab imagenes
            this.$inputObservaciones = this.$('#cotizacion1_observaciones_archivo');
            this.$uploaderFile = this.$('.fine-uploader');

            // Reference views and ready
            if ($('.chart-container').length) {
                this.referenceCharts();
            }
            
            this.referenceViews();
            this.uploadPictures();
            this.ready();
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            // Productos list
            this.productopCotizacionListView = new app.ProductopCotizacionListView({
                collection: this.productopCotizacionList,
                parameters: {
                    edit: true,
                    iva: this.model.get('cotizacion1_iva'),
                    wrapper: this.spinner,
                    dataFilter: {
                        cotizacion2_cotizacion: this.model.get('id')
                    }
               }
            });

            // Bitacora list
            this.bitacoraListView = new app.BitacoraListView({
                collection: this.bitacoraCotizacionList,
                parameters: {
                    wrapper: this.spinner,
                    dataFilter: {
                        cotizacion: this.model.get('id')
                    }
               }
            });
        },

        /**
        * Event submit productop
        */
        submitCotizacion: function (e) {
            this.$form.submit();
        },

        /**
        * Event Create cotizacion
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
                    data.cotizacion1_observaciones_archivo = this.$inputObservaciones.val();
                this.model.save(data, {wait: true, patch: true, silent: true});
            }
        },

        /**
        * Event change type
        */
        changeTypeProduct: function(e) {
            var typeproduct = this.$(e.currentTarget).val(),
                _this = this;

            if (typeof(typeproduct) !== 'undefined' && !_.isUndefined(typeproduct) && !_.isNull(typeproduct) && typeproduct != '') {
                $.ajax({
                    url: window.Misc.urlFull(Route.route('search.subtipoproductosp', {typeproduct: typeproduct})),
                    type: 'GET',
                    beforeSend: function () {
                        window.Misc.setSpinner(_this.spinner);
                    }
                })
                .done(function (resp) {
                    window.Misc.removeSpinner(_this.spinner);
                    _this.$product.empty().val(0).attr('disabled', 'disabled');
                    _this.$subtypeproduct.empty().val(0).removeAttr('disabled');
                    _this.$subtypeproduct.append("<option value=></option>");
                    _.each(resp, function (item) {
                        _this.$subtypeproduct.append("<option value=" + item.id + ">" + item.subtipoproductop_nombre + "</option>");
                    });

                })
                .fail(function (jqXHR, ajaxOptions, thrownError) {
                    window.Misc.removeSpinner(_this.spinner);
                    alertify.error(thrownError);
                });
            } else {
                this.$subtypeproduct.empty().val(0).attr('disabled', 'disabled');
                this.$product.empty().val(0).attr('disabled', 'disabled');
            }
        },

        /**
        * Event change subtupe
        */
        changeSubtypeProduct: function (e) {
            var subtypeproduct = this.$(e.currentTarget).val(),
                typeproduct = this.$('#typeproductop').val(),
                _this = this;

            if (typeof(subtypeproduct) !== 'undefined' && !_.isUndefined(subtypeproduct) && !_.isNull(subtypeproduct) && subtypeproduct != '') {
                $.ajax({
                    url: window.Misc.urlFull(Route.route('search.productosp')),
                    data: {
                        subtypeproduct: subtypeproduct,
                        typeproduct: typeproduct
                    },
                    type: 'GET',
                    beforeSend: function () {
                        window.Misc.setSpinner(_this.spinner);
                    }
                })
                .done(function (resp) {
                    window.Misc.removeSpinner(_this.spinner);
                    _this.$product.empty().val(0).removeAttr('disabled');
                    _this.$product.append("<option value=></option>");
                    _.each(resp, function (item) {
                        _this.$product.append("<option value=" + item.id + ">" + item.productop_nombre + "</option>");
                    });
                })
                .fail(function (jqXHR, ajaxOptions, thrownError) {
                    window.Misc.removeSpinner(_this.spinner);
                    alertify.error(thrownError);
                });
            }
        },

        /**
        * export to PDF
        */
        exportCotizacion: function (e) {
            e.preventDefault();

            // Redirect to pdf
            window.open( window.Misc.urlFull(Route.route('cotizaciones.exportar', {cotizaciones: this.model.get('cotizacion_codigo')})), '_blank');
        },

        /**
        * Close cotizacion
        */
        stateCotizacion: function (e) {
            e.preventDefault();

            var state = this.$(e.currentTarget).data('state'),
                method = this.$(e.currentTarget).data('method'),
                name = this.$(e.currentTarget).text(),
                new_state = window.Misc.previewState(state, method),
                _this = this;

            if (state != new_state) {
                if (['CN', 'CR', 'CO'].indexOf(state) !== -1) {
                    new_state = state;
                }

                var stateConfirm = new window.app.ConfirmWindow({
                    parameters: {
                        dataFilter: {
                            estado: window.Misc.stateProduction(new_state),
                            codigo: _this.model.get('cotizacion_codigo')
                        },
                        template: _.template(($('#cotizacion-state-confirm-tpl').html() || '')),
                        titleConfirm: 'Estado cotización',
                        onConfirm: function () {
                            // State cotizacion
                            $.ajax({
                                url: window.Misc.urlFull(Route.route('cotizaciones.estados', {cotizaciones: _this.model.get('id')})),
                                data: {
                                    state: state,
                                    method: method
                                },
                                type: 'GET',
                                beforeSend: function () {
                                    window.Misc.setSpinner(_this.spinner);
                                }
                            })
                            .done(function (resp) {
                                window.Misc.removeSpinner(_this.spinner);
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

                                    window.Misc.successRedirect(resp.msg, window.Misc.urlFull(Route.route('cotizaciones.edit', {cotizaciones: _this.model.get('id')})));
                                }
                            })
                            .fail(function (jqXHR, ajaxOptions, thrownError) {
                                window.Misc.removeSpinner(_this.spinner);
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

            var _this = this,
                route =  window.Misc.urlFull(Route.route('cotizaciones.clonar', {cotizaciones: this.model.get('id')})),
                data = {
                    cotizacion_codigo: _this.model.get('cotizacion_codigo')
                };

            var cloneConfirm = new window.app.ConfirmWindow({
                parameters: {
                    dataFilter: data,
                    template: _.template( ($('#cotizacion-clone-confirm-tpl').html() || '') ),
                    titleConfirm: 'Clonar cotización',
                    onConfirm: function () {
                        // Clone cotizacion
                        window.Misc.cloneModule({
                            'url': route,
                            'wrap': _this.spinner,
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

            var _this = this,
                route =  window.Misc.urlFull(Route.route('cotizaciones.generar', {cotizaciones: this.model.get('id')})),
                data = {
                    cotizacion_codigo: _this.model.get('cotizacion_codigo'),
                    cotizacion_referencia: _this.model.get('cotizacion1_referencia')
                };

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
                                window.Misc.setSpinner( _this.spinner );
                            }
                        })
                        .done(function(resp) {
                            window.Misc.removeSpinner( _this.spinner );

                            if(!_.isUndefined(resp.success)) {
                                // response success or error
                                var text = resp.success ? '' : resp.errors;
                                if (_.isObject( resp.errors ) ) {
                                    text = window.Misc.parseErrors(resp.errors);
                                }

                                if (!resp.success ) {
                                    alertify.error(text);
                                    return;
                                }

                                window.Misc.successRedirect( resp.msg, window.Misc.urlFull(Route.route('ordenes.edit', { ordenes: resp.orden_id })) );
                            }
                        })
                        .fail(function(jqXHR, ajaxOptions, thrownError) {
                            window.Misc.removeSpinner( _this.spinner );
                            alertify.error(thrownError);
                        });
                    }
                }
            });

            cloneConfirm.render();
        },

        /**
        * Reference charts
        */
        referenceCharts: function () {
            var _this = this;

            // Ajax charts
            $.ajax({
                url: window.Misc.urlFull(Route.route('cotizaciones.graficas', {cotizaciones: _this.model.get('id')})),
                type: 'GET',
                beforeSend: function () {
                    window.Misc.setSpinner(_this.spinner);
                }
            })
            .done(function(resp) {
                window.Misc.removeSpinner(_this.spinner);
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

                    // Render calendar
                    _this.charts(resp);
                }
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                window.Misc.removeSpinner(_this.spinner);
                alertify.error(thrownError);
            });

        },

        /**
        * charts
        */
        charts: function (resp) {
            // Definir opciones globales para graficas del modulo
            Chart.defaults.global.defaultFontColor="black";
            Chart.defaults.global.defaultFontSize=12;
            Chart.defaults.global.title.fontSize=14;

            // Charts productos
            if (!_.isEmpty(resp.chartproductos.data)) {
                var ctx = this.$('#chart_producto').get(0).getContext('2d');

                new Chart(ctx, {
                    type: 'pie',
                    data: {
                        datasets: [{
                            backgroundColor: [
                                '#CD5C5C', '#F08080', '#FA8072', '#E9967A', '#FFA07A', '#DC143C'
                            ],
                            data: resp.chartproductos.data
                        }],
                        labels: resp.chartproductos.labels
                    },
                    options: {
                        responsive: true,
                        title: {
                            display: false,
                        },
                        legend: {
                            display: true,
                            position: 'right',
                        },
                        tooltips: {
                            callbacks: {
                                enabled: false,
                                label: function(item, data) {
                                    return data.labels[item.index];
                                }
                            }
                        },
                        plugins: {
                            labels: {
                                render: 'percentage',
                                precision: 2,
                                position: 'outside',
                                arc: false
                            }
                        }
                    }
                });
            }
        },

        /**
        * UploadPictures
        */
        uploadPictures: function(e) {
            var _this = this;

            this.$uploaderFile.fineUploader({
                debug: false,
                template: 'qq-template-cotizacion',
                multiple: true,
                autoUpload: true,
                session: {
                    endpoint: window.Misc.urlFull(Route.route('cotizaciones.archivos.index')),
                    params: {
                        cotizacion: this.model.get('id'),
                    },
                    refreshOnRequest: false
                },
                request: {
                    inputName: 'file',
                    endpoint: window.Misc.urlFull(Route.route('cotizaciones.archivos.index')),
                    params: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        cotizacion: this.model.get('id')
                    }
                },
                retry: {
                    maxAutoAttempts: 3,
                },
                deleteFile: {
                    enabled: true,
                    forceConfirm: true,
                    confirmMessage: '¿Esta seguro de que desea eliminar este archivo de forma permanente? {filename}',
                    endpoint: window.Misc.urlFull( Route.route('cotizaciones.archivos.index') ),
                    params: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        cotizacion: this.model.get('id')
                    }
                },
                thumbnails: {
                    placeholders: {
                        notAvailablePath: window.Misc.urlFull("build/css/placeholders/not_available-generic.png"),
                        waitingPath: window.Misc.urlFull("build/css/placeholders/waiting-generic.png")
                    }
                },
                validation: {
                    itemLimit: 10,
                    sizeLimit: ( 3 * 1024 ) * 1024, // 3mb,
                    allowedExtensions: ['jpeg', 'jpg', 'png', 'pdf']
                },
                messages: {
                    typeError: '{file} extensión no valida. Extensiones validas: {extensions}.',
                    sizeError: '{file} es demasiado grande, el tamaño máximo del archivo es {sizeLimit}.',
                    tooManyItemsError: 'No puede seleccionar mas de {itemLimit} archivos.',
                },
                callbacks: {
                    onComplete: _this.onCompleteLoadFile,
                    onSessionRequestComplete: _this.onSessionRequestComplete,
                },
            });
        },

        /**
        * complete upload of file
        * @param Number id
        * @param Strinf name
        * @param Object resp
        */
        onCompleteLoadFile: function (id, name, resp) {
            var itemFile = this.$uploaderFile.fineUploader('getItemByFileId', id);
            this.$uploaderFile.fineUploader('setUuid', id, resp.id);
            this.$uploaderFile.fineUploader('setName', id, resp.name);

            var previewLink = this.$uploaderFile.fineUploader('getItemByFileId', id).find('.preview-link');
                previewLink.attr("href", resp.url);
        },

        onSessionRequestComplete: function (id, name, resp) {
            _.each( id, function (value, key){
                var previewLink = this.$uploaderFile.fineUploader('getItemByFileId', key).find('.preview-link');
                    previewLink.attr("href", value.thumbnailUrl);
            }, this);
        },

        changeProducto: function (e) {
            this.option = $(e.currentTarget).attr('data-state');
        },

        onStoreProducto: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson(e.target),
                    _this;

                if (this.option) {
                    data.option = this.option;

                    // Ajax charts
                    $.ajax({
                        url: window.Misc.urlFull(Route.route('cotizaciones.productos.producto')),
                        data: data,
                        type: 'POST'
                    })
                    .done(function(resp) {
                        window.Misc.removeSpinner(this.el);
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

                            window.Misc.redirect(window.Misc.urlFull(Route.route('cotizaciones.productos.edit', {productos: resp.id})));
                        }
                    })
                    .fail(function(jqXHR, ajaxOptions, thrownError) {
                        window.Misc.removeSpinner(this.el);
                        alertify.error(thrownError);
                    });
                } else {
                    var data = window.Misc.formToJson(e.target);
                    window.Misc.redirect(window.Misc.urlFull(Route.route('cotizaciones.productos.create', data)));
                }
            }
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if (typeof window.initComponent.initToUpper == 'function')
                window.initComponent.initToUpper();

            if (typeof window.initComponent.initTimePicker == 'function')
                window.initComponent.initTimePicker();

            if (typeof window.initComponent.initSelect2 == 'function')
                window.initComponent.initSelect2();

            if (typeof window.initComponent.initValidator == 'function')
                window.initComponent.initValidator();

            if (typeof window.initComponent.initInputMask == 'function')
                window.initComponent.initInputMask();

            if (typeof window.initComponent.initDatePicker == 'function')
                window.initComponent.initDatePicker();

            if (typeof window.initComponent.initSpinner == 'function')
                window.initComponent.initSpinner();
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function (model, xhr, opts) {
            window.Misc.setSpinner(this.spinner);
        },

        /**
        * response of the server
        */
        responseServer: function (model, resp, opts) {
            window.Misc.removeSpinner(this.spinner);
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

                // Redirect to edit cotizacion
                window.Misc.redirect( window.Misc.urlFull( Route.route('cotizaciones.edit', { cotizaciones: resp.id}), { trigger:true } ));
            }
        }
    });

})(jQuery, this, this.document);
