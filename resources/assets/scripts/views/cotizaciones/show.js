/**
* Class ShowCotizacionView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ShowCotizacionView = Backbone.View.extend({

        el: '#cotizaciones-show',
        events: {
            'click .export-cotizacion': 'exportCotizacion',
            'click .open-cotizacion': 'openCotizacion',
            'click .clone-cotizacion': 'cloneCotizacion'
        },

        /**
        * Constructor Method
        */
        initialize: function () {
            _.bindAll(this, 'onSessionRequestComplete');

            // Recuperar iva && cotizacion codigo
            this.$iva = this.$('#cotizacion1_iva');
            this.codigo = this.$('#cotizacion_codigo').val();
            this.$renderChartProductos = this.$('#render-chart-cotizacion');
            this.$uploaderFile = this.$('.fine-uploader');

            // Attributes
            this.productopCotizacionList = new app.ProductopCotizacionList();
            this.bitacoraCotizacionList = new app.BitacoraCotizacionList();

            // Reference views
            this.referenceCharts();
            this.referenceViews();
            this.uploadPictures();
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            // Productos list
            this.productopCotizacionListView = new app.ProductopCotizacionListView( {
                collection: this.productopCotizacionList,
                parameters: {
                    wrapper: this.$('#wrapper-productop-cotizacion'),
                    iva: this.$iva.val(),
                    dataFilter: {
                        'cotizacion2_cotizacion': this.model.get('id')
                    }
               }
            });

            // Bitacora list
            this.bitacoraListView = new app.BitacoraListView( {
                collection: this.bitacoraCotizacionList,
                parameters: {
                    dataFilter: {
                        cotizacion: this.model.get('id')
                    }
               }
            });
        },

        /**
        * Open cotizacion
        */
        openCotizacion: function (e) {
            e.preventDefault();

            var _this = this;
            var cancelConfirm = new window.app.ConfirmWindow({
                parameters: {
                    dataFilter: { cotizacion_codigo: _this.model.get('cotizacion_codigo') },
                    template: _.template( ($('#cotizacion-open-confirm-tpl').html() || '') ),
                    titleConfirm: 'Reabir cotización',
                    onConfirm: function () {
                        // Open cotizacion
                        $.ajax({
                            url: window.Misc.urlFull( Route.route('cotizaciones.abrir', { cotizaciones: _this.model.get('id') }) ),
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

                                window.Misc.successRedirect( resp.msg, window.Misc.urlFull(Route.route('cotizaciones.edit', { cotizaciones: _this.model.get('id') })) );
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
                route = window.Misc.urlFull( Route.route('cotizaciones.clonar', { cotizaciones: this.model.get('id') }) );

            var cloneConfirm = new window.app.ConfirmWindow({
                parameters: {
                    template: _.template( ($('#cotizacion-clone-confirm-tpl').html() || '') ),
                    titleConfirm: 'Clonar cotización',
                    onConfirm: function () {
                        // Clone cotizacion
                        window.Misc.cloneModule({
                            'url': route,
                            'wrap': _this.$el,
                            'callback': (function (_this) {
                                return function ( resp )
                                {
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
        * export to PDF
        */
        exportCotizacion: function (e) {
            e.preventDefault();

            // Redirect to pdf
            window.open( window.Misc.urlFull(Route.route('cotizaciones.exportar', { cotizaciones: this.codigo })), '_blank');
        },

        /**
        * Reference charts
        */
        referenceCharts: function () {
            var _this = this;

            // Ajax charts
            $.ajax({
                url: window.Misc.urlFull(Route.route('cotizaciones.charts', {cotizaciones: _this.model.get('id')})),
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
        * Charts
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
                    },
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
                dragDrop: false,
                session: {
                    endpoint: window.Misc.urlFull(Route.route('cotizaciones.archivos.index')),
                    params: {
                        cotizacion: _this.model.get('id'),
                    },
                    refreshOnRequest: false
                },
                thumbnails: {
                    placeholders: {
                        notAvailablePath: window.Misc.urlFull("build/css/placeholders/not_available-generic.png"),
                        waitingPath: window.Misc.urlFull("build/css/placeholders/waiting-generic.png")
                    }
                },
                callbacks: {
                    onSessionRequestComplete: _this.onSessionRequestComplete,
                },
            });

            this.$uploaderFile.find('.buttons').remove();
            this.$uploaderFile.find('.qq-upload-drop-area').remove();
        },

        /**
        * onSessionRequestComplete
        */
        onSessionRequestComplete: function (id, name, resp) {
            _.each( id, function (value, key){
                var previewLink = this.$uploaderFile.fineUploader('getItemByFileId', key).find('.preview-link');
                    previewLink.attr("href", value.thumbnailUrl);
            }, this);
        },
    });

})(jQuery, this, this.document);
