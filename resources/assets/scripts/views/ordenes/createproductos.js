/**
* Class CreateOrdenp2View  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateOrdenp2View = Backbone.View.extend({

        el: '#create-ordenp-producto',
        template: _.template( ($('#add-orden-producto-tpl').html() || '') ),
        events: {
            'click .submit-ordenp2': 'submitForm',
            'submit #form-orden-producto': 'onStore',
            'ifChanged .check-type': 'checkType',
            'change .total-calculate': 'totalCalculate',
            'change .calculate_formula': 'changeFormula',
            'submit #form-materialp-producto': 'onStoreMaterialp',
            'submit #form-empaque-producto': 'onStoreEmpaquep',
            'submit #form-areap-producto': 'onStoreAreap',
            'change .change-materialp': 'changeMaterialp',
            'change .change-insumo': 'changeInsumo',
            'change #orden6_areap': 'changeAreap',
        },
        parameters: {
            data: {
                orden2_productop: null
            }
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
            // Initialize
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            // reference collections
            this.materialesProductopOrdenList = new app.MaterialesProductopOrdenList();
            this.empaquesProductopOrdenList = new app.EmpaquesProductopOrdenList();
            this.areasProductopOrdenList = new app.AreasProductopOrdenList();

            // Events
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
            this.listenTo( this.model, 'totalize', this.totalCalculate );

            // bind fineuploader
            _.bindAll(this, 'onCompleteLoadFile', 'onSessionRequestComplete');
        },

        /*
        * Render View Element
        */
        render: function() {
            var attributes = this.model.toJSON();
                attributes.edit = this.model.get('id') ? 1 : 0;
            this.$el.html( this.template(attributes) );

            // reference forms
            this.$form = this.$('#form-orden-producto');
            this.$formmaterialp = this.$('#form-materialp-producto');
            this.$formempaque = this.$('#form-empaque-producto');
            this.$formareap = this.$('#form-areap-producto');

            // reference to Fine uploader
            this.$uploaderFile = this.$('.fine-uploader');

            // Tiro
            this.$inputyellow = this.$('#orden2_yellow');
            this.$inputmagenta = this.$('#orden2_magenta');
            this.$inputcyan = this.$('#orden2_cyan');
            this.$inputkey = this.$('#orden2_key');

            // Retiro
            this.$inputyellow2 = this.$('#orden2_yellow2');
            this.$inputmagenta2 = this.$('#orden2_magenta2');
            this.$inputcyan2 = this.$('#orden2_cyan2');
            this.$inputkey2 = this.$('#orden2_key2');

            // Rerence inputs areasp
            this.$inputarea = this.$('#orden6_nombre');
            this.$inputvalor = this.$('#orden6_valor');

            // Inputs cuadro de informacion
            this.$inputround = this.$('#orden2_round');
            this.$inputvolumen = this.$('#orden2_volumen');
            this.$inputmargenmaterialp = this.$('#orden2_margen_materialp');
            this.$inputmargenempaque = this.$('#orden2_margen_empaque');

            // Informacion Cotizacion
            this.$infoprecio = this.$('#info-precio');
            this.$infoviaticos = this.$('#info-viaticos');
            this.$infotransporte = this.$('#info-transporte');
            this.$infoprevmateriales = this.$('#info-prev-materiales');
            this.$infomateriales = this.$('#info-materiales');
            this.$infoprevempaques = this.$('#info-prev-empaques');
            this.$infoempaques = this.$('#info-empaques');
            this.$infoareas = this.$('#info-areas');
            this.$infosubtotal = this.$('#info-subtotal');
            this.$infocomision = this.$('#info-comision');
            this.$infototal = this.$('#info-total');

            // Variables globales
            this.range = [-3, -2, -1, 0, 1, 2, 3];

            // Reference views
            this.spinner = this.$('#spinner-main');
            this.referenceViews();
            this.uploadPictures();
            this.ready();
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            var dataFilter = { productop: this.parameters.data.orden2_productop };

            // Model exist
            if( this.model.id != undefined ) {
                dataFilter.orden2 = this.model.get('id');
                dataFilter.productop = this.model.get('orden2_productop');
            }

            // Materiales
            this.materialesProductopOrdenListView = new app.MaterialesProductopOrdenListView( {
                collection: this.materialesProductopOrdenList,
                model: this.model,
                parameters: {
                    edit: true,
                    wrapper: $('#materialp-wrapper-producto'),
                    dataFilter: dataFilter
                }
            });

            // Empaques
            this.empaquesProductopOrdenListView = new app.EmpaquesProductopOrdenListView( {
                collection: this.empaquesProductopOrdenList,
                model: this.model,
                parameters: {
                    edit: true,
                    wrapper: $('#empaque-wrapper-producto'),
                    dataFilter: dataFilter
                }
            });

            // Areas
            this.areasProductopOrdenListView = new app.AreasProductopOrdenListView( {
                collection: this.areasProductopOrdenList,
                model: this.model,
                parameters: {
                    edit: true,
                    wrapper: $('#areap-wrapper-producto'),
                    dataFilter: dataFilter
               }
            });
        },

        /**
        * Event change check tiro \\ retiro
        */
        checkType: function (e) {
            var selected = this.$(e.currentTarget).is(':checked');
                type = this.$(e.currentTarget).val();

            if (type == 'orden2_tiro') {
                this.$inputyellow.iCheck(selected ? 'check' : 'uncheck');
                this.$inputmagenta.iCheck(selected ? 'check' : 'uncheck');
                this.$inputcyan.iCheck(selected ? 'check' : 'uncheck');
                this.$inputkey.iCheck(selected ? 'check' : 'uncheck');
            } else {
                this.$inputyellow2.iCheck(selected ? 'check' : 'uncheck');
                this.$inputmagenta2.iCheck(selected ? 'check' : 'uncheck');
                this.$inputcyan2.iCheck(selected ? 'check' : 'uncheck');
                this.$inputkey2.iCheck(selected ? 'check' : 'uncheck');
            }
        },

        /**
        * Event change formulas
        */
        changeFormula: function (e) {
            var reg = /[0-9/\+/\-/\*/\/\/\./\(/\)/]/,
                string = this.$(e.currentTarget).val(),
                response = this.$(e.currentTarget).data('response'),
                valor  = '';

             for (var i = 0; i <= string.length - 1; i++) {
                if( reg.test( string.charAt(i) ) ){
                    valor += string.charAt(i);
                }
            }

            // remplazar campos no validos y hacer operacion matematica
            this.$(e.currentTarget).val(valor);
            this.$('#' + response).val(eval(valor)).trigger('change');
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

                /**
                * En el metodo post o crear es necesario mandar las imagenes preguardadas por ende se convierte toda la peticion en un texto plano FormData
                * El metodo put no es compatible con formData
                */
                if( this.model.id != undefined ){
                    var data = $.extend({}, window.Misc.formToJson( e.target ), this.parameters.data);
                        data.orden2_margen_materialp = this.$inputmargenmaterialp.val();
                        data.orden2_margen_empaque = this.$inputmargenempaque.val();
                        data.orden2_volumen = this.$inputvolumen.val();
                        data.orden2_round = this.$inputround.val();
                        data.materialesp = this.materialesProductopOrdenList.toJSON();
                        data.empaques = this.empaquesProductopOrdenList.toJSON();
                        data.areasp = this.areasProductopOrdenList.toJSON();

                    this.model.save(data, {silent: true});

                }else{
                    var data = $.extend({}, window.Misc.formToJson( e.target ), this.parameters.data);
                        data.orden2_margen_materialp = this.$inputmargenmaterialp.val();
                        data.orden2_margen_empaque = this.$inputmargenempaque.val();
                        data.orden2_volumen = this.$inputvolumen.val();
                        data.orden2_round = this.$inputround.val();
                        data.materialesp = JSON.stringify(this.materialesProductopOrdenList);
                        data.empaques = JSON.stringify(this.empaquesProductopOrdenList);
                        data.areasp = JSON.stringify(this.areasProductopOrdenList);

                    this.$files = this.$uploaderFile.fineUploader('getUploads', {status: 'submitted'});
                    var formData = new FormData();
                    _.each(this.$files, function(file, key){
                        formData.append('imagenes[]', file.file );
                    });

                    // Recorrer archivos para mandarlos texto plano
                    _.each(data, function(value, key){
                        formData.append(key, value);
                    });

                    this.model.save(null, {
                        data: formData,
                        silent: true,
                        processData: false,
                        contentType: false
                    });
                }
            }
        },

        /**
        * Event onStore items
        */
        onStoreMaterialp: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = $.extend({}, window.Misc.formToJson( e.target ), this.parameters.data);
                    data.orden4_cantidad = this.$('#orden4_cantidad:disabled').val();
                this.materialesProductopOrdenList.trigger('store' , data, this.$formmaterialp);
            }
        },

        /**
        * Event onStore items
        */
        onStoreEmpaquep: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = $.extend({}, window.Misc.formToJson( e.target ), this.parameters.data);
                    data.orden9_cantidad = this.$('#orden9_cantidad:disabled').val();
                this.empaquesProductopOrdenList.trigger('store' , data, this.$formempaque);
            }
        },

        /**
        * Event onStore items
        */
        onStoreAreap: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = $.extend({}, window.Misc.formToJson( e.target ), this.parameters.data);
                this.areasProductopOrdenList.trigger('store' , data, this.$formareap);
            }
        },

        /**
        * Event change materialp
        */
        changeMaterialp: function (e) {
            var materialp = this.$(e.currentTarget).val(),
                _this = this;

            // Reference
            this.$referenceselected = this.$('#' + this.$(e.currentTarget).data('field'));
            this.$referencewrapper = this.$('#' + this.$(e.currentTarget).data('wrapper'));
            this.$selectedinput = this.$('#' + this.$referenceselected.data('valor'));
            this.$selectedhistorial = this.$('#' + this.$referenceselected.data('historial'));

            if( typeof(materialp) !== 'undefined' && !_.isUndefined(materialp) && !_.isNull(materialp) && materialp != '' ){
                window.Misc.setSpinner( this.$referencewrapper );
                $.get(window.Misc.urlFull( Route.route('productos.index', {materialp: materialp}) ), function (resp){
                    if (resp.length) {
                        _this.$referenceselected.empty().val(0).removeAttr('disabled');
                        _this.$referenceselected.append("<option value=></option>");
                        _.each(resp, function(item){
                            _this.$referenceselected.append("<option value="+item.id+">"+item.producto_nombre+"</option>");
                        });
                    } else {
                        _this.$referenceselected.empty().val(0).prop('disabled', true);
                        _this.$selectedinput.val(0);
                        _this.$selectedhistorial.empty();
                    }
                    window.Misc.removeSpinner( _this.$referencewrapper );
                });
            } else {
                this.$referenceselected.empty().val(0).prop('disabled', true);
                this.$selectedinput.val(0);
                this.$selectedhistorial.empty();
            }
        },

        /**
        * Event change insumo
        */
        changeInsumo: function (e) {
            var _this = this;
                insumo = this.$(e.currentTarget).val();
                call = this.$(e.currentTarget).data('historial').split('_')[1];
                url = '';

            // Reference
            this.$selectinsumo = this.$(e.currentTarget);
            this.$inputinsumo = this.$('#' + this.$selectinsumo.data('valor'));
            this.$historialinsumo = this.$('#' + this.$selectinsumo.data('historial'));

            if (insumo) {
                if (call == 'orden4') {
                    url = window.Misc.urlFull( Route.route('ordenes.productos.materiales.index', {insumo: insumo}));
                    call = 'materialp';
                } else {
                    url = window.Misc.urlFull( Route.route('ordenes.productos.empaques.index', {insumo: insumo}));
                    call = 'empaque';
                }

                $.get(url, function (resp) {
                    if (resp) {
                        _this.$inputinsumo.val(resp.valor);
                        _this.$historialinsumo.empty().append( $('<small>').addClass('text-muted').append("Ver historial de insumo") ).attr('data-resource', insumo).attr('data-call', call);
                    }
                });
            } else {
                this.$inputinsumo.val(0);
                this.$historialinsumo.empty();
            }
        },

        /**
        * Event change areap
        */
        changeAreap: function (e) {
            var _this = this;
                areap = this.$(e.currentTarget).val();

            // Reference
            if( typeof(areap) !== 'undefined' && !_.isUndefined(areap) && !_.isNull(areap) && areap != '' ){
                $.get(window.Misc.urlFull( Route.route('areasp.show', {areasp: areap}) ), function (resp){
                    if (resp) {
                        _this.$inputarea.val('').attr('readonly', true);
                        _this.$inputvalor.val(resp.areap_valor);
                    }
                });
            } else {
                this.$inputarea.val('').attr('readonly', false);
                this.$inputvalor.val('');
            }
        },

        /**
        * Event calculate total
        */
        totalCalculate: function () {
            // Igualar variables y quitar el inputmask
            var cantidad = parseInt(this.$('#orden2_cantidad').val());
            var precio = parseFloat(this.$('#orden2_precio_venta').inputmask('unmaskedvalue'));
            var tranporte = Math.round(parseFloat(this.$('#orden2_transporte').inputmask('unmaskedvalue'))/cantidad);
            var viaticos = Math.round(parseFloat(this.$('#orden2_viaticos').inputmask('unmaskedvalue'))/cantidad);
            var materiales = Math.round(parseFloat(this.materialesProductopOrdenList.totalize().total)/cantidad);
            var prevmateriales = materiales;
            var empaques = Math.round(parseFloat(this.empaquesProductopOrdenList.totalize().total)/cantidad);
            var prevempaques = empaques;
            var areas = Math.round(parseFloat(this.areasProductopOrdenList.totalize().total)/cantidad);
            var volumen = parseInt(this.$inputvolumen.val());

            if (this.$inputmargenmaterialp.val() >= 100) {
                this.$inputmargenmaterialp.val(99);
            } else if (!this.$inputmargenmaterialp.val()) {
                this.$inputmargenmaterialp.val(0);
            }

            if (this.$inputmargenempaque.val() >= 100) {
                this.$inputmargenempaque.val(99);
            } else if (!this.$inputmargenempaque.val()) {
                this.$inputmargenempaque.val(0);
            }

            // Calcular que no pase de 100% y no se undefinde
            margenmaterial = this.$inputmargenmaterialp.val();
            if( margenmaterial > 0 && margenmaterial <= 99 && !_.isUndefined(margenmaterial) && !_.isNaN(margenmaterial) ) {
                materiales = materiales/((100-margenmaterial)/100);
            }

            // Calcular que no pase de 100% y no se undefinde
            margenempaque = this.$inputmargenempaque.val();
            if( margenempaque > 0 && margenempaque <= 99 && !_.isUndefined(margenempaque) && !_.isNaN(margenempaque) ) {
                empaques = empaques/((100-margenempaque)/100);
            }

            // Cuadros de informacion
            this.$infoprecio.empty().html(window.Misc.currency(precio));
            this.$infoviaticos.empty().html(window.Misc.currency(viaticos));
            this.$infotransporte.empty().html(window.Misc.currency(tranporte));
            this.$infoareas.empty().html(window.Misc.currency(areas));
            this.$infoprevmateriales.empty().html(window.Misc.currency(prevmateriales));
            this.$infomateriales.empty().html(window.Misc.currency(materiales));
            this.$infoprevempaques.empty().html(window.Misc.currency(prevempaques));
            this.$infoempaques.empty().html(window.Misc.currency(empaques));

            // Calcular total de la orden (transporte+viaticos+precio+areas)
            subtotal = precio + tranporte + viaticos + materiales + empaques + areas;
            vcomision = (subtotal/((100-volumen)/100)) * (1-(((100-volumen)/100)));
            total = subtotal + vcomision;

            round = parseInt( this.$inputround.val() );
            if (this.range.indexOf(round) != -1) {
                // Calcular round decimales
                var exp = Math.pow(10, round);
                total = Math.round(total*exp)/exp;
            } else {
                this.$inputround.val(0);
            }

            this.$infosubtotal.html('$ ' + window.Misc.currency(subtotal));
            this.$infocomision.html('$ ' + window.Misc.currency(vcomision));
            this.$infototal.html('$ ' + window.Misc.currency(total));
        },

        /**
        * UploadPictures
        */
        uploadPictures: function(e) {
            var _this = this,
                autoUpload = false;
                session = {};
                deleteFile = {};
                request = {};

            // Model exists
            if( this.model.id != undefined ){
                var session = {
                    endpoint: window.Misc.urlFull( Route.route('ordenes.productos.imagenes.index') ),
                    params: {
                        orden2: this.model.get('id'),
                    },
                    refreshOnRequest: false
                }

                var deleteFile = {
                    enabled: true,
                    forceConfirm: true,
                    confirmMessage: '¿Esta seguro de que desea eliminar este archivo de forma permanente? {filename}',
                    endpoint: window.Misc.urlFull( Route.route('ordenes.productos.imagenes.index') ),
                    params: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        orden2: this.model.get('id')
                    }
                }

                var request = {
                    inputName: 'file',
                    endpoint: window.Misc.urlFull( Route.route('ordenes.productos.imagenes.index') ),
                    params: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        orden2: this.model.get('id')
                    }
                }

                var autoUpload = true;
            }

            this.$uploaderFile.fineUploader({
                debug: false,
                template: 'qq-template',
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

        /**
        * complete upload of file
        * @param Number id
        * @param Strinf name
        * @param Object resp
        */
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

            if( typeof window.initComponent.initICheck == 'function' )
                window.initComponent.initICheck();

            if( typeof window.initComponent.initInputMask == 'function' )
                window.initComponent.initInputMask();
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

                // Redirect to orden
                window.Misc.redirect( window.Misc.urlFull(Route.route('ordenes.edit', { ordenes: resp.id_orden })) );
            }
        }
    });

})(jQuery, this, this.document);
