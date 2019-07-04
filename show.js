/**
* Class ShowTerceroView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ShowTerceroView = Backbone.View.extend({

        el: '#tercero-show',

        /**
        * Constructor Method
        */
        initialize: function () {
            // BindAll
            _.bindAll(this, 'onSessionRequestComplete');

            // Validate if you can edit
            this.detalleContactosList = new app.DetalleContactosList();
            this.detalleParqueaderosList = new app.DetalleParqueaderosList();
            this.detalleContratosList = new app.DetalleContratosList();
            this.detalleOrdenesList = new app.DetalleOrdenesList();

            // Refences wrapper fineUploader
            this.$uploaderFile = this.$('.fine-uploader');

            this.referenceViews();
            this.uploadFiles();
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            // Contacto list
            this.detalleContactosListView = new app.DetalleContactosListView( {
                collection: this.detalleContactosList,
                parameters: {
                    edit: false,
                    dataFilter: {
                        tercero: this.model.get('id')
                    }
               }
            });

            // Parqueaderos list
            this.detalleParqueaderosListView = new app.DetalleParqueaderosListView( {
                collection: this.detalleParqueaderosList,
                parameters: {
                    dataFilter: {
                        tercero: this.model.get('id')
                    }
               }
            });

            // Contratos list
            this.detalleContratosListView = new app.DetalleContratosListView( {
                collection: this.detalleContratosList,
                parameters: {
                    dataFilter: {
                        tercero: this.model.get('id')
                    }
               }
            });

            // Ordenes list
            this.detalleOrdenesListView = new app.DetalleOrdenesListView( {
                collection: this.detalleOrdenesList,
                parameters: {
                    dataFilter: {
                        tercero: this.model.get('id')
                    }
               }
            });
        },

        /**
        * UploadFiles
        */
        uploadFiles: function(e) {
            var _this = this;

            this.$uploaderFile.fineUploader({
                debug: false,
                template: 'qq-template',
                dragDrop: false,
                button: null,
                session: {
                    endpoint: window.Misc.urlFull( Route.route('terceros.archivos.index') ),
                    params: {
                        tercero: this.model.get('id'),
                    },
                    refreshOnRequest: false
                },
                thumbnails: {
                    placeholders: {
                        notAvailablePath: window.Misc.urlFull("css/placeholders/not_available-generic.png"),
                        waitingPath: window.Misc.urlFull("css/placeholders/waiting-generic.png")
                    }
                },
                callbacks: {
                    onSessionRequestComplete: _this.onSessionRequestComplete,
                }
            });

            this.$uploaderFile.find('.qq-upload-button').remove();
            this.$uploaderFile.find('.qq-upload-drop-area').remove();
        },

        onSessionRequestComplete: function (id, name, resp) {
            _.each( id, function (value, key){
                var previewLink = this.$uploaderFile.fineUploader('getItemByFileId', key).find('.preview-link');
                previewLink.attr("href", value.thumbnailUrl);
            }, this);
        },
    });

})(jQuery, this, this.document);
