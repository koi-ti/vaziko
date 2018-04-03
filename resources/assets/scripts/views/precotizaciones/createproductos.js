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
            _.bindAll(this, 'onSessionRequestComplete', 'onSubmitFile');

            // Initialize
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            // Attributes
            this.$wraperForm = this.$('#render-form-precotizacion-producto');
            this.materialesProductopPreCotizacionList = new app.MaterialesProductopPreCotizacionList();
            this.$files = [];

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
            this.$formdetalle = this.$('#form-precotizacion3-producto');
            this.$uploaderFile = this.$('#fine-uploader');

            // Reference views
            this.referenceViews();
            this.uploadPictures();
            this.ready();
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            var dataFilter = { productop: this.parameters.data.precotizacion2_productop };

            // Model exist
            if( this.model.id != undefined ) {
                dataFilter.precotizacion2 = this.model.get('id');
                dataFilter.productop = this.model.get('precotizacion2_productop');
            }

            // Materiales li, ateCotizacion2st
            this.materialesProductopPreCotizacionListView = new app.MaterialesProductopPreCotizacionListView( {
                collection: this.materialesProductopPreCotizacionList,
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

                var data = $.extend({}, window.Misc.formToJson( e.target ), this.parameters.data);
                    data.detalle = this.materialesProductopPreCotizacionList.toJSON();

                this.model.save( data, {silent: true} );
            }
        },

        /**
        * Event submit productop
        */
        submitPreCotizacion3: function (e) {
            this.$formdetalle.submit();
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
                paramsInBody: false,
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
                    onSubmit: _this.onSubmitFile,
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

        onSubmitFile: function (id, name) {
            var file = this.$uploaderFile.fineUploader('getFile', id);
            this.$files.push( file );
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
                if( this.$files.length > 0 ){
                    var _this = this;

                    var formData = new FormData();
                        formData.append('precotizacion2', this.model.get('id'));

                    _.each(this.$files, function(file, key){
                        formData.append('imagenes[]', file);
                    });

                    $.ajax({
                        url: window.Misc.urlFull( Route.route('precotizaciones.productos.imagenes.store') ),
                        data: formData,
                        type: 'POST',
                        cache: false,
                        contentType: false,
                        processData: false,
                        beforeSend: function() {
                            window.Misc.setSpinner( _this.$wrapper );
                        }
                    })
                    .done(function(resp) {
                        window.Misc.removeSpinner( _this.$wrapper );
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
                        window.Misc.removeSpinner( _this.$wrapper );
                        alertify.error(thrownError);
                    });
                }

                // Redirect to cotizacion
                window.Misc.redirect( window.Misc.urlFull(Route.route('precotizaciones.edit', { precotizaciones: this.model.get('precotizacion2_precotizacion1') })) );
            }
        }
    });

})(jQuery, this, this.document);
