/**
* Class ShowOrdenp2View
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ShowOrdenp2View = Backbone.View.extend({

        el: '#ordenes-productos-show',

        /**
        * Constructor Method
        */
        initialize : function() {
            _.bindAll(this, 'onSessionRequestComplete');

            // Recuperar fineuploader container
            this.$uploaderFile = this.$('.fine-uploader');
            this.uploadPictures();
        },

        /**
        * UploadPictures
        */
        uploadPictures: function(e) {
            var _this = this;

            this.$uploaderFile.fineUploader({
                debug: false,
                template: 'qq-template-ordenp-producto',
                autoUpload: true,
                dragDrop: false,
                session: {
                    endpoint: window.Misc.urlFull( Route.route('ordenes.productos.imagenes.index') ),
                    params: {
                        orden2: _this.model.get('id'),
                    },
                    refreshOnRequest: false
                },
                request: {
                    inputName: 'file',
                    endpoint: window.Misc.urlFull( Route.route('ordenes.productos.imagenes.index') ),
                    params: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        orden2: this.model.get('id')
                    }
                },
                deleteFile: {
                    enabled: true,
                    forceConfirm: true,
                    confirmMessage: '¿Esta seguro de que desea eliminar este archivo de forma permanente? {filename}',
                    endpoint: window.Misc.urlFull( Route.route('ordenes.productos.imagenes.index') ),
                    params: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        orden2: this.model.get('id')
                    }
                },
                retry: {
                    maxAutoAttempts: 3
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

            this.$uploaderFile.find('.qq-upload-drop-area').remove();
        },

        onSessionRequestComplete: function (id, name, resp) {
            this.$uploaderFile.find('.btn-imprimir').remove();

            _.each( id, function (value, key){
                var previewLink = this.$uploaderFile.fineUploader('getItemByFileId', key).find('.preview-link');
                previewLink.attr("href", value.thumbnailUrl);
            }, this);
        },
    });

})(jQuery, this, this.document);
