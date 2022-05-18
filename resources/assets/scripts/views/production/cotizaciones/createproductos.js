/**
* Class CreateCotizacion2View  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateCotizacion2View = Backbone.View.extend({

        el: '#cotizaciones-productos-create',
        template: _.template(($('#add-cotizacion-producto-tpl').html() || '')),
        events: {
            'click .submit-cotizacion2': 'submitForm',
            'submit #form-cotizacion-producto': 'onStore',
            'submit #form-materialp-producto': 'onStoreMaterialp',
            'submit #form-empaque-producto': 'onStoreEmpaquep',
            'submit #form-areap-producto': 'onStoreAreap',
            'submit #form-transporte-producto': 'onStoreTransporte',
            'change .total-calculate': 'totalCalculate',
            'change .change-insumo': 'changeInsumo',
            'change .change-info-title': 'changeInfoTitle',
        },
        parameters: {
            data: {
                cotizacion2_productop: null
            }
        },

        /**
        * Constructor Method
        */
        initialize: function (opts) {
            // Initialize
            if (opts !== undefined && _.isObject(opts.parameters))
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            // reference collections
            this.materialesProductopCotizacionList = new app.MaterialesProductopCotizacionList();
            this.empaquesProductopCotizacionList = new app.EmpaquesProductopCotizacionList();
            this.areasProductopCotizacionList = new app.AreasProductopCotizacionList();
            this.transportesProductopCotizacionList = new app.TransportesProductopCotizacionList();

            // Declare previes values materiales, empaques
            this.prevmateriales = 0;
            this.prevempaques = 0;
            this.prevtransportes = 0;

            // Events
            this.listenTo(this.model, 'change', this.render);
            this.listenTo(this.model, 'sync', this.responseServer);
            this.listenTo(this.model, 'request', this.loadSpinner);
            this.listenTo(this.model, 'totalize', this.totalCalculate);

            // bind fineuploader
            _.bindAll(this, 'onSubmitted', 'onSessionRequestComplete');
        },

        /*
        * Render View Element
        */
        render: function () {
            var attributes = this.model.toJSON();
            attributes.edit = this.model.get('id') ? 1 : 0;
            this.$el.html(this.template(attributes));

            // reference forms
            this.$form = this.$('#form-cotizacion-producto');
            this.$formmaterialp = this.$('#form-materialp-producto');
            this.$formempaque = this.$('#form-empaque-producto');
            this.$formareap = this.$('#form-areap-producto');
            this.$formtransporte = this.$('#form-transporte-producto');

            // reference to Fine uploader
            this.$uploaderFile = this.$('.fine-uploader');

            // Inputs cuadro de informacion
            this.$inputmargenmaterialp = this.$('#cotizacion2_margen_materialp');
            this.$inputmargenareap = this.$('#cotizacion2_margen_areap');
            this.$inputmargenempaque = this.$('#cotizacion2_margen_empaque');
            this.$inputmargentransporte = this.$('#cotizacion2_margen_transporte');
            this.$inputdescuento = this.$('#cotizacion2_descuento');
            this.$inputcomision = this.$('#cotizacion2_comision');
            this.$inputvolumen = this.$('#cotizacion2_volumen');
            this.$inputround = this.$('#cotizacion2_round');

            // Informacion Cotizacion
            this.$infosubtotalheader = this.$('#info-subtotal-header');
            this.$infoivaheader = this.$('#info-iva-header');
            this.$infototalheader = this.$('#info-total-header');

            this.$infoprecio = this.$('#info-precio');
            this.$percentageprecio = this.$('#percentage-precio');
            this.$infoviaticos = this.$('#info-viaticos');
            this.$percentageviaticos = this.$('#percentage-viaticos');
            this.$infoprevmateriales = this.$('#info-prev-materiales');
            this.$diferenciamateriales = this.$('#diferencia-materiales');
            this.$infomateriales = this.$('#info-materiales');
            this.$percentagemateriales = this.$('#percentage-materiales');
            this.$percentageprevmateriales = this.$('#percentage-prev-materiales');
            this.$infoprevareasp = this.$('#info-prev-areasp');
            this.$diferenciaareasp = this.$('#diferencia-areasp');
            this.$infoareasp = this.$('#info-areasp');
            this.$percentageareasp = this.$('#percentage-areasp');
            this.$percentageprevareasp = this.$('#percentage-prev-areasp');
            this.$infoprevempaques = this.$('#info-prev-empaques');
            this.$diferenciaempaques = this.$('#diferencia-empaques');
            this.$infoempaques = this.$('#info-empaques');
            this.$percentageprevempaques = this.$('#percentage-prev-empaques');
            this.$percentageempaques = this.$('#percentage-empaques');
            this.$infoprevtransportes = this.$('#info-prev-transportes');
            this.$diferenciatransportes = this.$('#diferencia-transportes');
            this.$infotransportes = this.$('#info-transportes');
            this.$percentageprevtransportes = this.$('#percentage-prev-transportes');
            this.$percentagetransportes = this.$('#percentage-transportes');
            this.$infoprevsubtotal = this.$('#info-prev-subtotal');
            this.$infosubtotal = this.$('#info-subtotal');
            this.$infoprevcomision = this.$('#info-prev-comision');
            this.$infocomision = this.$('#info-comision');
            this.$infoprevdescuento = this.$('#info-prev-descuento');
            this.$infodescuento = this.$('#info-descuento');
            this.$infovolumen = this.$('#info-volumen');
            this.$infopretotal = this.$('#info-pretotal');
            this.iva = $('#iva_cotizacion').val();
            this.$infoiva = this.$('#info-iva');
            this.$infototalsubtotal = this.$('#info-total-subtotal');
            this.$infototal = this.$('#info-total');

            // Variables globales
            this.range = [-3, -2, -1, 0, 1, 2, 3];

            // If exists container
            if ($('.chart-container').length) {
                this.chart = '';
                this.chartPrecio = 0;
                this.chartViaticos = 0;
                this.chartMateriales = 0;
                this.chartAreas = 0;
                this.chartEmpaques = 0;
                this.chartTransportes = 0;
                this.chartVolumen = 0;

                this.referenceCharts();
            }

            // Reference views
            this.spinner = this.$('.spinner-main');
            this.referenceViews();
            this.uploadPictures();
            this.ready();
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            var dataFilter = { productop: this.parameters.data.cotizacion2_productop };

            // Model exist
            if (this.model.id != undefined) {
                dataFilter.cotizacion2 = this.model.get('id');
                dataFilter.productop = this.model.get('cotizacion2_productop');
            }

            // Materiales
            this.materialesProductopCotizacionListView = new app.MaterialesProductopCotizacionListView({
                collection: this.materialesProductopCotizacionList,
                model: this.model,
                parameters: {
                    edit: true,
                    dataFilter: dataFilter
                }
            });

            // Empaques
            this.empaquesProductopCotizacionListView = new app.EmpaquesProductopCotizacionListView({
                collection: this.empaquesProductopCotizacionList,
                model: this.model,
                parameters: {
                    edit: true,
                    dataFilter: dataFilter
                }
            });

            // Areasp list
            this.areasProductopCotizacionListView = new app.AreasProductopCotizacionListView({
                collection: this.areasProductopCotizacionList,
                model: this.model,
                parameters: {
                    edit: true,
                    dataFilter: dataFilter
                }
            });

            // Transportes
            this.transportesProductopCotizacionListView = new app.TransportesProductopCotizacionListView({
                collection: this.transportesProductopCotizacionList,
                model: this.model,
                parameters: {
                    edit: true,
                    dataFilter: dataFilter
                }
            });
        },

        /**
        * Event submit productop
        */
        submitForm: function (e) {
            this.$form.submit();
        },

        /**
        * Event Create Folder
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                imagenesProducto = [];
                $('.incluir-cotizacion').each(function (i, item) {
                    if ($(item).is(':checked')) {
                        imagenesProducto.push($(item).data('resource'));
                    }
                });

                /**
                * En el metodo post o crear es necesario mandar las imagenes preguardadas por ende se convierte toda la peticion en un texto plano FormData
                * El metodo put no es compatible con formData
                */
                var data = $.extend({}, window.Misc.formToJson(e.target), this.parameters.data);
                // data.cotizacion2_margen_materialp = this.$inputmargenmaterialp.val() || 30;
                // data.cotizacion2_margen_areap = this.$inputmargenareap.val() || 30;
                // data.cotizacion2_margen_empaque = this.$inputmargenempaque.val() || 30;
                // data.cotizacion2_margen_transporte = this.$inputmargentransporte.val() || 30;
                // data.cotizacion2_comision = this.$inputcomision.val() || 0;
                // data.cotizacion2_descuento = this.$inputdescuento.val() || 0;
                // data.cotizacion2_volumen = this.$inputvolumen.val() || 0;
                // data.cotizacion2_round = this.$inputround.val() || 0;

                data.cotizacion2_margen_materialp = this.$inputmargenmaterialp.val() || this.model.get('cotizacion2_margen_materialp');
                data.cotizacion2_margen_areap = this.$inputmargenareap.val() || this.model.get('cotizacion2_margen_areap');
                data.cotizacion2_margen_empaque = this.$inputmargenempaque.val() || this.model.get('cotizacion2_margen_empaque');
                data.cotizacion2_margen_transporte = this.$inputmargentransporte.val() || this.model.get('cotizacion2_margen_transporte');
                data.cotizacion2_comision = this.$inputcomision.val() || this.model.get('cotizacion2_comision');
                data.cotizacion2_descuento = this.$inputdescuento.val() || this.model.get('cotizacion2_descuento');
                data.cotizacion2_volumen = this.$inputvolumen.val() || this.model.get('cotizacion2_volumen');
                data.cotizacion2_round = this.$inputround.val() || this.model.get('cotizacion2_round');

                data.materialesp = this.model.isNew() ? JSON.stringify(this.materialesProductopCotizacionList) : this.materialesProductopCotizacionList.toJSON();
                data.areasp = this.model.isNew() ? JSON.stringify(this.areasProductopCotizacionList) : this.areasProductopCotizacionList.toJSON();
                data.empaques = this.model.isNew() ? JSON.stringify(this.empaquesProductopCotizacionList) : this.empaquesProductopCotizacionList.toJSON();
                data.transportes = this.model.isNew() ? JSON.stringify(this.transportesProductopCotizacionList) : this.transportesProductopCotizacionList.toJSON();
                data.productop_imagenes = imagenesProducto;

                if (this.model.isNew()) {
                    this.$files = this.$uploaderFile.fineUploader('getUploads', { status: 'submitted' });
                    var formData = new FormData();
                    _.each(this.$files, function (file, key) {
                        formData.append('imagenes[]', file.file, file.file.name + '(' + this.$('#cotizacion8_imprimir_' + key).is(':checked') + ')');
                    });

                    // Recorrer archivos para mandarlos texto plano
                    _.each(data, function (value, key) {
                        formData.append(key, value);
                    });

                    this.model.save(null, {
                        data: formData,
                        silent: true,
                        processData: false,
                        contentType: false
                    });
                } else {
                    this.model.save(data, { wait: true, patch: true, silent: true });
                }
            }
        },

        /**
        * Event Create
        */
        onStoreMaterialp: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = $.extend({}, window.Misc.formToJson(e.target), this.parameters.data);
                data.cotizacion4_cantidad = this.$('#cotizacion4_cantidad:disabled').val();
                data.previo = this.prevmateriales;
                this.materialesProductopCotizacionList.trigger('store', data, this.$formmaterialp);
            }
        },

        /**
        * Event Create
        */
        onStoreAreap: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = $.extend({}, window.Misc.formToJson(e.target), this.parameters.data);
                this.areasProductopCotizacionList.trigger('store', data, this.$formareap);
            }
        },

        /**
        * Event Create
        */
        onStoreEmpaquep: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = $.extend({}, window.Misc.formToJson(e.target), this.parameters.data);
                data.cotizacion9_cantidad = this.$('#cotizacion9_cantidad:disabled').val();
                data.previo = this.prevempaques;
                this.empaquesProductopCotizacionList.trigger('store', data, this.$formempaque);
            }
        },

        /**
        * Event Create
        */
        onStoreTransporte: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = $.extend({}, window.Misc.formToJson(e.target), this.parameters.data);
                data.cotizacion10_cantidad = this.$('#cotizacion10_cantidad:disabled').val();
                data.previo = this.prevtransportes;
                this.transportesProductopCotizacionList.trigger('store', data, this.$formtransporte);
            }
        },

        /**
        * Event change insumo
        */
        changeInsumo: function (e) {
            var selected = this.$(e.currentTarget),
                insumo = selected.val(),
                tipo = selected.data('historial').split('_')[1],
                _this = this;

            // Reference
            this.$inputinsumo = this.$('#' + selected.data('valor'));
            this.$historialinsumo = this.$('#' + selected.data('historial'));

            if (insumo) {
                var url;
                if (tipo == 'cotizacion4') {
                    url = window.Misc.urlFull(Route.route('cotizaciones.productos.materiales.index', { insumo: insumo }));
                    tipo = 'M';
                } else if (tipo == 'cotizacion9') {
                    url = window.Misc.urlFull(Route.route('cotizaciones.productos.empaques.index', { insumo: insumo }));
                    tipo = 'E';
                } else {
                    url = window.Misc.urlFull(Route.route('cotizaciones.productos.transportes.index', { insumo: insumo }));
                    tipo = 'T';
                }

                $.get(url, function (resp) {
                    if (resp) {
                        if (tipo == 'M') {
                            _this.prevmateriales = resp.valor;
                        } else if (tipo == 'E') {
                            _this.prevempaques = resp.valor;
                        } else {
                            _this.prevtransportes = resp.valor;
                        }

                        _this.$inputinsumo.val(resp.valor);
                        _this.$historialinsumo.empty().append($('<small>').addClass('text-muted').append("Ver historial de insumo")).attr('data-resource', insumo).attr('data-tipo', tipo);
                    }
                });
            } else {
                this.$inputinsumo.val(0);
                this.$historialinsumo.empty();
            }
        },

        /**
        * Event change info
        */
        changeInfoTitle: function (e) {
            e.preventDefault();

            var selected = this.$(e.currentTarget);
            $('#' + selected.data('input-info')).text(selected.val());
        },

        /**
        * Event calculate total
        */
        totalCalculate: function () {
            // Igualar variables y quitar el inputmask
            var cantidad = parseInt(this.$('#cotizacion2_cantidad').val());
            var precio = parseFloat(this.$('#cotizacion2_precio_venta').inputmask('unmaskedvalue'));
            var viaticos = Math.round(parseFloat(this.$('#cotizacion2_viaticos').inputmask('unmaskedvalue')) / cantidad);
            var materiales = Math.round(parseFloat(this.materialesProductopCotizacionList.totalize().total) / cantidad);
            var prevmateriales = materiales;
            var areasp = Math.round(parseFloat(this.areasProductopCotizacionList.totalize().total) / cantidad);
            var prevareasp = areasp
            var empaques = Math.round(parseFloat(this.empaquesProductopCotizacionList.totalize().total) / cantidad);
            var prevempaques = empaques;
            var transportes = Math.round(parseFloat(this.transportesProductopCotizacionList.totalize().total) / cantidad);
            var prevtransportes = transportes;
            var descuento = parseFloat(this.$inputdescuento.val());
            var volumen = parseFloat(this.$inputvolumen.val());
            var prevsubtotal = 0;
            var subtotal = 0;
            var porcentajedescuento = 0;
            var totaldescuento = 0;
            var totalcomision = 0;

            materiales = this.maxinput(this.$inputmargenmaterialp, materiales, this.$inputmargenmaterialp.val())
            areasp = this.maxinput(this.$inputmargenareap, areasp, this.$inputmargenareap.val())
            empaques = this.maxinput(this.$inputmargenempaque, empaques, this.$inputmargenempaque.val())
            transportes = this.maxinput(this.$inputmargentransporte, transportes, this.$inputmargentransporte.val())

            // Cuadros de informacion
            this.$infoprecio.empty().html(window.Misc.currency(precio));
            this.$infoviaticos.empty().html(window.Misc.currency(viaticos));
            this.$infoprevmateriales.empty().html(window.Misc.currency(prevmateriales));
            this.$diferenciamateriales.empty().html(window.Misc.currency(materiales - prevmateriales));
            this.$infomateriales.empty().html(window.Misc.currency(materiales));
            this.$infoprevareasp.empty().html(window.Misc.currency(prevareasp));
            this.$diferenciaareasp.empty().html(window.Misc.currency(areasp - prevareasp));
            this.$infoareasp.empty().html(window.Misc.currency(areasp));
            this.$infoprevempaques.empty().html(window.Misc.currency(prevempaques));
            this.$diferenciaempaques.empty().html(window.Misc.currency(empaques - prevempaques));
            this.$infoempaques.empty().html(window.Misc.currency(empaques));
            this.$infoprevtransportes.empty().html(window.Misc.currency(prevtransportes));
            this.$diferenciatransportes.empty().html(window.Misc.currency(transportes - prevtransportes));
            this.$infotransportes.empty().html(window.Misc.currency(transportes));

            // Calcular total de la orden (transporte+viaticos+precio+areas)
            subtotal = precio + viaticos + materiales + areasp + empaques + transportes;

            // Si no existe el input
            if (_.isNaN(descuento) && !descuento) {
                this.$inputdescuento.val(0);
                descuento = 0;
            }

            // Si no existe el input
            if (_.isNaN(volumen) && !volumen) {
                this.$inputvolumen.val(0);
                volumen = 0;
            }

            // Calcular comision
            porcentajedescuento = subtotal * (descuento / 100);
            totaldescuento = subtotal - porcentajedescuento;

            // Reasignar subtotal
            subtotal = totalcomision = this.maxinput(this.$inputcomision, totaldescuento, this.$inputcomision.val());

            tvolumen = (subtotal / ((100 - volumen) / 100)) * (1 - (((100 - volumen) / 100)));
            pretotal = subtotal + tvolumen;

            this.$percentageprecio.empty().html(((precio / subtotal) * 100).toFixed(2) + '%');
            this.$percentageviaticos.empty().html(((viaticos / subtotal) * 100).toFixed(2) + '%');
            this.$percentagemateriales.empty().html(((materiales / subtotal) * 100).toFixed(2) + '%');
            this.$percentageareasp.empty().html(((areasp / subtotal) * 100).toFixed(2) + '%');
            this.$percentageempaques.empty().html(((empaques / subtotal) * 100).toFixed(2) + '%');
            this.$percentagetransportes.empty().html(((transportes / subtotal) * 100).toFixed(2) + '%');

            prevsubtotal = prevmateriales + prevareasp + prevempaques + prevtransportes;

            this.$infoprevsubtotal.empty().html('$ ' + window.Misc.currency(prevsubtotal));

            this.$percentageprevmateriales.empty().html(((prevmateriales / prevsubtotal) * 100).toFixed(2) + '%');
            this.$percentageprevareasp.empty().html(((prevareasp / prevsubtotal) * 100).toFixed(2) + '%');
            this.$percentageprevempaques.empty().html(((prevempaques / prevsubtotal) * 100).toFixed(2) + '%');
            this.$percentageprevtransportes.empty().html(((prevtransportes / prevsubtotal) * 100).toFixed(2) + '%');

            // Calcular round decimales
            round = parseInt(this.$inputround.val());
            if (this.range.indexOf(round) != -1) {
                var exp = Math.pow(10, round);
                pretotal = Math.round(pretotal * exp) / exp;
            } else {
                this.$inputround.val(0);
            }

            this.$infoprevdescuento.html(window.Misc.currency(subtotal));
            this.$infodescuento.html('$ ' + window.Misc.currency(totaldescuento));
            this.$infoprevcomision.html(window.Misc.currency(totaldescuento));
            this.$infocomision.html('$ ' + window.Misc.currency(totalcomision));

            this.$infosubtotal.html('$ ' + window.Misc.currency(subtotal) + ' x ' + cantidad);
            this.$infovolumen.html('$ ' + window.Misc.currency(tvolumen));
            this.$infopretotal.html('$ ' + window.Misc.currency(pretotal));

            var iva = Math.round(pretotal * (this.iva / 100)),
                total = pretotal + iva;

            this.$infoiva.html('$ ' + window.Misc.currency(iva) + ' x ' + cantidad);
            this.$infototal.html('$ ' + window.Misc.currency(total) + ' x ' + cantidad);

            this.$infosubtotalheader.html('$ ' + window.Misc.currency(subtotal * cantidad));
            this.$infoivaheader.html('$ ' + window.Misc.currency(iva * cantidad));
            this.$infototalheader.html('$ ' + window.Misc.currency(total * cantidad));

            this.$infototalsubtotal.html('$ ' + window.Misc.currency(prevsubtotal * cantidad));

            // Update charts
            this.chart.data.datasets[0].data[0] = this.chartPrecio + (precio * cantidad || 0);
            this.chart.data.datasets[0].data[1] = this.chartViaticos + (viaticos * cantidad || 0);
            this.chart.data.datasets[0].data[2] = this.chartMateriales + (materiales * cantidad || 0);
            this.chart.data.datasets[0].data[3] = this.chartAreas + (areasp * cantidad || 0);
            this.chart.data.datasets[0].data[4] = this.chartEmpaques + (empaques * cantidad || 0);
            this.chart.data.datasets[0].data[5] = this.chartTransportes + (transportes * cantidad || 0);
            this.chart.data.datasets[0].data[6] = this.chartVolumen + (volumen * cantidad || 0);
            this.chart.update();
        },

        /**
        * Event calculate max input
        */
        maxinput: function (input, value, margen) {
            if (input.val() >= 100) {
                input.val(99);
            } else if (!input.val()) {
                input.val(0);
            }

            // Calcular que no pase de 100% y no se undefinde
            margen = input.val();
            if (margen > 0 && margen <= 99 && !_.isUndefined(margen) && !_.isNaN(margen)) {
                value = value / ((100 - margen) / 100);
            }

            return value;
        },

        /**
        * Reference charts
        */
        referenceCharts: function () {
            var _this = this;

            // Ajax charts
            $.ajax({
                url: window.Misc.urlFull(Route.route('cotizaciones.graficas', { cotizaciones: _this.model.get('cotizacion2_cotizacion') })),
                data: {
                    producto: _this.model.get('id')
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

                        // Render calendar
                        _this.charts(resp);
                    }
                })
                .fail(function (jqXHR, ajaxOptions, thrownError) {
                    window.Misc.removeSpinner(_this.spinner);
                    alertify.error(thrownError);
                });

        },

        /**
        * charts
        */
        charts: function (resp) {
            // Definir opciones globales para graficas del modulo
            Chart.defaults.global.defaultFontColor = "black";
            Chart.defaults.global.defaultFontSize = 12;
            Chart.defaults.global.title.fontSize = 14;

            // Charts productos
            if (!_.isEmpty(resp.chartproductos.data)) {
                var ctx = this.$('#chart_producto').get(0).getContext('2d');

                this.chart = new Chart(ctx, {
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
                        maintainAspectRatio: false,
                        title: {
                            display: false,
                        },
                        legend: {
                            display: true,
                            position: 'bottom',
                        },
                        tooltips: {
                            callbacks: {
                                enabled: false,
                                label: function (item, data) {
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

                this.chart.canvas.parentNode.style.height = '500px';
                this.chart.canvas.parentNode.style.width = '100%';

                this.chartPrecio = this.chart.data.datasets[0].data[0];
                this.chartViaticos = this.chart.data.datasets[0].data[1];
                this.chartMateriales = this.chart.data.datasets[0].data[2];
                this.chartAreas = this.chart.data.datasets[0].data[3];
                this.chartEmpaques = this.chart.data.datasets[0].data[4];
                this.chartTransportes = this.chart.data.datasets[0].data[5];
                this.chartVolumen = this.chart.data.datasets[0].data[6];
            }
        },

        /**
        * UploadPictures
        */
        uploadPictures: function (e) {
            var _this = this,
                autoUpload = false,
                session = {};
            deleteFile = {};
            request = {};


            // Model exists
            if (this.model.id != undefined) {
                var session = {
                    endpoint: window.Misc.urlFull(Route.route('cotizaciones.productos.imagenes.index')),
                    params: {
                        cotizacion2: this.model.get('id'),
                    },
                    refreshOnRequest: false
                }

                var deleteFile = {
                    enabled: true,
                    forceConfirm: true,
                    confirmMessage: '¿Esta seguro de que desea eliminar este archivo de forma permanente? {filename}',
                    endpoint: window.Misc.urlFull(Route.route('cotizaciones.productos.imagenes.index')),
                    params: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        cotizacion2: this.model.get('id')
                    }
                }

                var request = {
                    inputName: 'file',
                    endpoint: window.Misc.urlFull(Route.route('cotizaciones.productos.imagenes.index')),
                    params: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        cotizacion2: this.model.get('id')
                    }
                }

                autoUpload = true;
            }

            this.$uploaderFile.fineUploader({
                debug: false,
                template: 'qq-template-cotizacion-producto',
                multiple: true,
                interceptSubmit: true,
                autoUpload: autoUpload,
                omitDefaultParams: true,
                session: session,
                request: request,
                retry: {
                    maxAutoAttempts: 3,
                },
                deleteFile: deleteFile,
                thumbnails: {
                    placeholders: {
                        notAvailablePath: window.Misc.urlFull("build/css/placeholders/not_available-generic.png"),
                        waitingPath: window.Misc.urlFull("build/css/placeholders/waiting-generic.png")
                    }
                },
                validation: {
                    itemLimit: 10,
                    sizeLimit: (3 * 1024) * 1024, // 3mb,
                    allowedExtensions: ['jpeg', 'jpg', 'png', 'pdf']
                },
                messages: {
                    typeError: '{file} extensión no valida. Extensiones validas: {extensions}.',
                    sizeError: '{file} es demasiado grande, el tamaño máximo del archivo es {sizeLimit}.',
                    tooManyItemsError: 'No puede seleccionar mas de {itemLimit} archivos.',
                },
                callbacks: {
                    onSubmitted: _this.onSubmitted,
                    onSessionRequestComplete: _this.onSessionRequestComplete
                },
            });
        },

        /**
        * complete upload of file
        * @param Number id
        * @param Strinf name
        */
        onSubmitted: function (id, name) {
            if (typeof window.initComponent.initICheck == 'function')
                window.initComponent.initICheck();

            var itemFile = this.$uploaderFile.fineUploader('getItemByFileId', id).find('.qq-imprimir');
            itemFile.attr('name', 'cotizacion8_imprimir_' + id);
            itemFile.attr('id', 'cotizacion8_imprimir_' + id);
        },

        /**
        * complete upload of file
        * @param Number id
        * @param Strinf name
        * @param Object resp
        */
        onSessionRequestComplete: function (id, name, resp) {
            if (typeof window.initComponent.initICheck == 'function')
                window.initComponent.initICheck();

            _.each(id, function (value, key) {
                var previewLink = this.$uploaderFile.fineUploader('getItemByFileId', key).find('.preview-link');
                previewLink.attr("href", value.thumbnailUrl);

                var imprimir = this.$uploaderFile.fineUploader('getItemByFileId', key).find('.qq-imprimir');
                imprimir.attr('name', 'cotizacion8_imprimir_' + value.uuid);
                imprimir.attr('id', 'cotizacion8_imprimir_' + value.uuid);

                if (value.imprimir)
                    imprimir.iCheck('check');
            }, this);
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

            if (typeof window.initComponent.initICheck == 'function')
                window.initComponent.initICheck();

            if (typeof window.initComponent.initInputMask == 'function')
                window.initComponent.initInputMask();
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

                // Redirect to cotizacion
                window.Misc.redirect(window.Misc.urlFull(Route.route('cotizaciones.edit', { cotizaciones: resp.id_cotizacion })));
            }
        }
    });

})(jQuery, this, this.document);
