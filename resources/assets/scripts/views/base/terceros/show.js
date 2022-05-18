/**
* Class ShowTerceroView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ShowTerceroView = Backbone.View.extend({

        el: '#terceros-show',

        /**
        * Constructor Method
        */
        initialize: function () {
            _.bindAll(this, 'onSessionRequestComplete');

            this.contactsList = new app.ContactsList();
            this.facturaptList = new app.FacturaptList();
            this.rolList = new app.RolList();
            this.detalleFacturaList = new app.DetalleFactura4List();
            this.$uploaderFile = this.$('.fine-uploader');

            // Reference views
            this.uploadPictures();
            this.referenceViews();
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            // Contact list
            this.contactsListView = new app.ContactsListView( {
                collection: this.contactsList,
                parameters: {
                    edit: false,
                    dataFilter: {
                        tercero_id: this.model.get('id')
                    }
               }
            });

            // Rol list
            this.rolesListView = new app.RolesListView( {
                collection: this.rolList,
                parameters: {
                    edit: false,
                    wrapper: this.$('#wrapper-roles'),
                    dataFilter: {
                        tercero_id: this.model.get('id')
                    }
               }
            });

            // Facturap list
            this.facturaptListView = new app.FacturaptListView( {
                collection: this.facturaptList,
                parameters: {
                    dataFilter: {
                        tercero_id: this.model.get('id')
                    }
               }
            });

            // Detalle list
            this.factura4ListView = new app.Factura4ListView({
                collection: this.detalleFacturaList,
                parameters: {
                    edit: false,
                    template: _.template( ($('#add-detalle-factura-cartera-tpl').html() || '') ),
                    call: 'tercero',
                    dataFilter: {
                        tercero_id: this.model.get('id'),
                    }
                }
            });
        },

        /**
        * UploadPictures
        */
        uploadPictures: function (e) {
            var _this = this;

            this.$uploaderFile.fineUploader({
                debug: false,
                template: 'qq-template-tercero',
                dragDrop: false,
                session: {
                    endpoint: window.Misc.urlFull( Route.route('terceros.imagenes.index') ),
                    params: {
                        tercero_id: _this.model.get('id'),
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

        onSessionRequestComplete: function (id, name, resp) {
            _.each(id, function (value, key){
                var previewLink = this.$uploaderFile.fineUploader('getItemByFileId', key).find('.preview-link');
                    previewLink.attr("href", value.thumbnailUrl);
            }, this);
        },
    });

})(jQuery, this, this.document);
