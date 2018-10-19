/**
* Class EditOrdenpView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.EditOrdenpView = Backbone.View.extend({

        el: '#ordenes-create',
        template: _.template( ($('#add-ordenp-tpl').html() || '') ),
        templateEmpleado: _.template( ($('#chart-empleado-ordenp').html() || '') ),
        templateAreap: _.template( ($('#chart-areasp-ordenp').html() || '') ),
        templateProductop: _.template( ($('#chart-productop-ordenp').html() || '') ),
        events: {
            'click .submit-ordenp': 'submitOrdenp',
            'click .close-ordenp': 'closeOrdenp',
            'click .complete-ordenp': 'completeOrdenp',
            'click .clone-ordenp': 'cloneOrdenp',
            'click .export-ordenp': 'exportOrdenp',
            'change #typeproductop': 'changeTypeProduct',
            'change #subtypeproductop': 'changeSubtypeProduct',
            'submit #form-ordenes': 'onStore',
            'submit #form-despachosp': 'onStoreDespacho'
        },
        parameters: {
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
            _.bindAll(this, 'onCompleteLoadFile', 'onSessionRequestComplete');

            // Initialize
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            this.productopOrdenList = new app.ProductopOrdenList();
            this.despachopOrdenList = new app.DespachopOrdenList();
            this.despachospPendientesOrdenList = new app.DespachospPendientesOrdenList();
            this.asientoCuentasList = new app.AsientoCuentasList();

            // Tiempop general
            this.tiempopList = new app.TiempopList();

            // Events
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        /*
        * Render View Element
        */
        render: function() {
            var attributes = this.model.toJSON();
                attributes.edit = true;
            this.$el.html( this.template(attributes) );

            this.$form = this.$('#form-ordenes');
            this.$product = this.$('#productop');
            this.$subtypeproduct = this.$('#subtypeproductop');
            this.spinner = this.$('#spinner-main');

            // Render rows charts
            this.$renderChartEmpleado = this.$('#render-chart-empleado');
            this.$renderChartAreasp = this.$('#render-chart-areasp');
            this.$renderChartProductop = this.$('#render-chart-productop');

            // Initialize fineuploader && textarea tab imagenes
            this.$observacionesimagen = this.$('#orden_observaciones_imagen');
            this.$uploaderFile = this.$('.fine-uploader');

            // Reference views and ready
            this.referenceViews();
            this.referenceCharts();
            this.uploadPictures();
            this.ready();
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            // Productos list
            this.productopOrdenListView = new app.ProductopOrdenListView( {
                collection: this.productopOrdenList,
                parameters: {
                    edit: true,
                    iva: this.model.get('orden_iva'),
                    wrapper: this.spinner,
                    dataFilter: {
                        orden2_orden: this.model.get('id')
                    }
               }
            });

            // Despachos pendientes list
            this.despachospPendientesOrdenListView = new app.DespachospPendientesOrdenListView( {
                collection: this.despachospPendientesOrdenList,
                parameters: {
                    dataFilter: {
                        orden2_orden: this.model.get('id')
                    }
               }
            });

            // Tiemposp  list
            this.tiempopListView = new app.TiempopListView( {
                collection: this.tiempopList,
                parameters: {
                    dataFilter: {
                        type: 'ordenp',
                        orden2_orden: this.model.get('id')
                    }
               }
            });

            // Despachos list
            this.despachopOrdenListView = new app.DespachopOrdenListView( {
                collection: this.despachopOrdenList,
                parameters: {
                    edit: true,
                    wrapper: this.spinner,
                    collectionPendientes: this.despachospPendientesOrdenList,
                    dataFilter: {
                        despachop1_orden: this.model.get('id')
                    }
               }
            });

            // Detalle asiento list
            this.cuentasListView = new app.AsientoCuentasListView({
                collection: this.asientoCuentasList,
                parameters: {
                    wrapper: this.spinner,
                    edit: false,
                    dataFilter: {
                        orden2_orden: this.model.get('id')
                    }
                }
            });
        },

        /**
        * Event submit productop
        */
        submitOrdenp: function (e) {
            this.$form.submit();
        },

        /**
        * Event Create orden
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
                    data.orden_observaciones_imagen = this.$observacionesimagen.val();
                    
                this.model.save( data, {patch: true, silent: true} );
            }
        },

        /**
        * Event Create despacho
        */
        onStoreDespacho: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
                data.despachop1_orden = this.model.get('id');
                this.despachopOrdenList.trigger( 'store', data );
            }
        },

        /**
        *   Event change select2 type orden
        **/
        changeTypeProduct: function(e) {
            var _this = this,
                typeproduct = this.$(e.currentTarget).val();

            if( typeof(typeproduct) !== 'undefined' && !_.isUndefined(typeproduct) && !_.isNull(typeproduct) && typeproduct != '' ){
                $.ajax({
                    url: window.Misc.urlFull( Route.route('subtipoproductosp.index', {typeproduct: typeproduct}) ),
                    type: 'GET',
                    beforeSend: function() {
                        window.Misc.setSpinner( _this.spinner );
                    }
                })
                .done(function(resp) {
                    window.Misc.removeSpinner( _this.spinner );

                    _this.$product.empty().val(0).attr('disabled', 'disabled');
                    _this.$subtypeproduct.empty().val(0).removeAttr('disabled');
                    _this.$subtypeproduct.append("<option value=></option>");
                    _.each(resp, function(item){
                        _this.$subtypeproduct.append("<option value="+item.id+">"+item.subtipoproductop_nombre+"</option>");
                    });

                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    window.Misc.removeSpinner( _this.spinner );
                    alertify.error(thrownError);
                });
            }else{
                this.$subtypeproduct.empty().val(0).attr('disabled', 'disabled');
                this.$product.empty().val(0).attr('disabled', 'disabled');
            }
        },

        /**
        *   Event change select2 subtype orden
        **/
        changeSubtypeProduct: function(e) {
            var _this = this,
                subtypeproduct = this.$(e.currentTarget).val(),
                typeproduct = this.$('#typeproductop').val();

            if( typeof(subtypeproduct) !== 'undefined' && !_.isUndefined(subtypeproduct) && !_.isNull(subtypeproduct) && subtypeproduct != '' ){
                $.ajax({
                    url: window.Misc.urlFull( Route.route('productosp.index') ),
                    data: {
                        subtypeproduct: subtypeproduct,
                        typeproduct: typeproduct
                    },
                    type: 'GET',
                    beforeSend: function() {
                        window.Misc.setSpinner( _this.spinner );
                    }
                })
                .done(function(resp) {
                    window.Misc.removeSpinner( _this.spinner );

                    _this.$product.empty().val(0).removeAttr('disabled');
                    _this.$product.append("<option value=></option>");
                    _.each(resp, function(item){
                        _this.$product.append("<option value="+item.id+">"+item.productop_nombre+"</option>");
                    });

                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    window.Misc.removeSpinner( _this.spinner );
                    alertify.error(thrownError);
                });
            }
        },

        /**
        * export to PDF
        */
        exportOrdenp: function (e) {
            e.preventDefault();

            // Redirect to pdf
            window.open( window.Misc.urlFull(Route.route('ordenes.exportar', { ordenes: this.model.get('id') })), '_blank');
        },

        /**
        * Close ordenp
        */
        closeOrdenp: function (e) {
            e.preventDefault();

            var _this = this;
            var cancelConfirm = new window.app.ConfirmWindow({
                parameters: {
                    dataFilter: { orden_codigo: _this.model.get('orden_codigo') },
                    template: _.template( ($('#ordenp-close-confirm-tpl').html() || '') ),
                    titleConfirm: 'Cerrar orden de producción',
                    onConfirm: function () {
                        // Close orden
                        $.ajax({
                            url: window.Misc.urlFull( Route.route('ordenes.cerrar', { ordenes: _this.model.get('id') }) ),
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
                                if( _.isObject( resp.errors ) ) {
                                    text = window.Misc.parseErrors(resp.errors);
                                }

                                if( !resp.success ) {
                                    alertify.error(text);
                                    return;
                                }

                                window.Misc.successRedirect( resp.msg, window.Misc.urlFull(Route.route('ordenes.show', { ordenes: _this.model.get('id') })) );
                            }
                        })
                        .fail(function(jqXHR, ajaxOptions, thrownError) {
                            window.Misc.removeSpinner( _this.spinner );
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

            var _this = this;
            var cancelConfirm = new window.app.ConfirmWindow({
                parameters: {
                    dataFilter: { orden_codigo: _this.model.get('orden_codigo') },
                    template: _.template( ($('#ordenp-complete-confirm-tpl').html() || '') ),
                    titleConfirm: 'Completar orden de producción',
                    onConfirm: function () {
                        // Close orden
                        $.ajax({
                            url: window.Misc.urlFull( Route.route('ordenes.completar', { ordenes: _this.model.get('id') }) ),
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
                                if( _.isObject( resp.errors ) ) {
                                    text = window.Misc.parseErrors(resp.errors);
                                }

                                if( !resp.success ) {
                                    alertify.error(text);
                                    return;
                                }

                                window.Misc.successRedirect( resp.msg, window.Misc.urlFull(Route.route('ordenes.show', { ordenes: _this.model.get('id') })) );
                            }
                        })
                        .fail(function(jqXHR, ajaxOptions, thrownError) {
                            window.Misc.removeSpinner( _this.spinner );
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
                route = window.Misc.urlFull( Route.route('ordenes.clonar', { ordenes: this.model.get('id') }) ),
                data = { orden_codigo: this.model.get('orden_codigo') };

            var cloneConfirm = new window.app.ConfirmWindow({
                parameters: {
                    dataFilter: data,
                    template: _.template( ($('#ordenp-clone-confirm-tpl').html() || '') ),
                    titleConfirm: 'Clonar orden de producción',
                    onConfirm: function () {
                        // Clone orden
                        window.Misc.cloneModule({
                            'url': route,
                            'wrap': _this.spinner,
                            'callback': (function (_this) {
                                return function ( resp )
                                {
                                    window.Misc.successRedirect( resp.msg, window.Misc.urlFull(Route.route('ordenes.edit', { ordenes: resp.id })) );
                                }
                            })(_this)
                        });
                    }
                }
            });

            cloneConfirm.render();
        },

        referenceCharts: function (){
            var _this = this;

            // Ajax charts
            $.ajax({
                url: window.Misc.urlFull( Route.route('ordenes.charts', { ordenes: _this.model.get('id') }) ),
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
                    if( _.isObject( resp.errors ) ) {
                        text = window.Misc.parseErrors(resp.errors);
                    }
                    if( !resp.success ) {
                        alertify.error(text);
                        return;
                    }

                    // Render calendar
                    _this.charts( resp );
                }
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                window.Misc.removeSpinner( _this.spinner );
                alertify.error(thrownError);
            });

        },

        charts: function ( resp ){
            // Definir opciones globales para graficas del modulo
            Chart.defaults.global.defaultFontColor="black";
            Chart.defaults.global.defaultFontStyle="bold";
            Chart.defaults.global.defaultFontSize=9;
            Chart.defaults.global.title.fontSize=12;

            function formatTime( timeHour ){
                var dias = Math.floor( timeHour / 24 );
                var horas = Math.floor( timeHour - ( dias * 24 ) );
                var minutos = Math.floor( ( timeHour - (dias * 24) - (horas) ) * 60 );

                return dias+"d "+horas+"h "+minutos+"m";
            }

            // Chart empleado
            if ( !_.isEmpty( resp.chartempleado.data ) ) {
                this.$renderChartEmpleado.html( this.templateEmpleado() );

                var ctx = this.$('#chart_empleado').get(0).getContext('2d');
                var green_black_gradient = ctx.createLinearGradient(0, 0, 0, 300);
                    green_black_gradient.addColorStop(0, 'green');
                    green_black_gradient.addColorStop(1, 'black');

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: resp.chartempleado.labels,
                        datasets: [{
                            label: 'tiempo empleado',
                            data: resp.chartempleado.data,
                            backgroundColor: green_black_gradient,
                            hoverBackgroundColor: green_black_gradient,
                            hoverBorderWidth: 2,
                            hoverBorderColor: 'white'
                        }]
                    },
                    options: {
                        responsive: true,
                        title: {
                            display: false,
                        },
                        legend: { display: false },
                        scales: {
                            xAxes: [{
                                stacked: true,
                                barThickness: 60,
                                barPercentage: 1.,
                                categoryPercentage: .5,
                                gridLines: {
                                    offsetGridLines: true
                                },
                                ticks: {
                                    autoSkip: false
                                }
                            }],
                            yAxes: [{
                                stacked: true,
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Horas'
                                },
                            }]
                        },
                        tooltips: {
                            callbacks: {
                                label: function(item, data) {
                                    return data.datasets[item.datasetIndex].label+": "+formatTime(data.datasets[item.datasetIndex].data[item.index]);
                                }
                            }
                        }
                    }
                });
            }
            if ( !_.isEmpty( resp.chartareap.data ) ) {
                this.$renderChartAreasp.html( this.templateAreap() );

                var ctx = this.$('#chart_areas').get(0).getContext('2d');
                new Chart(ctx ,{
                    type: 'doughnut',
                    data: {
                        labels: resp.chartareap.labels,
                        datasets: [{
                            backgroundColor: window.Misc.getColorsRGB(),
                            data: resp.chartareap.data
                        }]
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
                                label: function(item, data) {
                                    return data.labels[item.index]+": "+formatTime(data.datasets[item.datasetIndex].data[item.index]);
                                }
                            }
                        },
                    }
                });
            }
            if ( !_.isEmpty( resp.chartcomparativa.labels ) ){
                this.$renderChartProductop.html( this.templateProductop() );

                var ctx = this.$('#chart_comparativa').get(0).getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: resp.chartcomparativa.labels,
                        datasets: [
                            {
                                label: 'Tiempo de producción',
                                data: resp.chartcomparativa.tiempoproduction,
                                backgroundColor: '#00A65A',
                                hoverBackgroundColor: '#00A65A',
                                hoverBorderWidth: 1,
                                hoverBorderColor: 'black'
                            },{
                                label: 'Tiempo cotizado',
                                data: resp.chartcomparativa.tiempocotizacion,
                                backgroundColor: '#D8D8D8',
                                hoverBackgroundColor: '#D8D8D8',
                                hoverBorderWidth: 1,
                                hoverBorderColor: 'black'
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        title: {
                            display: false,
                        },
                        scales: {
                            xAxes: [{
                                barPercentage: 1.,
                                categoryPercentage: .4,
                                gridLines: {
                                    offsetGridLines: true
                                },
                                ticks: {
                                    autoSkip: false
                                 }
                            }],
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true,
                                },
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Horas'
                                },
                            }]
                        },
                        tooltips: {
                            callbacks: {
                                label: function(item, data) {
                                    return data.datasets[item.datasetIndex].label+": "+formatTime(data.datasets[item.datasetIndex].data[item.index]);
                                }
                            }
                        },
                    }
                });
            }

            this.$('.tiempo-total').text( formatTime(resp.tiempototal) );
            this.$('.orden-codigo').text( resp.orden_codigo );
        },

        /**
        * UploadPictures
        */
        uploadPictures: function(e) {
            var _this = this;

            this.$uploaderFile.fineUploader({
                debug: false,
                template: 'qq-template',
                multiple: true,
                autoUpload: true,
                session: {
                    endpoint: window.Misc.urlFull( Route.route('ordenes.imagenes.index') ),
                    params: {
                        ordenp: this.model.get('id'),
                    },
                    refreshOnRequest: false
                },
                request: {
                    inputName: 'file',
                    endpoint: window.Misc.urlFull( Route.route('ordenes.imagenes.index') ),
                    params: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        ordenp: this.model.get('id')
                    }
                },
                retry: {
                    maxAutoAttempts: 3,
                },
                deleteFile: {
                    enabled: true,
                    forceConfirm: true,
                    confirmMessage: '¿Esta seguro de que desea eliminar este archivo de forma permanente? {filename}',
                    endpoint: window.Misc.urlFull( Route.route('ordenes.imagenes.index') ),
                    params: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        ordenp: this.model.get('id')
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
            this.$uploaderFile.find('.btn-imprimir').remove();

            var itemFile = this.$uploaderFile.fineUploader('getItemByFileId', id);
            this.$uploaderFile.fineUploader('setUuid', id, resp.id);
            this.$uploaderFile.fineUploader('setName', id, resp.name);

            var previewLink = this.$uploaderFile.fineUploader('getItemByFileId', id).find('.preview-link');
            previewLink.attr("href", resp.url);
        },

        onSessionRequestComplete: function (id, name, resp) {
            this.$uploaderFile.find('.btn-imprimir').remove();

            _.each( id, function (value, key){
                var previewLink = this.$uploaderFile.fineUploader('getItemByFileId', key).find('.preview-link');
                previewLink.attr("href", value.thumbnailUrl);
            }, this);
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();

            if( typeof window.initComponent.initTimePicker == 'function' )
                window.initComponent.initTimePicker();

            if( typeof window.initComponent.initSelect2 == 'function' )
                window.initComponent.initSelect2();

            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();

            if( typeof window.initComponent.initInputMask == 'function' )
                window.initComponent.initInputMask();

            if( typeof window.initComponent.initDatePicker == 'function' )
                window.initComponent.initDatePicker();
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function (model, xhr, opts) {
            window.Misc.setSpinner( this.spinner );
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            window.Misc.removeSpinner( this.spinner );

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

                // Redirect to edit orden
                window.Misc.redirect( window.Misc.urlFull( Route.route('ordenes.edit', { ordenes: resp.id}), { trigger:true } ));
            }
        }
    });

})(jQuery, this, this.document);
