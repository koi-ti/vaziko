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
            'click .submit-precotizacion3': 'submitPreCotizacion3',
            'submit #form-precotizacion3-producto': 'onStorePreCotizacion3',
            'change #precotizacion3_materialp': 'changeMaterialp',
            'click .submit-precotizacion5': 'submitPreCotizacion5',
            'submit #form-precotizacion5-producto': 'onStorePreCotizacion5',
            'change #precotizacion6_areap': 'changeAreap',
            'click .submit-precotizacion6': 'submitPreCotizacion6',
            'submit #form-precotizacion6-producto': 'onStorePreCotizacion6',
        },
        parameters: {
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
            _.bindAll(this, 'onSessionRequestComplete');

            // Initialize
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            // Attributes
            this.$wraperForm = this.$('#render-form-precotizacion-producto');
            this.materialesProductopPreCotizacionList = new app.MaterialesProductopPreCotizacionList();
            this.impresionesProductopPreCotizacionList = new app.ImpresionesProductopPreCotizacionList();
            this.areasProductopPreCotizacionList = new app.AreasProductopPreCotizacionList();

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
            this.$wraperForm.html( this.template(attributes) );

            this.$form = this.$('#form-precotizacion-producto');
            this.$formmaterialesp = this.$('#form-precotizacion3-producto');
            this.$formimpresiones = this.$('#form-precotizacion5-producto');
            this.$formareasp = this.$('#form-precotizacion6-producto');
            this.$uploaderFile = this.$('#fine-uploader');

            // Rerence inputs materialp
            this.$selectinsumos = this.$('#precotizacion3_producto');

            // Rerence inputs areasp
            this.$inputArea = this.$('#precotizacion6_nombre');
            this.$inputTiempo = this.$('#precotizacion6_tiempo');
            this.$inputValor = this.$('#precotizacion6_valor');

            // Reference views
            this.referenceViews();
            this.uploadPictures();
            this.ready();
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            // Materiales , Precotizacion2
            this.materialesProductopPreCotizacionListView = new app.MaterialesProductopPreCotizacionListView( {
                collection: this.materialesProductopPreCotizacionList,
                parameters: {
                    edit: true,
                    dataFilter: {
                        precotizacion2: this.model.get('id')
                    }
               }
            });

            this.impresionesProductopPreCotizacionListView = new app.ImpresionesProductopPreCotizacionListView( {
                collection: this.impresionesProductopPreCotizacionList,
                parameters: {
                    edit: true,
                    dataFilter: {
                        precotizacion2: this.model.get('id')
                    }
               }
            });

            // Areasp list
            this.areasProductopPreCotizacionListView = new app.AreasProductopPreCotizacionListView( {
                collection: this.areasProductopPreCotizacionList,
                model: this.model,
                parameters: {
                    edit: true,
                    dataFilter: {
                        precotizacion2: this.model.get('id')
                    }
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

                var data = $.extend({}, window.Misc.formToJson( e.target ), this.parameters.data);
                    data.materialesp = this.materialesProductopPreCotizacionList.toJSON();
                    data.impresiones = this.impresionesProductopPreCotizacionList.toJSON();
                    data.areasp = this.areasProductopPreCotizacionList.toJSON();

                this.model.save( data, {silent: true} );
            }
        },

        /**
        * Event submit productop
        */
        submitPreCotizacion3: function (e) {
            this.$formmaterialesp.submit();
        },

        /**
        * Event Create
        */
        onStorePreCotizacion3: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = $.extend({}, window.Misc.formToJson( e.target ), this.parameters.data);
                this.materialesProductopPreCotizacionList.trigger( 'store' , data );
            }
        },

        /**
        * Event change select materialp
        */
        changeMaterialp: function (e) {
            var _this = this;
                materialp = this.$(e.currentTarget).val();

            if( typeof(materialp) !== 'undefined' && !_.isUndefined(materialp) && !_.isNull(materialp) && materialp != '' ){
                $.ajax({
                    url: window.Misc.urlFull( Route.route('productos.index', {materialp: materialp}) ),
                    type: 'GET',
                    beforeSend: function() {
                        window.Misc.setSpinner( _this.el );
                    }
                })
                .done(function(resp) {
                    window.Misc.removeSpinner( _this.el );

                    _this.$selectinsumos.empty().val(0).removeAttr('disabled');
                    _this.$selectinsumos.append("<option value=></option>");
                    _.each(resp, function(item){
                        _this.$selectinsumos.append("<option value="+item.id+">"+item.producto_nombre+"</option>");
                    });
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    window.Misc.removeSpinner( _this.el );
                    alertify.error(thrownError);
                });
            }else{
                this.$selectinsumos.empty().val(0).attr('disabled', 'disabled');
            }
        },

        /**
        * Event submit productop
        */
        submitPreCotizacion5: function (e) {
            this.$formimpresiones.submit();
        },

        /**
        * Event Create
        */
        onStorePreCotizacion5: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = $.extend({}, window.Misc.formToJson( e.target ), this.parameters.data);
                this.impresionesProductopPreCotizacionList.trigger('store' , data);
            }
        },

        /**
        * Event submit productop
        */
        submitPreCotizacion6: function (e) {
            this.$formareasp.submit();
        },

        /**
        * Event Create
        */
        onStorePreCotizacion6: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = $.extend({}, window.Misc.formToJson( e.target ), this.parameters.data);
                this.areasProductopPreCotizacionList.trigger('store' , data);
            }
        },

        /**
        *   Event render input value
        **/
        changeAreap: function(e){
            var _this = this;
                id = this.$(e.currentTarget).val();

            if( typeof(id) !== 'undefined' && !_.isUndefined(id) && !_.isNull(id) && id != '' ){
                $.ajax({
                    url: window.Misc.urlFull( Route.route('areasp.show', {areasp: id}) ),
                    type: 'GET',
                    beforeSend: function() {
                        window.Misc.setSpinner( _this.spinner );
                    }
                })
                .done(function(resp) {
                    window.Misc.removeSpinner( _this.spinner );

                    _this.$inputArea.val('').attr('readonly', true);
                    _this.$inputTiempo.val('');
                    _this.$inputValor.val( resp.areap_valor );
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    window.Misc.removeSpinner( _this.spinner );
                    alertify.error(thrownError);
                });
            }else{
                this.$inputArea.val('').attr('readonly', false);
                this.$inputTiempo.val('');
                this.$inputValor.val('');
            }
        },

        /**
        * UploadPictures
        */
        uploadPictures: function(e) {
            var _this = this,
                session = {};
                deleteFile = {};

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
            }

            this.$uploaderFile.fineUploader({
                debug: false,
                template: 'qq-template',
                multiple: true,
                interceptSubmit: true,
                autoUpload: false,
                omitDefaultParams: true,
                session: session,
                request: {
                    inputName: 'file',
                    endpoint: window.Misc.urlFull( Route.route('precotizaciones.productos.imagenes.index') ),
                },
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
                    sizeLimit: ( 4 * 1024 ) * 1024, // 4mb,
                    allowedExtensions: ['jpeg', 'jpg', 'png', 'pdf']
                },
                messages: {
                    typeError: '{file} extensión no valida. Extensiones validas: {extensions}.',
                    sizeError: '{file} es demasiado grande, el tamaño máximo del archivo es {sizeLimit}.',
                    tooManyItemsError: 'No puede seleccionar mas de {itemLimit} archivos.',
                },
                callbacks: {
                    onSessionRequestComplete: _this.onSessionRequestComplete,
                },
            });
        },

        onSessionRequestComplete: function (id, name, resp) {
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
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function (model, xhr, opts) {
            window.Misc.setSpinner( this.el );
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            window.Misc.removeSpinner( this.el );
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

                // Subir imagenes
                this.$files = this.$uploaderFile.fineUploader('getUploads', {status: 'submitted'});
                if( this.$files.length > 0 ){
                    var _this = this;

                    var formData = new FormData();
                        formData.append('precotizacion2', this.model.get('id'));

                    // Traer archivos agregados correctamente
                    _.each(this.$files, function(file, key){
                        formData.append('imagenes[]', file.file);
                    });

                    $.ajax({
                        url: window.Misc.urlFull( Route.route('precotizaciones.productos.imagenes.store') ),
                        data: formData,
                        type: 'POST',
                        cache: false,
                        contentType: false,
                        processData: false,
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

                            // Redirect to cotizacion
                            window.Misc.redirect( window.Misc.urlFull(Route.route('precotizaciones.edit', { precotizaciones: _this.model.get('precotizacion2_precotizacion1') })) );
                        }
                    })
                    .fail(function(jqXHR, ajaxOptions, thrownError) {
                        window.Misc.removeSpinner( _this.el );
                        alertify.error(thrownError);
                    });
                }else{
                    // Redirect to cotizacion
                    window.Misc.redirect( window.Misc.urlFull(Route.route('precotizaciones.edit', { precotizaciones: this.model.get('precotizacion2_precotizacion1') })) );
                }
            }
        }
    });

})(jQuery, this, this.document);
