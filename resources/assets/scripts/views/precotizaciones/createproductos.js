/**
* Class CreatePreCotizacion2View  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreatePreCotizacion2View = Backbone.View.extend({

        el: '#precotizaciones-productos-create',
        template: _.template( ($('#add-precotizacion-producto-tpl').html() || '') ),
        events: {
            'click .submit-precotizacion2': 'submitForm',
            'submit #form-precotizacion-producto': 'onStore',
            'ifChanged .check-type': 'checkType',
            'submit #form-materialp-producto': 'onStoreMaterialp',
            'submit #form-empaque-producto': 'onStoreEmpaquep',
            'submit #form-areap-producto': 'onStoreAreap',
            'change .change-materialp': 'changeMaterialp',
            'change .change-insumo': 'changeInsumo',
            'change #precotizacion6_areap': 'changeAreap'
        },
        parameters: {
            data: {
                precotizacion2_productop: null
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
            this.materialesProductopPreCotizacionList = new app.MaterialesProductopPreCotizacionList();
            this.empaquesProductopPreCotizacionList = new app.EmpaquesProductopPreCotizacionList();
            this.areasProductopPreCotizacionList = new app.AreasProductopPreCotizacionList();

            // Events
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );

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
            this.$form = this.$('#form-precotizacion-producto');
            this.$formmaterialp = this.$('#form-materialp-producto');
            this.$formempaque = this.$('#form-empaque-producto');
            this.$formareap = this.$('#form-areap-producto');

            // reference uplaoadfile
            this.$uploaderFile = this.$('.fine-uploader');

            // Tiro
            this.$inputYellow = this.$('#precotizacion2_yellow');
            this.$inputMagenta = this.$('#precotizacion2_magenta');
            this.$inputCyan = this.$('#precotizacion2_cyan');
            this.$inputKey = this.$('#precotizacion2_key');

            // Retiro
            this.$inputYellow2 = this.$('#precotizacion2_yellow2');
            this.$inputMagenta2 = this.$('#precotizacion2_magenta2');
            this.$inputCyan2 = this.$('#precotizacion2_cyan2');
            this.$inputKey2 = this.$('#precotizacion2_key2');

            // Rerence inputs areasp
            this.$inputArea = this.$('#precotizacion6_nombre');
            this.$inputValor = this.$('#precotizacion6_valor');

            // Render spinner
            this.spinner = this.$('.spinner-main');
            this.referenceViews();
            this.uploadPictures();
            this.ready();
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
                        data.materialesp = this.materialesProductopPreCotizacionList.toJSON();
                        data.empaques = this.empaquesProductopPreCotizacionList.toJSON();
                        data.areasp = this.areasProductopPreCotizacionList.toJSON();

                    this.model.save( data, {path: true, silent: true});

                } else {
                    var data = $.extend({}, window.Misc.formToJson( e.target ), this.parameters.data);
                        data.materialesp = JSON.stringify(this.materialesProductopPreCotizacionList);
                        data.empaques = JSON.stringify(this.empaquesProductopPreCotizacionList);
                        data.areasp = JSON.stringify(this.areasProductopPreCotizacionList);

                    this.$files = this.$uploaderFile.fineUploader('getUploads', {status: 'submitted'});
                    var formData = new FormData();
                    _.each(this.$files, function(file, key){
                        formData.append('imagenes[]', file.file );
                    });

                    // Recorrer archivos para mandarlos texto plano
                    _.each(data, function(value, key){
                        formData.append(key, value);
                    });

                    this.model.save( null, {
                        data: formData,
                        processData: false,
                        silent: true,
                        contentType: false
                    });
                }
            }
        },

        /**
        * Event change check tiro \\ retiro
        */
        checkType: function (e) {
            var selected = this.$(e.currentTarget).is(':checked');
                type = this.$(e.currentTarget).val();

            if (type == 'precotizacion2_tiro') {
                this.$inputYellow.iCheck(selected ? 'check' : 'uncheck');
                this.$inputMagenta.iCheck(selected ? 'check' : 'uncheck');
                this.$inputCyan.iCheck(selected ? 'check' : 'uncheck');
                this.$inputKey.iCheck(selected ? 'check' : 'uncheck');
            } else {
                this.$inputYellow2.iCheck(selected ? 'check' : 'uncheck');
                this.$inputMagenta2.iCheck(selected ? 'check' : 'uncheck');
                this.$inputCyan2.iCheck(selected ? 'check' : 'uncheck');
                this.$inputKey2.iCheck(selected ? 'check' : 'uncheck');
            }
        },

        /**
        * Event Create
        */
        onStoreMaterialp: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = $.extend({}, window.Misc.formToJson( e.target ), this.parameters.data);
                    data.precotizacion3_cantidad = this.$('#precotizacion3_cantidad:disabled').val();
                this.materialesProductopPreCotizacionList.trigger('store', data, this.$formmaterialp);
            }
        },

        /**
        * Event Create
        */
        onStoreEmpaquep: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = $.extend({}, window.Misc.formToJson( e.target ), this.parameters.data);
                    data.precotizacion9_cantidad = this.$('#precotizacion9_cantidad:disabled').val();
                this.empaquesProductopPreCotizacionList.trigger('store', data, this.$formempaque);
            }
        },

        /**
        * Event Create
        */
        onStoreAreap: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = $.extend({}, window.Misc.formToJson( e.target ), this.parameters.data);
                this.areasProductopPreCotizacionList.trigger('store', data, this.$formareap);
            }
        },

        /**
        * Event change materialp
        */
        changeMaterialp: function (e) {
            var materialp = this.$(e.currentTarget).val(),
                reference = this.$(e.currentTarget).data('reference'),
                _this = this;

            // Reference
            this.$referenceselected = this.$('#' + this.$(e.currentTarget).data('field'));
            this.$referencewrapper = this.$('#' + this.$(e.currentTarget).data('wrapper'));
            this.$selectedinput = this.$('#' + this.$referenceselected.data('valor'));
            this.$selectedhistorial = this.$('#' + this.$referenceselected.data('historial'));

            if( typeof(materialp) !== 'undefined' && !_.isUndefined(materialp) && !_.isNull(materialp) && materialp != '' ){
                window.Misc.setSpinner( this.$referencewrapper );
                $.get(window.Misc.urlFull( Route.route('productos.index', {materialp: materialp, reference: reference}) ), function (resp){
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
                if (call == 'precotizacion3') {
                    url = window.Misc.urlFull( Route.route('precotizaciones.productos.materiales.index', {insumo: insumo}));
                    call = 'materialp';
                } else {
                    url = window.Misc.urlFull( Route.route('precotizaciones.productos.empaques.index', {insumo: insumo}));
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
                        _this.$inputArea.val('').attr('readonly', true);
                        _this.$inputValor.val(resp.areap_valor);
                    }
                });
            } else {
                this.$inputArea.val('').attr('readonly', false);
                this.$inputValor.val('');
            }
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            this.produtop = this.parameters.data.precotizacion2_productop;

            // Model exist
            if( this.model.id != undefined ) {
                this.produtop = this.model.get('precotizacion2_productop');
            }

            // Materiales
            this.materialesProductopPreCotizacionListView = new app.MaterialesProductopPreCotizacionListView( {
                collection: this.materialesProductopPreCotizacionList,
                parameters: {
                    edit: true,
                    wrapper: $('#materialesp-wrapper-producto'),
                    dataFilter: {
                        precotizacion2: this.model.get('id')
                    }
               }
            });

            // Empaques
            this.empaquesProductopPreCotizacionListView = new app.EmpaquesProductopPreCotizacionListView( {
                collection: this.empaquesProductopPreCotizacionList,
                parameters: {
                    edit: true,
                    wrapper: $('#empaques-wrapper-producto'),
                    dataFilter: {
                        precotizacion2: this.model.get('id')
                    }
               }
            });

            // Areasp
            this.areasProductopPreCotizacionListView = new app.AreasProductopPreCotizacionListView( {
                collection: this.areasProductopPreCotizacionList,
                parameters: {
                    edit: true,
                    wrapper: $('#areasp-wrapper-producto'),
                    dataFilter: {
                        precotizacion2: this.model.get('id')
                    }
               }
            });
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
                   endpoint: window.Misc.urlFull( Route.route('precotizaciones.productos.imagenes.index') ),
                   params: {
                       precotizacion2: this.model.get('id'),
                   },
                   refreshOnRequest: false
               }

               var deleteFile = {
                   enabled: true,
                   forceConfirm: true,
                   confirmMessage: '¿Esta seguro de que desea eliminar este archivo de forma permanente? {filename}',
                   endpoint: window.Misc.urlFull( Route.route('precotizaciones.productos.imagenes.index') ),
                   params: {
                       _token: $('meta[name="csrf-token"]').attr('content'),
                       precotizacion2: this.model.get('id')
                   }
               }

               var request = {
                   inputName: 'file',
                   endpoint: window.Misc.urlFull( Route.route('precotizaciones.productos.imagenes.index') ),
                   params: {
                       '_token': $('meta[name="csrf-token"]').attr('content'),
                       precotizacion2: this.model.get('id')
                   }
               }

               var autoUpload = true;
            }

            this.$uploaderFile.fineUploader({
               debug: false,
               template: 'qq-template-precotizacion',
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

            if( typeof window.initComponent.initSelect2 == 'function' )
                window.initComponent.initSelect2();

            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();

            if( typeof window.initComponent.initInputMask == 'function' )
                window.initComponent.initInputMask();

            if( typeof window.initComponent.initICheck == 'function' )
                window.initComponent.initICheck();
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

                // Redirect to cotizacion
                window.Misc.redirect( window.Misc.urlFull( Route.route('precotizaciones.edit', { precotizaciones: resp.id_precotizacion })) );
            }
        }
    });

})(jQuery, this, this.document);
