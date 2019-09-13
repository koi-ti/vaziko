/**
* Class ShowCotizacion2View
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ShowCotizacion2View = Backbone.View.extend({

        el: '#cotizaciones-productos-show',

        /**
        * Constructor Method
        */
        initialize : function() {
            _.bindAll(this, 'onCompleteLoadFile', 'onSessionRequestComplete');


            // Listen model
            this.listenTo( this.model, 'change', this.render );
        },

        render: function () {
            var attributes = this.model.toJSON();

            // Recuperar fineuploader container
            this.$uploaderFile = this.$('.fine-uploader');
            this.uploadPictures(attributes);
        },

        /**
        * UploadPictures
        */
        uploadPictures: function(model) {
            var _this = this;

            // Create object for default
            var object = {
                debug: false,
                template: 'qq-template-cotizacion-producto',
                dragDrop: false,
                session: {
                    endpoint: window.Misc.urlFull( Route.route('cotizaciones.productos.imagenes.index') ),
                    params: {
                        cotizacion2: _this.model.get('id'),
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
                    onComplete: _this.onCompleteLoadFile,
                    onSessionRequestComplete: this.onSessionRequestComplete
                }
            }

            // If continue append object
            if (model.continue) {
                object = Object.assign({
                    multiple: true,
                    autoUpload: true,
                    request: {
                        inputName: 'file',
                        endpoint: window.Misc.urlFull( Route.route('cotizaciones.productos.imagenes.index') ),
                        params: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            cotizacion2: _this.model.get('id')
                        }
                    },
                    retry: {
                        maxAutoAttempts: 3,
                    },
                    deleteFile: {
                        enabled: true,
                        forceConfirm: true,
                        confirmMessage: '¿Esta seguro de que desea eliminar este archivo de forma permanente? {filename}',
                        endpoint: window.Misc.urlFull( Route.route('cotizaciones.productos.imagenes.index') ),
                        params: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            cotizacion2: _this.model.get('id')
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
                    }
                }, object)
            }

            this.$uploaderFile.fineUploader(object);

            if (!model.continue) {
                this.$uploaderFile.find('.buttons').remove();
                this.$uploaderFile.find('.qq-upload-drop-area').remove();
            }
        },

        onSessionRequestComplete: function (id, name, resp) {
            this.$uploaderFile.find('.btn-imprimir').remove();

            _.each( id, function (value, key){
                var previewLink = this.$uploaderFile.fineUploader('getItemByFileId', key).find('.preview-link');
                previewLink.attr("href", value.thumbnailUrl);
            }, this);
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
    });

})(jQuery, this, this.document);
